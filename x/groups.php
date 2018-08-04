<h2>Groupos</h2>

<div id="all-groups">

	<?php
	$group = array();

	// Group each user and territories into it's own array
	// keeps queried order

	foreach ($publishers as $key => $pub):
		$group[$pub['group']][] = $pub; 
	endforeach;
	ksort($group);

	foreach ($group as $key => $pubs):
		// var_dump($count); var_dump(count($group)); echo "<br><br>";
		echo "<div group='".$key."' class='group'>";
		echo "<h2>".$key."</h2>";
		
		foreach ($pubs as $p):
			echo "<div class='pub'>".$p['last'].", ".$p['first']. "</div>";
		endforeach;

		echo "</div>";
	endforeach;
	?>

</div>