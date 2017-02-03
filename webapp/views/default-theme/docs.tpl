[default-theme/header.tpl]

<div class="parallax-window sub" data-parallax="scroll" data-image-src="/files/img/home-bg.jpg">
	<h1 class="hero">ShiftSmith - Docs</h1>
</div>
<div class="wrapper features-area cf">

	<div class="left-col">
		<p><span class="letspa">Documents in gear</span></p>
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
		</ul>
	</div>
	<div class="content docs-list">
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
			<pre><code class="language-php">form_cache('my_form', array('first_name'=>'Luc', 'last_name'=>'laverdure))</code></pre>
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
			<pre><code class="language-php">$this->loadView('default-theme/docs.tpl')</code></pre>
			<p>Render output with models passed to view.</p>
		</div>

		<div class="doc">
			<h3 id="injectView" class="head">Controller->injectView($selector_output, $mode, $inputURL, $selector_input)</h3>
			<p>Input: (http://luclaverure.com)</p>
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


[default-theme/footer.tpl]