<?php
 namespace MailPoetVendor\Symfony\Component\Validator\Context; if (!defined('ABSPATH')) exit; use MailPoetVendor\Symfony\Component\Translation\TranslatorInterface; use MailPoetVendor\Symfony\Component\Validator\Validator\ValidatorInterface; class ExecutionContextFactory implements \MailPoetVendor\Symfony\Component\Validator\Context\ExecutionContextFactoryInterface { private $translator; private $translationDomain; public function __construct(\MailPoetVendor\Symfony\Component\Translation\TranslatorInterface $translator, $translationDomain = null) { $this->translator = $translator; $this->translationDomain = $translationDomain; } public function createContext(\MailPoetVendor\Symfony\Component\Validator\Validator\ValidatorInterface $validator, $root) { return new \MailPoetVendor\Symfony\Component\Validator\Context\ExecutionContext($validator, $root, $this->translator, $this->translationDomain); } } 