<h2>Publicadores</h2>
<div class="addNew btn">Añadir nuevo publicador</div>

<div id="all-publishers">


	<?php
	foreach ($publishers as $key => $pub):

		echo "<div class='pub'>".$pub['last'].", ".$pub['first']. "</div>";

	endforeach;
	?>

</div>