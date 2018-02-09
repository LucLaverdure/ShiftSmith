[header.tpl]

<br/>
<p class="bgw">Dream Forgery is a PHP Framework designed with an <a href="https://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller" target="_blank" title="What is MVC?">MVC structure</a>.</p>
<br/>
<div class="download-box">
	<div class="download-title">
	Dream Forgery version <span class="core-version"></span>
	<div class="download-title">
		<p><img src="/files/img/check.png" class="checkfeature" />Free, Fast, Flexible</p>
		<p><img src="/files/img/check.png" class="checkfeature" />Model-View-Controller Platform</p>
		<p><img src="/files/img/check.png" class="checkfeature" />Content Management System</p>
		<p><img src="/files/img/check.png" class="checkfeature" />Extract, Transform, Load</p>
	</div>
	</div>
	<p><a href="https://github.com/LucLaverdure/DreamForgery/archive/master.zip" class="hvr-bubble-float-right">Download</a></p>
</div>

	<p class="bgw"><a href="https://github.com/LucLaverdure/DreamForgery" target="_blank">Github</a> - <a class="gh" href="https://github.com/LucLaverdure/DreamForgery" target="_blank">https://github.com/LucLaverdure/DreamForgery</a></p>
	
	<h3><a href="https://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller" target="_blank">MVC Help</a></h3>
	<div class="mvc-help bgw">
		<h4 class="expand"><a href="#">Getting Started</a></h4>
		<div class="box" style="display:none;">
			<p>Find a PHP host environment such as <a href="http://www.wampserver.com/en/" target="_blank" title="Windows Apache MySQL PHP">WAMP</a>.</p>
			<p>Then extract the DreamForgery zip file at the webroot (www) directory.</p>
		</div>
		<h4 class="expand"><a href="#">Understanding Directories</a></h4>
		<div class="box" style="display:none;">
			<p><a href="#">cache</a> - views cached for faster processing.</p>
			<p><a target="_blank" href="https://github.com/LucLaverdure/DreamForgery/tree/master/config">config</a> - Configuration of the DreamForgery application.</p>
			<p><a target="_blank" href="https://github.com/LucLaverdure/DreamForgery/tree/master/core">core</a> - DreamForgery system files, do not modify these files as they will be erased with updates.</p>
			<p><a target="_blank" href="https://github.com/LucLaverdure/DreamForgery/tree/master/webapp">webapp</a> - Your application folder</p>
			<p><a target="_blank" href="https://github.com/LucLaverdure/DreamForgery/tree/master/webapp/controllers">webapp/controllers</a> - Controllers folder. There can be multiple controllers within one file. By default, all php files within the webapp folder are scanned for controllers.</p>
			<p><a target="_blank" href="https://github.com/LucLaverdure/DreamForgery/tree/master/webapp/files">webapp/files</a> - Static files folder, for example: CSS files, Image files, Javascript files, upload Files.</p>
			<p><a target="_blank" href="https://github.com/LucLaverdure/DreamForgery/tree/master/webapp/views/default-theme">webapp/views</a> - Frontend files.</p>
		</div>
		<h4 class="expand"><a href="#">My first controller</a></h4>
		<div class="box" style="display:none;">
		<p>Create a file within webapp/controllers/home.php</p>
			<pre><code class="language-php">
&lt;?php

// Home Page

class homepage extends Controller { // A controller is defined by "extends Controller"

	// To determine if the controller is triggered, the validate function is used.
	// returns anything but false to trigger
	function validate() {
		// Trigger home controller for /home and /
		// the q() function returns the path requested without domain.
		if (q()=="home" || q()=="/") {
			return 1;	// priority 1, more than 1 controller can be triggered by the application, but we will prioritize this controller.
		}
		else return false; // if we are somewhere else than at the homepage, do not trigger the controller.
	}

	// once the controller is triggered (it validated with the function above)
	function execute() {
		// display view for home page (home page template)
		$this->loadView('home.tpl');
	}
}</code></pre>
		</div>

		
		<h4 class="expand"><a href="#">My first path triggers</a></h4>
		<div class="box" style="display:none;">
		<p>Create a file within webapp/controllers/home.php</p>
			<pre><code class="language-php">
[...]
	function validate() {
		// match /home
		if (inpath("home"))
		// match /home/page/[anything]
		else if (inpath("home/page/*"))
		// no match
		else return false; // if we are somewhere else than at the homepage, do not trigger the controller.
	}
[...]
</code></pre>
		</div>
		
		
		
		
		<h4 class="expand"><a href="#">My first models</a></h4>
		<div class="box" style="display:none;">
		<p>Create a file within webapp/controllers/home.php</p>
			<pre><code class="language-php">
&lt;?php

// Home Page
[...]

	// once the controller is triggered (it validated with the function above)
	function execute() {
	
		// Pass a simple model to the view
		// First argument is a container, second is a variable and third is it'S value.
		$this->addModel('home', 'title', 'Hello World!');
	
		// display view for home page (home page template)
		$this->loadView('home.tpl');
	}
[...]			</code></pre>
		</div>
		
		
		<h4 class="expand"><a href="#">My first view</a></h4>
		<div class="box" style="display:none;">
		<p>Create a file within webapp/views/home.tpl</p>
			<pre><code class="language-php">
&lt;html>
	&lt;head>&lt;title>My first DreamForgery Application!&lt;/title>&lt;/head>
	&lt;body>
		[home.title]
	&lt;/body>
&lt;/html>
			</code></pre>
		</div>
		

		<h4 class="expand"><a href="#">My first injected view</a></h4>
		<div class="box" style="display:none;">
		<p>Create a file within webapp/views/home.tpl</p>
			<pre><code class="language-php">
[...]
	function validate() {
		return 15; // execute on all pages, priority of 15 to let the page controllers execute before this one.
	}

	// once the controller is triggered (it validated with the function above)
	function execute() {
		// after the page controller is loaded.
		// browse DOM to "header" id, then element with class "menu" and prepend the view menu.tpl
		$this->injectView('#header .menu', 'prepend', 'menu.tpl');
	}
[...]
			</code></pre>
		</div>
		
		
		<h4 class="expand"><a href="#">Database Results</a></h4>
		<div class="box" style="display:none;">
		<p>Create a file within webapp/controllers/home.php</p>
			<pre><code class="language-php">
[...]

function execute() {
	$db = new Database();
	$db::connect();

	// get all posts
	$data = $db::queryResults("SELECT id, post, username
							   FROM posts
							   ORDER BY id DESC");

	$this->addModel('posts', $data);
	$this->loadView('home.tpl');
}

[...]
			</code></pre>
		</div>
		
		<h4 class="expand"><a href="#">Display Array Model in View</a></h4>
		<div class="box" style="display:none;">
		<p>Create a file within webapp/views/home.tpl</p>
			<pre><code class="language-php">
[...]

[for:posts]
	&lt;div data-postid="[posts.id]">&lt;strong>[posts.username]: &lt;/strong>[posts.post]&lt;/div>
[end:posts]

[...]
			</code></pre>
		</div>

		<h4 class="expand"><a href="#">Forms</a></h4>
		<div class="box" style="display:none;">
		<p>Create a file within webapp/views/form.tpl</p>
			<pre><code class="language-php">
[...]

&lt;form action="/dream" method="post">
	&lt;label>Dream &lt;input type="text" name="textbox" placeholder="Forgery" value="[register.dream]">&lt;/label>
&lt;/form>

[...]
			</code></pre>

		<p>Create a file within webapp/controllers/form.php</p>
			<pre><code class="language-php">
&lt;?php>

class formControl extends Controller {
	
	function validate() {
		// Activate form controller for /dream
		if (q()=="dream") {
			return 1;	// priority 1
		}
		else return false;
	}

	function execute() {
		/*
		 * If "dream" variable on the "register" form hasn't been set before, it is equal to "Forgery"
		 * the form "register" is also a model passed on to the view.
		 * 
		 * Therefore, the following happens:
		 *
		 * 1. register.dream model = "Forgery"
		 * 2. the view displays Forgery in a textbox
		 * 3. The user types in "Forge2" and submits the form to /dream
		 * 4. The default value of register.dream is overriden by the post value of register.dream
		 *    it is now equal to "Forge2" in the controller
		 */
		$this->cacheForm('register', array(	'dream'=>'Forgery'
										));
		$myDream = $this->getModel('register', 'dream');
		
		$this->loadView('form.tpl');
	}
}

			</code></pre>
		</div>
	</div>
	
	<h3><a href="https://en.wikipedia.org/wiki/Content_management_system" target="_blank">Search Big Data</a></h3>
	
	<div class="cms-help bgw">
		<h4 class="expand"><a href="#">Relevancy Ranking</a></h4>
		<div class="box" style="display:none;">
			<p>Visit <a href="/user">/user</a> to manage your website.</p>
			<p>You can input the credentials for administration.</p>
<pre><code class="language-php">		
[...]			
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

		$searchInterface = new SearchInterface();

		/*********
		 * debug(True / False): Display Relevancy ranking in addition to select fields
		 */
		//	$searchInterface->debug();
		
		/*********
		 * addFields(array(field => alias), [...])
		 */
			$searchInterface->addFields(array(
				'c.creation_id' => 'creation_id',
				'c.title' => 'title',
				'g.group_id' => 'group_id',
				'g.title' => 'sub_group_title',
				'c.short_description' => 'short_description'
			));
		
		/*********
		 * addTables(array(table => alias), [...])
		 */
			$searchInterface->addTables(array(
				'creations_sub_group' => 'g',
				'creation' => 'c'
			));

		/*********
		 * addLeftJoins(array(Table Field / Alias => SQL Condition), [...])
		 */
			$searchInterface->addLeftJoins(array(
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
				'sub_group_title' => 2,
				'description' => 2,
				'content' => 2,
				'short_description' => 1,
			));

		/*********
		 * setPagination(Current Page, Items Per Page)
		 */
			$searchInterface->setPagination($current_page, $per_page);

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
		 * buildQuery(): Generate SQL for query
		 */
			// echo $searchInterface->buildQuery();

			$data = $db::queryResults($searchInterface->buildQuery());

		$this->addModel('creations', $data);
		$this->loadView('home.tpl');
		
[...]
			</code></pre>
		</div>
	</div>
	
	<h3><a href="https://en.wikipedia.org/wiki/Content_management_system" target="_blank">CMS Help</a></h3>
	
	<div class="cms-help bgw">
		<h4 class="expand"><a href="#">Administration URL</a></h4>
		<div class="box" style="display:none;">
			<p>Visit <a href="/user">/user</a> to manage your website.</p>
			<p>You can input the credentials for administration.</p>
		</div>
	</div>

	<h3><a href="https://en.wikipedia.org/wiki/Extract,_transform,_load" target="_blank">ETL Help</a></h3>
	<div class="cms-help bgw">
		<h4 class="expand"><a href="#">Processing Data</a></h4>
		<div class="box" style="display:none;">
		</div>
	</div>

[footer.tpl]