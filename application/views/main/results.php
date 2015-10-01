	<?php echo form_open("lemme/poslog"); $baseurl=base_url("lemme")."/"; ?>
	
	<div id="container">
		<div class="controlpanel">
			<div class="control">
				<div style="padding-top:1em;">Connection Settings:</div>
				<div><input name="server" type="text" value="<?php if(isset($server)){ echo $server; }else{ echo set_value('server'); }?>" placeholder="Database Server" title="Database Server" autofocus />*</div>
				<div><input name="instance" type="text" value="<?php if(isset($instance)){ echo $instance; }else{ echo set_value('instance', 'NCRWO'); }?>" placeholder="Database Instance" title="Database Instance" />*</div>
				<div><input name="username" type="text" value="<?php if(isset($username)){ echo $username; }else{ echo set_value('username', 'sa'); }?>" placeholder="Database Username" title="Database Username" />*</div>
				<div><input name="password" type="text" value="<?php if(isset($password)){ echo $password; }else{ echo set_value('password', 'RTE$t0re'); }?>" placeholder="Database Password" title="Database Password" />*</div>
				
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
				<div><input id="store" name="store" type="text" value="<?php if(isset($store)){ echo $store; }else{ echo set_value('store'); }?>" placeholder="Store Number" title="Store Number" maxlength="8" /></div>
				<div><input name="terminal" type="text" value="<?php if(isset($term)){ echo $term; }else{ echo set_value('terminal'); }?>" placeholder="Terminal Number" title="Terminal Number" maxlength="8" /></div>
				<div><input name="transaction" type="text" value="<?php if(isset($trans)){ echo $trans; }else{ echo set_value('transaction'); }?>" placeholder="Transaction Number" title="Transaction Number" maxlength="8" /></div>
				<div>Transaction Type:</div>
				<div>
					<select id="transtype" name="transtype">
						<option id="opt0" value="0"<?php echo set_select('transtype', '0', TRUE); ?>>All</option>
						<?php
						if(isset($transtypes) AND ($transtypes!="")){	// CHECK IF THE $transtypes IS NOT EMPTY
							foreach($transtypes as $row)	//	DISPLAY TRANSACTION TYPES
							{
								$id = $row->TransactionTypeID;
								$desc = $row->TransactionTypeDescription;
								echo "<option id='opt".$id."' value='".$id."'";
								echo set_select('transtype', "$id");
								echo ">".$desc."</option>";
							}
						}
						?>
						
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
<?php 		if(isset($result['error_message'])): ?>
					<br/>
					<?php echo $result['error_message'][0]['message']; ?>
					<br/>
					<?php echo $result['error_message'][1]['message']; ?>
					<br/>
					<?php echo $result['error_message'][2]['message']; ?>
<?php 		elseif((isset($result[0]['error_empty'])) OR (isset($result['error_empty'])) ): ?>
				<div id='resultstable'>
					<div style='text-align:center;font-size:2em;color:#D3D3D3;padding-top:2em;'><?php echo $result[0]['error_empty']?></div>
				</div>
<?php 		else: ?>
				<div id='resultstable'>
					<table border='1' style='border-collapse:collapse;'>
<?php 			switch($table):
					case 'Transactions': ?>
						<tr style='background:#E6E6E6;'>
							<th>TransType</th>
							<th>TransTypeId</th>
							<th>Store</th>
							<th>Terminal</th>
							<th>POSLog</th>
							<th colspan='2'>Action</th> 
						</tr>
<?php					$id=1;
						foreach($result[0] as $row): 
						$counter = $id++; ?>
						<tr id='<?php echo $counter; ?>' onclick='pick("<?php echo $counter; ?>")' >
							<td><?php echo $row->TransType; ?></td>
							<td style=''><?php echo $row->TransTypeId; ?></td>
							<td style=''><?php echo $row->StoreId; ?></td>
							<td style=''><?php echo $row->TermId; ?></td>
							<td><a href='<?php echo $baseurl."view/".$row->TranID; ?>' target='_blank'><?php echo $row->TranID; ?></a></td>
							<td style=''><a href='<?php echo $baseurl."view/".$row->TranID; ?>' target='_blank'>View</a></td>
							<td style=''><a href='<?php echo $baseurl."download/".$row->TranID; ?>' target='_blank'>Download</a></td>
						</tr>
<?php					endforeach ?>
<?php 				break;?>
<?php 				case 'ErrorQueue': ?>
						<script>$(".errq").hide();</script>
						<tr style='background:#E6E6E6;'>
							<th>Timestamp</th>
							<th>POSLog</th>
							<th colspan='3'>Action</th> 
						</tr>
<?php					$id=1;
						foreach($result[0] as $row): 
						$counter = $id++; ?>
						<tr id='<?php echo $counter; ?>' onclick='pick("<?php echo $counter; ?>")' >
							<td><?php echo $row->Timestamp; ?></td>
							<td><a href='<?php echo $baseurl."view/".$row->TransactionKey; ?>' target='_blank'><?php echo $row->TransactionKey; ?></a></td>
							<td style='width:8em;'><a href='#' onclick='expand("<?php echo $counter; ?>")'>View Error</a></td>
							<td style='width:8em;'><a href='<?php echo $baseurl."view/".$row->TransactionKey; ?>' target='_blank'>View</a></td>
							<td style='width:8em;'><a href='<?php echo $baseurl."download/".$row->TransactionKey; ?>' target='_blank'>Download</a></td>
						</tr>
						<tr class='errq' id='errq<?php echo $counter; ?>' style='background:#F3F3F3;'><td colspan='6' style='text-align:left;padding:0.5em 0.5em 2em;'><span style='color:#C55630;'><?php echo nl2br($row->Error); ?></span></td></tr>
<?php					endforeach ?>
<?php 				break;?>
<?php				default: ?>
						<tr style='background:#E6E6E6;'>
							<th>Sequence Number</th>
							<th>TenantId</th>
							<th>POSLog</th>
							<th colspan='2'>Action</th> 
						</tr>
<?php					$id=1;
						foreach($result[0] as $row): 
						$counter = $id++; ?>
						<tr id='<?php echo $counter; ?>' onclick='pick("<?php echo $counter; ?>")'>
							<td style='width:8em;'><?php echo $row->SequenceNumber; ?></td>
							<td style='width:8em;'><?php echo $row->TenantId; ?></td>
							<td><a href='<?php echo $baseurl."view/".$row->TransactionKey; ?>' target='_blank'><?php echo $row->TransactionKey; ?></a></td>
							<td style='width:8em;'><a href='<?php echo $baseurl."view/".$row->TransactionKey; ?>' target='_blank'>View</a></td>
							<td style='width:8em;'><a href='<?php echo $baseurl."download/".$row->TransactionKey; ?>' target='_blank'>Download</a></td>
						</tr>
<?php					endforeach ?>
<?php 			endswitch; ?>
					</table>
				</div>
<?php 		endif; ?>

				<script>$("#more").hide();</script>
				<div id="more"><input type="submit" name="sm" value="Show More..." /></div>
			</div>
		</div>
	</div>
	</form>
	<script>
		document.getElementById('table').value="<?php if(isset($table)){ echo $table; } ?>";
		document.getElementById('transtype').value="<?php if(isset($transtype)){ echo $transtype; } ?>";
		document.getElementById('opt<?php if(!$trty OR !isset($trty) OR $trty==""){$trty="0";} echo $trty;?>').selected=true;
				
		$(document).ready(function(){
			$("#<?php echo $top; ?>").hide();
			$(".errq").hide();
			$("#more").hide();
			
			var z = $("#errq").length;
			var n = $("#<?php echo $top; ?>").length;
			
			if(n!=0){
				$("#more").show();
			}
			
			able();
			
		});
		
		function swap(){
			var pop = confirm("WARNING: Switch Panels will clear all of the Search Filters and Results.");
			if(pop){
				window.location.href='<?php echo $baseurl."?s=".$pos; ?>';
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