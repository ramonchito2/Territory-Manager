<h2>Groupos</h2>

<div id="all-groups">

	<?php
	$tco = array();

	// Group each user and territories into it's own array
	// keeps queried order
	foreach ($allGroups as $key => $group) {
		
	}
	// dd($+tco);

	/* foreach ($tco as $t): 
		reset($t);
		$key = key($t); ?>

		<div group="<?= $t[$key]['group']; ?>" class="userWterrs">
			<div class="user">
				<?php $fullName = $t[$key]['firstName'] .' '. $t[$key]['lastName']; ?>
				<h3><?= $fullName; ?></h3>
				<?php if( current_user_can('edit_others_pages') ): ?>
					<span class="ugroup"><?= $t[$key]['group']; ?></span>
				<?php endif; ?>
				<i>más viejo - <?= time_elapsed_string('@'.$t[$key]['checkedOut'], true); ?></i>
				<a class="checkin all">
					<span class="cin"><i class="fa fa-check"></i>entregar</span> TODO
				</a>			
			</div>
			
			<div class="tco">
			
				<?php
				foreach ($t as $tt): ?>
					<div class="terrDetails">
						<h4 class="tnum">Terr #<?= $tt['terrNum']; ?> - </h4>
						<a class="checkin">
							<span class="cin"><i class="fa fa-check"></i>entregar</span>
							<span class="details"
								name="<?= $fullName; ?>"
								id="<?= $tt['userID']; ?>"
								tid="<?= $tt['terrNum']; ?>"
								time="<?= $tt['checkedOut']; ?>"></span>
						</a>
						<span class="codate">
							<?php
							date_default_timezone_set("America/Chicago");
							$daysAgo = time_elapsed_string('@'.$tt['checkedOut']);
							$exactX  = date('M d Y \a \l\a\s g:i:s a', $tt['checkedOut']); ?>
							Entregado <?= $daysAgo; ?> <br>el <?= $exactX; ?>
							<?php if( $tt['byID'] ):
								echo '<br>por '. get_user_by('ID', $tt['byID'])->display_name;
							endif; ?>
						</span>
					</div>
				<?php
				endforeach; ?>

			</div>
		</div>

	<?php 
	endforeach; */?>

</div>