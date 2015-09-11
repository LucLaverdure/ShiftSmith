<?php

// Dashboard
class homepage extends Controller {
	// Display function: validate urls to activate the controller
	function validate() {
		// Activate home controller for /home and /home/*
		if (q()=="home" || q()=="/") {
			$this->loadView('default-theme/home.tpl');
			return 1;	// priority 1
		}
		else return false;
	}

	function execute() {
	}
}

class browse_category extends Controller {
	// Display function: validate urls to activate the controller
	function validate() {
		// Activate home controller for /home and /home/*
		if (inpath('ajax/get/category/*') || inpath('ajax/get/search/*')) {
			return 1; // priority 1
		}
		else return false;
	}

	function execute() {
		
		$per_page = 15;

		$db = new Database();
		$db::connect();
		$total_count = 0;
		$current_page = q(4);
		if ($current_page == '') $current_page = 1;
		if (!is_numeric($current_page)) return;

		$results = array();
		$results['pagination'] = array();
		$data = [];

			/*******************
			 * Must add:
			 * - NTerms: Number of terms DESC order, ex: 3/3, 2/3, 1/3
			 * - MaxField: Field priority score, ex: title 2, desc 1, 
			 * - Glom: Single Field match priority
			 * - Exact: Score: 2: Complete text match of user query, 1: Else
			 * - Static: Sort by date DESC
			 */ 
			$searchInterface = new SearchInterface();

		/*********
		 * debug(True / False): Display Relevancy ranking in addition to select fields
		 */
			//$searchInterface->debug();
		
		/*********
		 * addFields(array(field => alias), [...])
		 */
			$searchInterface->addFields(array(
				'c.creation_id' => 'creation_id',
				'c.sub_group_id' => 'sub_group_id',
				'c.title' => 'title',
				'c.description' => 'description',
				'gg.title' => 'group_title',
				'g.title' => 'sub_group_title'
			));
		
		/*********
		 * addTables(array(table => alias), [...])
		 */
			$searchInterface->addTables(array(
				'creations_group' => 'gg',
				'creations_sub_group' => 'g',
				'creation' => 'c'
			));

		/*********
		 * addLeftJoins(array(Table Field / Alias => SQL Condition), [...])
		 */
			$searchInterface->addLeftJoins(array(
				'g' => 'g.group_id = gg.group_id',
				'c' => 'c.sub_group_id = g.sub_group_id'
			));

		/*********
		 * addHavings(array(Table Field / Alias => SQL Condition), [...])
		 */
			$searchInterface->addHavings(array(
				'enabled' => '= 1'
			));

		/*********
		 * addSearchField(array(Field Alias => Priority Score), [...])
		 * Priority Score is higher on top
		 */
			$searchInterface->addSearchField(array(
				'title' => 3,
				'group_title' => 2,
				'sub_group_title' => 2,
				'description' => 2,
				'content' => 2,
				'short_description' => 1,
			));

		/*********
		 * addRelevancyRanking(
		 *	array(
		 *		Rank Algorithm['NTerms' / 'MaxField' / 'Glom' / 'Exact' / 'Static']
		 *			=>
		 *		Rank Algorithm['NTerms' / 'MaxField' / 'Glom' / 'Exact' / Static: [Field Alias ASC / Field Alias DESC]]
		 *		, [...]
		 *	)
		 */
			/*******************
			 * - NTerms: Number of terms DESC order, ex: 3/3, 2/3, 1/3
			 * - MaxField: Field priority score, ex: title 2, desc 1, 
			 * - Glom: Single Field match priority
			 * - Exact: Score: 2: Complete text match of user query, 1: Else
			 * - Static: Sort by date DESC
			 */
			$searchInterface->addRelevancyRanking(array(
				'NTerms' => 'NTerms',
				'MaxField' => 'MaxField',
				'Glom' => 'Glom',
				'Exact' => 'Exact',
				'Static' => 'date_mod DESC',
			));

		/*********
		 * setSearchTerms(String Search Terms)
		 * Example: 'web security'
		 */
			$searchTerms = str_replace(' ', '+', trim(q(3)));
			$searchInterface->setSearchTerms($searchTerms);

		/*********
		 * setPagination(Current Page, Items Per Page)
		 */
			$searchInterface->setPagination($current_page, $per_page);
			$results['pagination'] = $searchInterface->getPaginationInfo();

			
		/*********
		 * buildQuery(): Generate SQL for query
		 */
			$data = $db::queryResults($searchInterface->buildQuery());
		if ($data) {
			$results['data'] = $data;
			echo json_encode($results);
		}
	}
}

