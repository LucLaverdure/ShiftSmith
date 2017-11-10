[header.tpl]

<div style="background: #fff url(/theme/files/img/sections/docs-bg.jpg) center center;min-height:200px;">
</div>
<div class="container">
  <div class="row">
	<div class="col col-lg-4 col-md-4 col-sm-12 col-xs-12">
		<h3 id="Dir">Default Directory Structure:</h3>
		<div class="doc">
	
		<div id="data" class="demo"></div>
	
		<div class="info">
			<div class="red">* Red items should not be modified</div>
			<div class="green">* Green items are for advanced users</div>
		</div>
	
		<script type="text/javascript">

		// inline data demo
		$('#data').jstree({
			"plugins" : [ "changed" ],
			'core' : {
				'data' : [
					{ "text" : "config", "li_attr" : { "class" : "green" }, "children" : [
						{ "text" : "config.php", "icon" : "jstree-file", "li_attr" : { "class" : "green" } },
						{ "text" : "config-app.php", "icon" : "jstree-file", "li_attr" : { "class" : "green" } },
						{ "text" : "config-cms.php", "icon" : "jstree-file", "li_attr" : { "class" : "green" } },
						{ "text" : "config-theme.php", "icon" : "jstree-file", "li_attr" : { "class" : "green" } }
					]},
					{ "text" : "core", "li_attr" : { "class" : "red" }, "children" : [
						{ "text" : "admin", "li_attr" : { "class" : "red" }, "children" : [
							{ "text" : "controllers", "li_attr" : { "class" : "red" }  },
							{ "text" : "files", "li_attr" : { "class" : "red" }, "children" : [
								{ "text" : "css", "li_attr" : { "class" : "red" } },
								{ "text" : "img", "li_attr" : { "class" : "red" } },
								{ "text" : "js", "li_attr" : { "class" : "red" } },
								{ "text" : "lib", "li_attr" : { "class" : "red" } }
							]},
							{ "text" : "views", "li_attr" : { "class" : "red" }}
						]},
						{ "text" : "phpQuery", "li_attr" : { "class" : "red" }},
						{ "text" : "core.php", "icon" : "jstree-file", "li_attr" : { "class" : "red" } },
						{ "text" : "core-mvc.php", "icon" : "jstree-file", "li_attr" : { "class" : "red" } },
						{ "text" : "core-db.php", "icon" : "jstree-file", "li_attr" : { "class" : "red" } },
						{ "text" : "core-prefunctions.php", "icon" : "jstree-file", "li_attr" : { "class" : "red" } },
						{ "text" : "core-process.php", "icon" : "jstree-file", "li_attr" : { "class" : "red" } },
						{ "text" : "core-selector.php", "icon" : "jstree-file", "li_attr" : { "class" : "red" } },
						{ "text" : "core-theme.php", "icon" : "jstree-file", "li_attr" : { "class" : "red" } },
						{ "text" : "core-user.php", "icon" : "jstree-file", "li_attr" : { "class" : "red" } }
					]},
					{ "text" : "webapp", "li_attr" : { "class" : "red" }, "children" : [
						{ "text" : "files", "li_attr" : { "class" : "red" }, "children" : [
							{ "text" : "private", "li_attr" : { "class" : "red" } },
							{ "text" : "public", "li_attr" : { "class" : "red" } }
						]},
						{ "text" : "plugins", "li_attr" : { "class" : "green" } },
						{ "text" : "themes", "li_attr" : { "class" : "green" }, "children" : [
							{ "text" : "Anvil (Example)", "li_attr" : { "class" : "green" }, "children" : [
								{ "text" : "controllers", "li_attr" : { "class" : "green" } },
								{ "text" : "files", "li_attr" : { "class" : "green" }, "children" : [
									{ "text" : "css", "li_attr" : { "class" : "green" } },
									{ "text" : "img", "li_attr" : { "class" : "green" } },
									{ "text" : "js", "li_attr" : { "class" : "green" } },
									{ "text" : "lib", "li_attr" : { "class" : "green" } }
								]},
								{ "text" : "views", "li_attr" : { "class" : "green" } }
							]}
						]}
					]}
				]
			}
		}).on('changed.jstree', function (e, data) {
			$("#dirdescriptor").hide();
			var path = data.instance.get_path(data.node,'/');
			var desc = "";
			switch (path) {
				case "config":
					desc = "Directory hosting config files";
					break;
				case "config/config.php":
					desc = "Main configuration file";
					break;
				case "config/config-app.php":
					desc = "Application configuration file, <br/>"+
						   "can contain cron job password";
					break;
				case "config/config-cms.php":
					desc = "CMS/Database Configuration/Connection file";
					break;
				case "config/config-theme.php":
					desc = "Configuration of active Theme";
					break;
				case "core":
					desc = "Central Architecture of ShiftSmith";
					break;
				case "core/admin":
					desc = "Core CMS administration files";
					break;
				case "core/admin/controllers":
					desc = "Core CMS admin controllers";
					break;
				case "core/admin/files":
					desc = "Core CMS admin assets";
					break;
				case "core/admin/files/css":
					desc = "Core CMS admin CSS files (generated from SCSS)";
					break;
				case "core/admin/files/img":
					desc = "Core CMS admin image files";
					break;
				case "core/admin/files/js":
					desc = "Core CMS admin Javascript files";
					break;
				case "core/admin/files/js":
					desc = "Core CMS admin 3rd party dependencies";
					break;
				case "core/admin/view":
					desc = "Core CMS admin templates";
					break;
				case "core/phpQuery":
					desc = "Core dependency for Controller Injections";
					break;
				case "core/core.php":
					desc = "Core Architecture file steps";
					break;
			}
			
			// load help
			$("#dirdescriptor h3.path").text(path);
			$("#dirdescriptor .desc").html(desc);
			
			// animate help box fade in
			$("#dirdescriptor").fadeIn();
		}).on('select_node.jstree', function (e, data) {
			//single click tweak
			data.instance.toggle_node(data.node);
		});
		</script>
		</div>
	</div>
	<div id="dirdescriptor" class="col col-lg-8 col-md-8 col-sm-12 col-xs-12" style="display:none;">
		<h3 class="path">/path</h3>
		<div class="desc"></div>
    </div>
  </div>
  <div class="row">
	<div class="col col-lg-6 col-md-6 col-sm-12 col-xs-12">
		<h3 id="Controller">Controller Example:</h3>
		<div class="doc">
<pre><code class="language-php">class MyFirstController extends Controller {
  function validate() {
	// when this function returns false,
	// the controller is destroyed
	// (it won't execute)
	
	// the order of execution will be set to the
	// value returned by this function.
	// 1 being first, 2 being second, [...]
	
	// in the example below,
	// on the page "/user",
	// the controller runs with priority 1.

	// if the user visits any other url,
	// we cancel the execution.
	
	if (q('user')) return 1;
	else return false;
	
  }

  function execute() {
	// your application logic goes in this function.
	
	// add models to be passed on to the views
	$this->addModel('page', 'title', 'Lorem');
	
	// render a view
	// and pass all models
	// from all controllers
	$this->loadView('home.tpl');
  }
}</code></pre>

		</div>

	</div>
	<div class="col col-lg-6 col-md-6 col-sm-12 col-xs-12">
		<h3 id="View">View Example:</h3>

<div class="doc">
<pre><code class="language-html">
&lt;!-- Include header file -->
&#91;header.tpl]

&lt;!-- Fetch Current Theme files -->
&lt;!--
	/theme fetches
	/webapp/themes/[active_theme]/
-->
&lt;script type="text/javascript"
src="/theme/files/js/main.js">&lt;/script>

&lt;!-- Fetch Public Uploaded Files -->
&lt;!--
	/files fetches
	/webapp/files/public/
-->
&lt;a href="/files/doc.pdf">Download File&lt;/a>

&lt;!-- output model value -->
&lt;h1>&#91;page.title]&lt;/h1>

&lt;!-- output translated model value -->
&lt;h2>t&#91;Welcome!]&lt;/h2>

&lt;!-- output array block -->
&lt;ul>
&#91;for:block]
  &lt;li>&lt;a href="&#91;block.link]">&#91;block.text]&lt;/a>&lt;/li>
&#91;end:block]
&lt;/ul>

&lt;!-- Include footer file -->
&#91;footer.tpl]

</code></pre>
</div>

		
	</div>
  </div>
  <div class="row">
	<div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3 id="inject">Legit Injections Example:</h3>
<div class="doc">
<pre><code class="language-php">
class MyFirstInjection extends Controller {
  function validate() {
	if (q('home')) return 1;
	else return false;
  }

  function execute() {
	// render a view,
	// it could have been rendered
	// in another controller
	$this->loadView('home.tpl');
	
	/* default values:
		"content" => "",			// content to inject
		"file_contents" => "",		// ajax content to inject, overrides content
		"placeholder" => "body",	// selector: element#id.class
		"display" => "html",		// or text
		"filter" => "",				// selector: element#id.class
		"mode" => "append"			// or prepend, replace
	*/
	// this appends to the body element the string "&lt;h1>footer&lt;/h1>"
	$this->inject(
		"content" => "&lt;h1>footer&lt;/h1>"	// content to inject
	);

	// digging deeper
	$this->inject(
		// fetch the html of luclaverdure.com
		"file_contents" => "http://luclaverdure.com",
		// filter to only get the h2 contents from the above html
		"filter" => "h2",
		// output the h2 from the url into our current view's h1 (the placeholder)
		"placeholder" => "h1",
		// strip tags and only display text
		"display" => "text",
		// replace contents of h1, could have appended or prepended
		"mode" => "replace"
	);
	
  }
}

</code></pre>
</div>
	
	</div>
  </div>
  <div class="row">
	<div class="col col-lg-3 col-md-4 col-sm-12 col-xs-12 left-col">
		<p><span class="letspa">Technical Documentation</span></p>
		<ul>
			<li class="branch"><a href="#Functions">Functions</a></li>
			<li><a href="#q">&gt; q</a></li>
			<li><a href="#inpath">&gt; inpath</a></li>
			<li><a href="#elog">&gt; elog</a></li>
			<li><a href="#form_cache">&gt; form_cache</a></li>
			<li><a href="#validate_email">&gt; validate_email</a></li>
			<li><a href="#redirect">&gt; redirect</a></li>
			<li><a href="#t">&gt; t</a></li>
			<li><a href="#email">&gt; email</a></li>
			
			<li class="branch"><a href="#Controller">Controller</a></li>
			<li><a href="#addModel">&gt; addModel</a></li>
			<li><a href="#setModel">&gt; setModel</a></li>
			<li><a href="#modResultsModel">&gt; modResultsModel</a></li>
			<li><a href="#getModel">&gt; getModel</a></li>
			<li><a href="#loadModel">&gt; loadModel</a></li>
			<li><a href="#cacheForm">&gt; cacheForm</a></li>
			<li><a href="#setcache">&gt; setcache</a></li>
			<li><a href="#getcache">&gt; getcache</a></li>
			<li><a href="#loadView">&gt; loadView</a></li>
			<li><a href="#inject">&gt; inject</a></li>
			<li><a href="#loadViewAsJSON">&gt; loadViewAsJSON</a></li>
			<li><a href="#loadJSON">&gt; loadJSON</a></li>

			<li class="branch"><a href="#View">View</a></li>
			</ul>
	</div>
	<div class="col col-lg-9 col-md-8 col-sm-12 col-xs-12 docs-list">
		<div class="doc">
			<h3 id="q" class="head">q()</h3>
			<pre><code class="language-php">string q()</code></pre>
			<p>Get the current URL state. For example: http://mywebsite.com/user, q() would return "/user"</p>
			<pre><code class="language-php">string q( string $string )</code></pre>
			<p>Verify if current provided string matches URL path. For example: http://mywebsite.com/user, q('user') would return true. (Shortcut to function <a href="#inpath">inpath</a>)</p>
			<pre><code class="language-php">string q( int $arg )</code></pre>
			<p>Get the current URL path. For example: http://mywebsite.com/user, q(0) would return "user".</p>
		</div>

		<div class="doc">
			<h3 id="inpath" class="head">inpath(string $string)</h3>
			<pre><code class="language-php">string inpath('/user/*')</code></pre>
			<p>Verify if current provided string matches URL path. For example: http://mywebsite.com/user, inpath("/user/*") would return true.</p>
		</div>

		<div class="doc">
			<h3 id="elog" class="head">elog(string $string)</h3>
			<pre><code class="language-php">elog('message')</code></pre>
			<p>log message in logs/errors.log</p>
		</div>

		<div class="doc">
			<h3 id="form_cache" class="head">form_cache(string $form_name, array $default_values, string $options)</h3>
			<pre><code class="language-php">form_cache('my_form', array('first_name'=>'Luc', 'last_name'=>'laverdure'))</code></pre>
			<p>Steps taken:</p>
			<ol>
				<li>If no value is currently set, set default values into session.</li>
				<li>Override session variables if POST var or GET var matches a form field</li>
			</ol>
			<p>$options:</p>
			<ol>
				<li>'FORCE.CACHE': Force override session values with default values.</li>
				<li>'FETCH.ONLY': POST and GET vars are ignored.</li>
			</ol>
		</div>

		<div class="doc">
			<h3 id="validate_email" class="head">validate_email(string $email)</h3>
			<pre><code class="language-php">validate_email('contact@luclaverdure.com')</code></pre>
			<p>Returns true if email is valid, returns false if email is invalid.</p>
		</div>

		<div class="doc">
			<h3 id="redirect" class="head">redirect(string $URL)</h3>
			<pre><code class="language-php">redirect('/user')</code></pre>
			<p>redirects user to URL specified</p>
		</div>

		<div class="doc">
			<h3 id="t" class="head">t(string $string)</h3>
			<pre><code class="language-php">t('user')</code></pre>
			<p>print translated output, Database required to host all strings and their matched translations.</p>
		</div>

		<div class="doc">
			<h3 id="email" class="head">email(string $to, string $subject, string $message)</h3>
			<pre><code class="language-php">email('contact@luclaverdure.com', 'Hi Luc', 'ShiftSmith is awesome!')</code></pre>
			<p>Send email to target $to, with $subject and $message.</p>
		</div>

		<div class="doc">
			<h3 id="addModel" class="head">Controller->addModel(string $namespace, string $var, string $value)</h3>
			<pre><code class="language-php">$this->addModel('page', 'title', 'ShiftSmith')</code></pre>
			<p>Add a model to the Controller to render in a view. In the above example, [page.title] would render "ShfitSmith" in a templated file.</p>
		</div>

		<div class="doc">
			<h3 id="setModel" class="head">Controller->setModel(string $namespace, string $var, string $value)</h3>
			<p>(deprecated) same as $this->addModel</p>
		</div>

		<div class="doc">
			<h3 id="modResultsModel" class="head">Controller->modResultsModel(array $results, array $keys, function $function, string $new_col)</h3>
			<pre><code class="language-php">???</code></pre>
			<p>I forgot what I built this for, usability coming soon!</p>
		</div>

		<div class="doc">
			<h3 id="getModel" class="head">Controller->getModel(string $namespace, string $var)</h3>
			<pre><code class="language-php">$this->getModel('page', 'title')</code></pre>
			<p>returns the value of $namespace.$var</p>
		</div>

		<div class="doc">
			<h3 id="loadModel" class="head">Controller->loadModel(string $namespace, string $var, controller $controler)</h3>
			<pre><code class="language-php">$this->loadModel('page', 'title')</code></pre>
			<p>I forgot what it does o_O</p>
		</div>

		<div class="doc">
			<h3 id="cacheForm" class="head">Controller->cacheForm(string $name, array $default_values, Y/N $forcecache)</h3>
			<pre><code class="language-php">$this->cacheForm('subscribe', array('email'=>'contact@luclaverdure.com', 'first_name'=>'Luc', 'last_name'=>'the batman'))</code></pre>
			<p>Automaticcally save to session all values of the form initial or set</p>
		</div>

		<div class="doc">
			<h3 id="setcache" class="head">Controller->cacheForm(string $namespace, string $name, string $value)</h3>
			<pre><code class="language-php">$this->cacheForm('subscribe', 'email', 'contact@luclaverdure.com')</code></pre>
			<p>Single namespace + name cache storage</p>
		</div>

		<div class="doc">
			<h3 id="getcache" class="head">Controller->getcache(string $namespace, string $name)</h3>
			<pre><code class="language-php">$this->getcache('subscribe', 'email')</code></pre>
			<p>Single namespace + name cache fetch from storage</p>
		</div>

		<div class="doc">
			<h3 id="loadView" class="head">Controller->loadView(string||array $view_filename)</h3>
			<pre><code class="language-php">$this->loadView('docs.tpl')</code></pre>
			<p>Render output with models passed to view.</p>
		</div>

		<div class="doc">
			<h3 id="loadViewAsJSON" class="head">Controller->loadViewAsJSON($omitted_namespaces, $ommited_models)</h3>
			<pre><code class="language-php">$this->loadViewAsJSON(array('user'), array('password'))</code></pre>
			<p>Echoes JSON output of all models, except omitted namespaces and omitted models</p>
		</div>

		<div class="doc">
			<h3 id="loadJSON" class="head">Controller->loadJSON()</h3>
			<pre><code class="language-php">$this->loadJSON()</code></pre>
			<p>Echoes JSON output of all models, no exceptions.</p>
		</div>
		
</div>

</div>
</div>
[footer.tpl]