	<div>
		<a href="#" id="script" class="overlay"></a>
		<div class="popup">
			<h4 style="border-bottom:1px solid gray;padding-bottom:0.5em;">SQL Script:</h4>
			<div style='text-align:left;border-bottom:1px solid gray;padding-bottom:1em;'>
		<?php	if(isset($result[1])){
					print nl2br($result[1]);
				} ?>
			</div>
			<div style="text-align:right;"><p><a href="#">Close</a></p></div>
		</div>
	</div>