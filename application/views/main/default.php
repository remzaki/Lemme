	<?php echo form_open("lemme/poslog");?>
	
	<div id="container">
		<div class="controlpanel">
			<div class="control">
				<div style="padding-top:1em;">Connection Settings:</div>
				<div><input name="server" type="text" value="<?php echo set_value('server');?>" placeholder="Database Server" title="Database Server" autofocus />*</div>
				<div><input name="instance" type="text" value="<?php echo set_value('instance', 'NCRWO');?>" placeholder="Database Instance" title="Database Instance" />*</div>
				<div><input name="username" type="text" value="<?php echo set_value('username', 'sa');?>" placeholder="Database Username" title="Database Username" />*</div>
				<div><input name="password" type="text" value="<?php echo set_value('password', 'RTE$t0re');?>" placeholder="Database Password" title="Database Password" />*</div>
				
				<div style="padding-top:1em;">Search Table:</div>
				<div>
					<select id="table" name="table" onchange='able()'>
						<option value="Transactions"<?php echo set_select('table', 'Transactions', TRUE); ?>>Transactions</option>
						<option value="ErrorQueue"<?php echo set_select('table', 'ErrorQueue'); ?>>ErrorQueue</option>
						<option value="InputQueue"<?php echo set_select('table', 'InputQueue'); ?>>InputQueue</option>
						<option value="OutputQueue"<?php echo set_select('table', 'OutputQueue'); ?>>OutputQueue</option>
						<option value="PendingQueue"<?php echo set_select('table', 'PendingQueue'); ?>>PendingQueue</option>
					</select>
				</div>
				
				<div style="padding-top:1em;">Transaction Filters:</div>
				<div><input id="store" name="store" type="text" value="<?php echo set_value('store');?>" placeholder="Store Number" title="Store Number" maxlength="8" /></div>
				<div><input name="terminal" type="text" value="<?php echo set_value('terminal');?>" placeholder="Terminal Number" title="Terminal Number" maxlength="8" /></div>
				<div><input name="transaction" type="text" value="<?php echo set_value('transaction');?>" placeholder="Transaction Number" title="Transaction Number" maxlength="8" /></div>
				<div>Transaction Type:</div>
				<div>
					<select id="transtype" name="transtype">
						<option value="0"<?php echo set_select('transtype', '0', TRUE); ?>>All</option>
					</select>
				</div>
				
				<div><input id="submitbtn" class="btn-success" type="submit" name="sl" value="Search" /></div>
				
				<div class="options" style="padding-top:2em;"><a href="#" onclick="swap()">Switch Panels</a></div>
				<div class="options"><a class="tool" href="#script" disabled>Generate SQL Script</a></div>
				<div class="options"><div id="url" class='tool'><input class='tool' type="submit" name="url" value="Generate URL" /></div></div>
			</div>
		</div>
		<div class="resultpanel">
			<div class="result">
			<input id='hylyt' type='hidden' value=''/>
				<div id="resultstable" style="padding:;">
					<h2 style='color:#64C164;'>Whats New?</h2>
					<div class="media">
					  <div class="media-body">
						<h4 class="media-heading" style='color:#64C164;'>Different Look</h4>
						Looking fresh with green. I thought you didn't notice! :)
					  </div>
					</div>
					<div class="media">
					  <div class="media-body">
						<h4 class="media-heading" style='color:#64C164;'>Database Credentials</h4>
						Now supports connecting to Database with custom credentials. The previously hardcoded username and password is now available in the Connection Settings group. By default it will be using the User 'sa' with Password 'RTE$t0re'.
					  </div>
					</div>
					<div class="media">
					  <div class="media-body">
						<h4 class="media-heading" style='color:#64C164;'>Search Table</h4>
						You can now search for the POSLog that are under all the other Tables in the [TransactionLogDb] Database. The Error will also be displayed in the results when searching for POSLog on [ErrorQueue].
					  </div>
					</div>
					<div class="media">
					  <div class="media-body">
						<h4 class="media-heading" style='color:#64C164;'>Transaction Type Filter</h4>
						Aside from the previous filter fields. You can now filter the POSLog by its Transaction Type to narrow down results. Only applicable for searching in [Transactions] table. Will show options when connected to a Database.
					  </div>
					</div>
					<div class="media">
					  <div class="media-body">
						<h4 class="media-heading" style='color:#64C164;'>Show More Results</h4>
						Removed the Number of Records field. When Searching and results are more than 25 records, Show More button will be available to load additional 20 records.
					  </div>
					</div>
					<div class="media">
					  <div class="media-body">
						<h4 class="media-heading" style='color:#64C164;'>Switch Panels</h4>
						Switch the Search panel and Results panel to fit with your preference. Please be aware this will clear any results and filters.
					  </div>
					</div>
					<div class="media">
					  <div class="media-body">
						<h4 class="media-heading" style='color:#64C164;'>Generate the SQL Script</h4>
						Helping you to learn or better analyze the results. Simply copy the SQL Script and use it for your Query.
					  </div>
					</div>
					<div class="media">
					  <div class="media-body">
						<h4 class="media-heading" style='color:#64C164;'>Share the POSLog Search Results</h4>
						Easy access to everyone's queries by using a URL to search it right away.
					  </div>
					</div>
					<div class="media">
					  <div class="media-body">
						<h4 class="media-heading" style='color:#64C164;'>Comments/Suggestions/Issues?</h4>
						Contact me on Lync or Skype. :)
					  </div>
					</div>
					
					<script>
						$(document).ready(function(){
							$(".tool").click(function(){
								return false;
							});
						});
					</script>
					<style>.tool, .tool:hover, .tool:visited, .tool:active, .tool:link, #url input, #url input:hover{ color: gray; }</style>
					<div id="more"><input type="submit" name="sm" value="Show More..." /></div>
				</div>
			</div>
		</div>
	
	</div>
	</form>
	<script>	
		$(document).ready(function(){
			$("#<?php echo $top; ?>").hide();
			$(".errq").hide();
			$("#more").hide();
			
			var n = $("#<?php echo $top; ?>").length;
			var z = $("#errq").length;
			
			if(n!=0){
				$("#more").show();
			}
			
			able();
		});
		
		function swap(){
			var pop = confirm("WARNING: Switch Panels will clear all of the Search Filters and Results.");
			if(pop){
				window.location.href='./main?s=<?php echo $pos; ?>';
			}else{}
		}
		
		function pick(e){
			var prev = document.getElementById('hylyt').value;
			if(prev!=""){
				document.getElementById(prev).style.background='';
			}
			onmouseup = document.getElementById(e).style.background='#D6D6D6';
			document.getElementById('hylyt').value=e;
		};
		
		function expand(e){
			var row = $("#errq"+e);
			
			if(row.is(":visible")){
				onmouseup = row.hide();
			}else{
				$(".errq").hide();
				onmouseup = row.show();
			}
		};
		
		function able(){
			var e = document.getElementById("table");
			var strUser = e.options[e.selectedIndex].text;
			
			if(strUser!="Transactions"){
				//	DISABLE THE TRANSACTION TYPE DROPDOWN
				document.getElementById("transtype").disabled = true;
			}else{
				// ENABLE THE TRANSACTION TYPE DROPDOWN
				document.getElementById("transtype").disabled = false;
			}
		}
	</script>