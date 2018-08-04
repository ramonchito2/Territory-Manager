<h2>Publicadores</h2>

<div id="all-publishers">

	<?php
	foreach ($publishers as $key => $pub):

		echo "<div class='pub'>".$pub['last'].", ".$pub['first']. "</div>";

	endforeach;
	?>

</div>