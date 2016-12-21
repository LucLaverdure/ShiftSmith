<div class="adv-settings">
							<div class="db-select" style="display:none;">
							<div class="header-block">Database Import</div>
							<span class="helper">Fetch information from a database. This content is to either import data from a database to ShiftSmith or to select data from ShiftSmith's database.</span>

							<h3 class="sub-header-block">Database Hostname:</h3>
								<span class="helper">Provide the hostname of the database, for example: "localhost". Leave the field blank to select the database in use by shiftsmith.</span>
<!-- Host -->
								<input type="text" value="[page.dbInHost]" placeholder="localhost" class="forge-url-trigger" name="dbInHost" />
								
								<h3 class="sub-header-block">Database User:</h3>
								<span class="helper">Provide the user connecting to the database, for example: "admin". Leave the field blank to select the user connected to shiftsmith's database.</span>
<!-- User -->								
								<input type="text" value="[page.dbInUser]" name="dbInUser" placeholder="user" class="forge-url-trigger" />
								<h3 class="sub-header-block">Database Password:</h3>
								<span class="helper">Provide the password of the database, for example: "admin123". Leave the field blank to select the password connected to shiftsmith's database.</span>
<!-- Password-->								
								<input type="password" value="[page.dbInPassword]" name="dbInPassword" placeholder="password" class="forge-url-trigger" />
								
								<h3 class="sub-header-block">Database Name:</h3>
								<span class="helper">Make an SQL query to get input data.</span>

<!-- DB Name -->								
								<input type="text" value="[page.dbInName]" name="dbInName" placeholder="db_data" class="forge-url-trigger" />
								
								<h3 class="sub-header-block">Database SQL:</h3>
<!-- DB SQL -->
								<input type="text" value="[page.dbInSQL]" name="dbInSQL" placeholder="SELECT * FROM users" class="forge-url-trigger" />
							</div>
</div>