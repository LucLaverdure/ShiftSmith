[header.tpl]

<div style="background: #fff url(/theme/files/img/sections/docs-bg.jpg) center center;min-height:200px;">
</div>
<div class="container">
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
<pre><code class="language-php">
&lt;!-- Include header file -->
&#91;header.tpl]

&lt;!-- Fetch Current Theme files -->
&lt;!-- /theme fetches
        /webapp/themes/[active_theme]/
-->
&lt;script type="text/javascript" src="/theme/files/js/main.js">&lt;script>

&lt;!-- Fetch Public Uploaded Files -->
&lt;!-- /files fetches
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
			<li><a href="#injectView">&gt; injectView</a></li>
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
			<h3 id="injectView" class="head">Controller->injectView($selector_output, $mode, $inputURL, $selector_input)</h3>
			<p>Input: (http://luclaverdure.com)</p>
			<pre><code class="language-php">
				&lt;html>
					&lt;head>&lt;/head>
					&lt;body>
						[...]
							&lt;h1 class="name">&lt;a href="/">Luc Laverdure&lt;/a>&lt;/h1>
						[...]
					&lt;/body>
				&lt;html>
			</code></pre>
			<p>Output: (myapp/view.tpl)</p>
			<pre><code class="language-php">
				&lt;html>
					&lt;head>&lt;/head>
					&lt;body>
						&lt;div class="fetched-title">&lt;/div>
					&lt;/body>
				&lt;html>
			</code></pre>
			<p>Output: (myapp/view.tpl)</p>
			<pre><code class="language-php">
				$this->loadView('myapp/view.tpl')
				$this->injectView('.fetched-title', 'append', 'http://luclaverdure.com', 'h1 a');
			</code></pre>
			<p>Inject render within view</p>
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