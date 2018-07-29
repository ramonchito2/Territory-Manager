<h2>Territorios de Raytown Spanish</h2>

<div class="allTerritories">
	
	<?php
	$num = 0; $keepgoing = true;
	for( $x = 1; $x <= $numOfTerrs; $x++ ):
		$t = isset($territoriesAll[$num]) ? $territoriesAll[$num] : false;
		echo "<div class='terrHistory'><h3>Territorio $x</h3>";
		if( $t && $t['terr_id'] == $x):
			echo '<span>' . $t['firstName'] . ' ' . $t['lastName'] . ' - ';
			echo date('n/d/y', $t['checked_out']) . ' | ';
			echo date('n/d/y', $t['checked_in']) . '</span>';
			while( $keepgoing ):
				$tt = isset($territoriesAll[$num + 1]) ? $territoriesAll[$num + 1] : false;
				if( $tt && $tt['terr_id'] == $x ):
					echo '<span>' . $tt['firstName'] . ' ' . $tt['lastName'] . ': ';
					echo date('n/d/y', $tt['checked_out']) . ' - ';
					echo date('n/d/y', $tt['checked_in']) . '</span>';
					$num++;
				else:
					$keepgoing = false;
				endif;
			endwhile;
			$num++; $keepgoing = true;
		else:
			echo "<span>No historia</span>";
		endif;
		echo "</div>";
	endfor;
	?>

</div>