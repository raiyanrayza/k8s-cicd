<?php
 namespace MailPoetVendor\Doctrine\ORM\Persisters\Collection; if (!defined('ABSPATH')) exit; use MailPoetVendor\Doctrine\Common\Collections\Criteria; use MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata; use MailPoetVendor\Doctrine\ORM\Persisters\SqlExpressionVisitor; use MailPoetVendor\Doctrine\ORM\Persisters\SqlValueVisitor; use MailPoetVendor\Doctrine\ORM\PersistentCollection; use MailPoetVendor\Doctrine\ORM\Query; use MailPoetVendor\Doctrine\ORM\Utility\PersisterHelper; class ManyToManyPersister extends \MailPoetVendor\Doctrine\ORM\Persisters\Collection\AbstractCollectionPersister { public function delete(\MailPoetVendor\Doctrine\ORM\PersistentCollection $collection) { $mapping = $collection->getMapping(); if (!$mapping['isOwningSide']) { return; } $this->conn->executeUpdate($this->getDeleteSQL($collection), $this->getDeleteSQLParameters($collection)); } public function update(\MailPoetVendor\Doctrine\ORM\PersistentCollection $collection) { $mapping = $collection->getMapping(); if (!$mapping['isOwningSide']) { return; } list($deleteSql, $deleteTypes) = $this->getDeleteRowSQL($collection); list($insertSql, $insertTypes) = $this->getInsertRowSQL($collection); foreach ($collection->getDeleteDiff() as $element) { $this->conn->executeUpdate($deleteSql, $this->getDeleteRowSQLParameters($collection, $element), $deleteTypes); } foreach ($collection->getInsertDiff() as $element) { $this->conn->executeUpdate($insertSql, $this->getInsertRowSQLParameters($collection, $element), $insertTypes); } } public function get(\MailPoetVendor\Doctrine\ORM\PersistentCollection $collection, $index) { $mapping = $collection->getMapping(); if (!isset($mapping['indexBy'])) { throw new \BadMethodCallException("Selecting a collection by index is only supported on indexed collections."); } $persister = $this->uow->getEntityPersister($mapping['targetEntity']); $mappedKey = $mapping['isOwningSide'] ? $mapping['inversedBy'] : $mapping['mappedBy']; return $persister->load(array($mappedKey => $collection->getOwner(), $mapping['indexBy'] => $index), null, $mapping, array(), 0, 1); } public function count(\MailPoetVendor\Doctrine\ORM\PersistentCollection $collection) { $conditions = array(); $params = array(); $types = array(); $mapping = $collection->getMapping(); $id = $this->uow->getEntityIdentifier($collection->getOwner()); $sourceClass = $this->em->getClassMetadata($mapping['sourceEntity']); $targetClass = $this->em->getClassMetadata($mapping['targetEntity']); $association = !$mapping['isOwningSide'] ? $targetClass->associationMappings[$mapping['mappedBy']] : $mapping; $joinTableName = $this->quoteStrategy->getJoinTableName($association, $sourceClass, $this->platform); $joinColumns = !$mapping['isOwningSide'] ? $association['joinTable']['inverseJoinColumns'] : $association['joinTable']['joinColumns']; foreach ($joinColumns as $joinColumn) { $columnName = $this->quoteStrategy->getJoinColumnName($joinColumn, $sourceClass, $this->platform); $referencedName = $joinColumn['referencedColumnName']; $conditions[] = 't.' . $columnName . ' = ?'; $params[] = $id[$sourceClass->getFieldForColumn($referencedName)]; $types[] = \MailPoetVendor\Doctrine\ORM\Utility\PersisterHelper::getTypeOfColumn($referencedName, $sourceClass, $this->em); } list($joinTargetEntitySQL, $filterSql) = $this->getFilterSql($mapping); if ($filterSql) { $conditions[] = $filterSql; } $sql = 'SELECT COUNT(*)' . ' FROM ' . $joinTableName . ' t' . $joinTargetEntitySQL . ' WHERE ' . \implode(' AND ', $conditions); return $this->conn->fetchColumn($sql, $params, 0, $types); } public function slice(\MailPoetVendor\Doctrine\ORM\PersistentCollection $collection, $offset, $length = null) { $mapping = $collection->getMapping(); $persister = $this->uow->getEntityPersister($mapping['targetEntity']); return $persister->getManyToManyCollection($mapping, $collection->getOwner(), $offset, $length); } public function containsKey(\MailPoetVendor\Doctrine\ORM\PersistentCollection $collection, $key) { $mapping = $collection->getMapping(); if (!isset($mapping['indexBy'])) { throw new \BadMethodCallException("Selecting a collection by index is only supported on indexed collections."); } list($quotedJoinTable, $whereClauses, $params, $types) = $this->getJoinTableRestrictionsWithKey($collection, $key, \true); $sql = 'SELECT 1 FROM ' . $quotedJoinTable . ' WHERE ' . \implode(' AND ', $whereClauses); return (bool) $this->conn->fetchColumn($sql, $params, 0, $types); } public function contains(\MailPoetVendor\Doctrine\ORM\PersistentCollection $collection, $element) { if (!$this->isValidEntityState($element)) { return \false; } list($quotedJoinTable, $whereClauses, $params, $types) = $this->getJoinTableRestrictions($collection, $element, \true); $sql = 'SELECT 1 FROM ' . $quotedJoinTable . ' WHERE ' . \implode(' AND ', $whereClauses); return (bool) $this->conn->fetchColumn($sql, $params, 0, $types); } public function removeElement(\MailPoetVendor\Doctrine\ORM\PersistentCollection $collection, $element) { if (!$this->isValidEntityState($element)) { return \false; } list($quotedJoinTable, $whereClauses, $params, $types) = $this->getJoinTableRestrictions($collection, $element, \false); $sql = 'DELETE FROM ' . $quotedJoinTable . ' WHERE ' . \implode(' AND ', $whereClauses); return (bool) $this->conn->executeUpdate($sql, $params, $types); } public function loadCriteria(\MailPoetVendor\Doctrine\ORM\PersistentCollection $collection, \MailPoetVendor\Doctrine\Common\Collections\Criteria $criteria) { $mapping = $collection->getMapping(); $owner = $collection->getOwner(); $ownerMetadata = $this->em->getClassMetadata(\get_class($owner)); $whereClauses = $params = array(); foreach ($mapping['relationToSourceKeyColumns'] as $key => $value) { $whereClauses[] = \sprintf('t.%s = ?', $key); $params[] = $ownerMetadata->getFieldValue($owner, $value); } $parameters = $this->expandCriteriaParameters($criteria); foreach ($parameters as $parameter) { list($name, $value, $operator) = $parameter; $whereClauses[] = \sprintf('te.%s %s ?', $name, $operator); $params[] = $value; } $mapping = $collection->getMapping(); $targetClass = $this->em->getClassMetadata($mapping['targetEntity']); $tableName = $this->quoteStrategy->getTableName($targetClass, $this->platform); $joinTable = $this->quoteStrategy->getJoinTableName($mapping, $ownerMetadata, $this->platform); $onConditions = $this->getOnConditionSQL($mapping); $rsm = new \MailPoetVendor\Doctrine\ORM\Query\ResultSetMappingBuilder($this->em); $rsm->addRootEntityFromClassMetadata($mapping['targetEntity'], 'te'); $sql = 'SELECT ' . $rsm->generateSelectClause() . ' FROM ' . $tableName . ' te' . ' JOIN ' . $joinTable . ' t ON' . \implode(' AND ', $onConditions) . ' WHERE ' . \implode(' AND ', $whereClauses); $stmt = $this->conn->executeQuery($sql, $params); return $this->em->newHydrator(\MailPoetVendor\Doctrine\ORM\Query::HYDRATE_OBJECT)->hydrateAll($stmt, $rsm); } public function getFilterSql($mapping) { $targetClass = $this->em->getClassMetadata($mapping['targetEntity']); $rootClass = $this->em->getClassMetadata($targetClass->rootEntityName); $filterSql = $this->generateFilterConditionSQL($rootClass, 'te'); if ('' === $filterSql) { return array('', ''); } $tableName = $this->quoteStrategy->getTableName($rootClass, $this->platform); $joinSql = ' JOIN ' . $tableName . ' te' . ' ON' . \implode(' AND ', $this->getOnConditionSQL($mapping)); return array($joinSql, $filterSql); } protected function generateFilterConditionSQL(\MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata $targetEntity, $targetTableAlias) { $filterClauses = array(); foreach ($this->em->getFilters()->getEnabledFilters() as $filter) { if ($filterExpr = $filter->addFilterConstraint($targetEntity, $targetTableAlias)) { $filterClauses[] = '(' . $filterExpr . ')'; } } return $filterClauses ? '(' . \implode(' AND ', $filterClauses) . ')' : ''; } protected function getOnConditionSQL($mapping) { $targetClass = $this->em->getClassMetadata($mapping['targetEntity']); $association = !$mapping['isOwningSide'] ? $targetClass->associationMappings[$mapping['mappedBy']] : $mapping; $joinColumns = $mapping['isOwningSide'] ? $association['joinTable']['inverseJoinColumns'] : $association['joinTable']['joinColumns']; $conditions = array(); foreach ($joinColumns as $joinColumn) { $joinColumnName = $this->quoteStrategy->getJoinColumnName($joinColumn, $targetClass, $this->platform); $refColumnName = $this->quoteStrategy->getReferencedJoinColumnName($joinColumn, $targetClass, $this->platform); $conditions[] = ' t.' . $joinColumnName . ' = ' . 'te.' . $refColumnName; } return $conditions; } protected function getDeleteSQL(\MailPoetVendor\Doctrine\ORM\PersistentCollection $collection) { $columns = array(); $mapping = $collection->getMapping(); $class = $this->em->getClassMetadata(\get_class($collection->getOwner())); $joinTable = $this->quoteStrategy->getJoinTableName($mapping, $class, $this->platform); foreach ($mapping['joinTable']['joinColumns'] as $joinColumn) { $columns[] = $this->quoteStrategy->getJoinColumnName($joinColumn, $class, $this->platform); } return 'DELETE FROM ' . $joinTable . ' WHERE ' . \implode(' = ? AND ', $columns) . ' = ?'; } protected function getDeleteSQLParameters(\MailPoetVendor\Doctrine\ORM\PersistentCollection $collection) { $mapping = $collection->getMapping(); $identifier = $this->uow->getEntityIdentifier($collection->getOwner()); if (\count($mapping['relationToSourceKeyColumns']) === 1) { return array(\reset($identifier)); } $sourceClass = $this->em->getClassMetadata($mapping['sourceEntity']); $params = array(); foreach ($mapping['relationToSourceKeyColumns'] as $columnName => $refColumnName) { $params[] = isset($sourceClass->fieldNames[$refColumnName]) ? $identifier[$sourceClass->fieldNames[$refColumnName]] : $identifier[$sourceClass->getFieldForColumn($columnName)]; } return $params; } protected function getDeleteRowSQL(\MailPoetVendor\Doctrine\ORM\PersistentCollection $collection) { $mapping = $collection->getMapping(); $class = $this->em->getClassMetadata($mapping['sourceEntity']); $targetClass = $this->em->getClassMetadata($mapping['targetEntity']); $columns = array(); $types = array(); foreach ($mapping['joinTable']['joinColumns'] as $joinColumn) { $columns[] = $this->quoteStrategy->getJoinColumnName($joinColumn, $class, $this->platform); $types[] = \MailPoetVendor\Doctrine\ORM\Utility\PersisterHelper::getTypeOfColumn($joinColumn['referencedColumnName'], $class, $this->em); } foreach ($mapping['joinTable']['inverseJoinColumns'] as $joinColumn) { $columns[] = $this->quoteStrategy->getJoinColumnName($joinColumn, $targetClass, $this->platform); $types[] = \MailPoetVendor\Doctrine\ORM\Utility\PersisterHelper::getTypeOfColumn($joinColumn['referencedColumnName'], $targetClass, $this->em); } return array('DELETE FROM ' . $this->quoteStrategy->getJoinTableName($mapping, $class, $this->platform) . ' WHERE ' . \implode(' = ? AND ', $columns) . ' = ?', $types); } protected function getDeleteRowSQLParameters(\MailPoetVendor\Doctrine\ORM\PersistentCollection $collection, $element) { return $this->collectJoinTableColumnParameters($collection, $element); } protected function getInsertRowSQL(\MailPoetVendor\Doctrine\ORM\PersistentCollection $collection) { $columns = array(); $types = array(); $mapping = $collection->getMapping(); $class = $this->em->getClassMetadata($mapping['sourceEntity']); $targetClass = $this->em->getClassMetadata($mapping['targetEntity']); foreach ($mapping['joinTable']['joinColumns'] as $joinColumn) { $columns[] = $this->quoteStrategy->getJoinColumnName($joinColumn, $targetClass, $this->platform); $types[] = \MailPoetVendor\Doctrine\ORM\Utility\PersisterHelper::getTypeOfColumn($joinColumn['referencedColumnName'], $class, $this->em); } foreach ($mapping['joinTable']['inverseJoinColumns'] as $joinColumn) { $columns[] = $this->quoteStrategy->getJoinColumnName($joinColumn, $targetClass, $this->platform); $types[] = \MailPoetVendor\Doctrine\ORM\Utility\PersisterHelper::getTypeOfColumn($joinColumn['referencedColumnName'], $targetClass, $this->em); } return array('INSERT INTO ' . $this->quoteStrategy->getJoinTableName($mapping, $class, $this->platform) . ' (' . \implode(', ', $columns) . ')' . ' VALUES' . ' (' . \implode(', ', \array_fill(0, \count($columns), '?')) . ')', $types); } protected function getInsertRowSQLParameters(\MailPoetVendor\Doctrine\ORM\PersistentCollection $collection, $element) { return $this->collectJoinTableColumnParameters($collection, $element); } private function collectJoinTableColumnParameters(\MailPoetVendor\Doctrine\ORM\PersistentCollection $collection, $element) { $params = array(); $mapping = $collection->getMapping(); $isComposite = \count($mapping['joinTableColumns']) > 2; $identifier1 = $this->uow->getEntityIdentifier($collection->getOwner()); $identifier2 = $this->uow->getEntityIdentifier($element); if ($isComposite) { $class1 = $this->em->getClassMetadata(\get_class($collection->getOwner())); $class2 = $collection->getTypeClass(); } foreach ($mapping['joinTableColumns'] as $joinTableColumn) { $isRelationToSource = isset($mapping['relationToSourceKeyColumns'][$joinTableColumn]); if (!$isComposite) { $params[] = $isRelationToSource ? \array_pop($identifier1) : \array_pop($identifier2); continue; } if ($isRelationToSource) { $params[] = $identifier1[$class1->getFieldForColumn($mapping['relationToSourceKeyColumns'][$joinTableColumn])]; continue; } $params[] = $identifier2[$class2->getFieldForColumn($mapping['relationToTargetKeyColumns'][$joinTableColumn])]; } return $params; } private function getJoinTableRestrictionsWithKey(\MailPoetVendor\Doctrine\ORM\PersistentCollection $collection, $key, $addFilters) { $filterMapping = $collection->getMapping(); $mapping = $filterMapping; $indexBy = $mapping['indexBy']; $id = $this->uow->getEntityIdentifier($collection->getOwner()); $sourceClass = $this->em->getClassMetadata($mapping['sourceEntity']); $targetClass = $this->em->getClassMetadata($mapping['targetEntity']); if (!$mapping['isOwningSide']) { $associationSourceClass = $this->em->getClassMetadata($mapping['targetEntity']); $mapping = $associationSourceClass->associationMappings[$mapping['mappedBy']]; $joinColumns = $mapping['joinTable']['joinColumns']; $sourceRelationMode = 'relationToTargetKeyColumns'; $targetRelationMode = 'relationToSourceKeyColumns'; } else { $associationSourceClass = $this->em->getClassMetadata($mapping['sourceEntity']); $joinColumns = $mapping['joinTable']['inverseJoinColumns']; $sourceRelationMode = 'relationToSourceKeyColumns'; $targetRelationMode = 'relationToTargetKeyColumns'; } $quotedJoinTable = $this->quoteStrategy->getJoinTableName($mapping, $associationSourceClass, $this->platform) . ' t'; $whereClauses = array(); $params = array(); $types = array(); $joinNeeded = !\in_array($indexBy, $targetClass->identifier); if ($joinNeeded) { $joinConditions = array(); foreach ($joinColumns as $joinTableColumn) { $joinConditions[] = 't.' . $joinTableColumn['name'] . ' = tr.' . $joinTableColumn['referencedColumnName']; } $tableName = $this->quoteStrategy->getTableName($targetClass, $this->platform); $quotedJoinTable .= ' JOIN ' . $tableName . ' tr ON ' . \implode(' AND ', $joinConditions); $columnName = $targetClass->getColumnName($indexBy); $whereClauses[] = 'tr.' . $columnName . ' = ?'; $params[] = $key; $types[] = \MailPoetVendor\Doctrine\ORM\Utility\PersisterHelper::getTypeOfColumn($columnName, $targetClass, $this->em); } foreach ($mapping['joinTableColumns'] as $joinTableColumn) { if (isset($mapping[$sourceRelationMode][$joinTableColumn])) { $column = $mapping[$sourceRelationMode][$joinTableColumn]; $whereClauses[] = 't.' . $joinTableColumn . ' = ?'; $params[] = $sourceClass->containsForeignIdentifier ? $id[$sourceClass->getFieldForColumn($column)] : $id[$sourceClass->fieldNames[$column]]; $types[] = \MailPoetVendor\Doctrine\ORM\Utility\PersisterHelper::getTypeOfColumn($column, $sourceClass, $this->em); } elseif (!$joinNeeded) { $column = $mapping[$targetRelationMode][$joinTableColumn]; $whereClauses[] = 't.' . $joinTableColumn . ' = ?'; $params[] = $key; $types[] = \MailPoetVendor\Doctrine\ORM\Utility\PersisterHelper::getTypeOfColumn($column, $targetClass, $this->em); } } if ($addFilters) { list($joinTargetEntitySQL, $filterSql) = $this->getFilterSql($filterMapping); if ($filterSql) { $quotedJoinTable .= ' ' . $joinTargetEntitySQL; $whereClauses[] = $filterSql; } } return array($quotedJoinTable, $whereClauses, $params, $types); } private function getJoinTableRestrictions(\MailPoetVendor\Doctrine\ORM\PersistentCollection $collection, $element, $addFilters) { $filterMapping = $collection->getMapping(); $mapping = $filterMapping; if (!$mapping['isOwningSide']) { $sourceClass = $this->em->getClassMetadata($mapping['targetEntity']); $targetClass = $this->em->getClassMetadata($mapping['sourceEntity']); $sourceId = $this->uow->getEntityIdentifier($element); $targetId = $this->uow->getEntityIdentifier($collection->getOwner()); $mapping = $sourceClass->associationMappings[$mapping['mappedBy']]; } else { $sourceClass = $this->em->getClassMetadata($mapping['sourceEntity']); $targetClass = $this->em->getClassMetadata($mapping['targetEntity']); $sourceId = $this->uow->getEntityIdentifier($collection->getOwner()); $targetId = $this->uow->getEntityIdentifier($element); } $quotedJoinTable = $this->quoteStrategy->getJoinTableName($mapping, $sourceClass, $this->platform); $whereClauses = array(); $params = array(); $types = array(); foreach ($mapping['joinTableColumns'] as $joinTableColumn) { $whereClauses[] = ($addFilters ? 't.' : '') . $joinTableColumn . ' = ?'; if (isset($mapping['relationToTargetKeyColumns'][$joinTableColumn])) { $targetColumn = $mapping['relationToTargetKeyColumns'][$joinTableColumn]; $params[] = $targetId[$targetClass->getFieldForColumn($targetColumn)]; $types[] = \MailPoetVendor\Doctrine\ORM\Utility\PersisterHelper::getTypeOfColumn($targetColumn, $targetClass, $this->em); continue; } $targetColumn = $mapping['relationToSourceKeyColumns'][$joinTableColumn]; $params[] = $sourceId[$sourceClass->getFieldForColumn($targetColumn)]; $types[] = \MailPoetVendor\Doctrine\ORM\Utility\PersisterHelper::getTypeOfColumn($targetColumn, $sourceClass, $this->em); } if ($addFilters) { $quotedJoinTable .= ' t'; list($joinTargetEntitySQL, $filterSql) = $this->getFilterSql($filterMapping); if ($filterSql) { $quotedJoinTable .= ' ' . $joinTargetEntitySQL; $whereClauses[] = $filterSql; } } return array($quotedJoinTable, $whereClauses, $params, $types); } private function expandCriteriaParameters(\MailPoetVendor\Doctrine\Common\Collections\Criteria $criteria) { $expression = $criteria->getWhereExpression(); if ($expression === null) { return array(); } $valueVisitor = new \MailPoetVendor\Doctrine\ORM\Persisters\SqlValueVisitor(); $valueVisitor->dispatch($expression); list($values, $types) = $valueVisitor->getParamsAndTypes(); return $types; } } 