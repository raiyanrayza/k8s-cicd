<?php
function get_user_meta_profile_keys(){
	return array(
		'salutation' => 'Salutation',
		'first_name' => 'First Name',
		'middle_name' => 'Middle Name',
		'last_name' => 'Last Name',
		'suffix' => 'Suffix',
		'degree' => 'Degree',
		'department' => 'Department',
		'company' => 'Company/Employer',
		'work_phone' => 'Work Phone',
		'address_line_1' => 'Address Line 1',
		'address_line_2' => 'Address Line 2',
		'address_line_3' => 'Address Line 3',
		'city' => 'City',
		'state' => 'State/Province',
		'country' => 'Country',
		'postal_code' => 'Postal Code',
		'website_address' => 'Website Address',
		'twitter_contact' => 'Twitter Contact',

		'sec_address_line_1' => 'Address Line 1',
		'sec_address_line_2' => 'Address Line 2',
		'sec_address_line_3' => 'Address Line 3',
		'sec_city' => 'City',
		'sec_state' => 'State',
		'sec_country' => 'Country',
		'sec_postal_code' => 'Postal Code',

		'prefer_add' => 'Preferred Address',
		'home_phone' => 'Home Phone',
		'fax_phone' => 'Fax',
		'prefer_phone' => 'Preferred Phone',

		'work_phone_ext' => 'Work Phone Ext',
		'home_phone_ext' => 'Home Phone Ext',
		'fax_phone_ext' => 'Fax Ext',

		'hospitalPosition' => 'Hospital Position',
		'hospitalName' => 'Name of Hospital/Institution',
		'universityName' => 'Name of University or Academic Affiliation',
		'academicRank' => 'Academic Rank',
		'academicRankOtherText' => 'Academic Rank Other Specify',
		'institutionIsEPFellowship' => 'Does your institution have an EP Fellowship?',
		'researchAreas' => 'Areas of Clinical/research interest',

		'publication1' => 'Publication 1',
		'publication_pmid1' => 'PMID 1',
		'publication2' => 'Publication 2',
		'publication_pmid2' => 'PMID 2',
		'publication3' => 'Publication 3',
		'publication_pmid3' => 'PMID 3',
		'publication4' => 'Publication 4',
		'publication_pmid4' => 'PMID 4',
		'publication5' => 'Publication 5',
		'publication_pmid5' => 'PMID 5',

		'pastScientificSocietyName' => 'PAST Scientific Society Name',
		'pastCommitteeName' => 'PAST Committee Name',
		'pastRole' => 'PAST Role',
		'pastTenureDate' => 'PAST Tenure Dates',
		'presentScientificSocietyName' => 'PRESENT Scientific Society Name',
		'presentCommitteeName' => 'PRESENT Committee Name',
		'presentRole' => 'PRESENT Role',
		'presentTenureDate' => 'PRESENT Tenure Dates',
		'futureScientificSocietyName' => 'FUTURE Scientific Society Name',
		'futureCommitteeName' => 'FUTURE Committee Name',
		'futureRole' => 'FUTURE Role',
		'futureTenureDate' => 'FUTURE Tenure Dates',

		'pastNationalScientificGuideName' => 'Name of PAST National Scientific Guidelines/Consensus Statements',
		'pastSocietyRepresentName' => 'Name of PAST Society that you represented',
		'presentNationalScientificGuideName' => 'Name of PRESENT National Scientific Guidelines/Consensus Statements',
		'presentSocietyRepresentName' => 'Name of PRESENT Society that you represent',
		'futureNationalScientificGuideName' => 'Name of FUTURE National Scientific Guidelines/Consensus Statements',
		'futureSocietyRepresentName' => 'Name of FUTURE Society that you will represent',

		'presentGrantInfo' => 'PRESENT grant information',
		'presentGrantRole' => 'PRESENT grant role',
		'pastGrantInfo' => 'PAST grant information',
		'pastGrantRole' => 'PAST grant role',
		'futureGrantInfo' => 'FUTURE grant information',

		'futureGrantRole' => 'FUTURE grant role',
		'pacesInterests' => 'PACES Interests',
		'relationshipIndustry' => 'Relationship with Industry'
	);
}

function map_user_profile_checkbox_entries($values, $value_key){
	$check_values = array(
							'academicRank' => array(
								'instructor' => 'Instructor',
								'assistant_prof' => 'Assistant Professor',
								'associate_prof' => 'Associate Professor',
								'professor' => 'Professor',
								'none' => 'None',
								'other' => 'Other - '
							),
							'researchAreas' => array(
								'device_therapy' => 'Device therapy',
								'catheter_ablation' => 'Catheter Ablation',
								'fetal_arrhythmia' => 'Fetal arrhythmia',
								'cardiac_channelopathy' => 'Cardiac Channelopathy',
								'autonomic_nervous' => 'Autonomic Nervous System',
								'adult_congenital_heart' => 'Adult Congenital Heart Disease',
								'anti_arrhythmic_drugs' => 'Anti-Arrhythmic Drugs',
								'sudden_cardiac_death' => 'Sudden Cardiac Death',
								'new_technology' => 'New Technology',
								'rhythm_monitoring' => 'Rhythm Monitoring',
								'remote_monitoring' => 'Remote Monitoring',
								'health_care_policy' => 'Health Care Policy',
								'patient_education' => 'Patient Education',
								'quality_of_life' => 'Quality of Life',
								'all_of_above' => 'All of the above'
							),
							'pacesInterests' => array(
								'scientific_guidelines' => 'Scientific guidelines',
								'education' => 'Education',
								'research_collab' => 'Research collaboration',
								'international_liaison' => 'International Liaison',
								'scientific_review' => 'Scientific Review',
								'professional_networking' => 'Professional Networking',
								'mentoring' => 'Mentoring',
								'administration' => 'Administration',
								'happy_to_be' => 'Happy to be a member',
								'qa_qi' => 'QA/QI'
							),
							'relationshipIndustry' => array(
								'yes' => 'Yes',
								'no' => 'No'
							)
						);
	$result = array();
	foreach ($values as $key => $v) {
		$test_array = $check_values[$value_key];
		if( array_key_exists( $v, $check_values[$value_key]) ){ 
			array_push($result, $check_values[$value_key][$v] );
		}
	}
	return $result;
}