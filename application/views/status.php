	<div id="status">
		<span id="message"><?php 
		
		if(!$error){}else{echo $error;}
		
		 ?></span>
		<span id="stats">Took {elapsed_time}s and {memory_usage} of Memory</span>
	</div>