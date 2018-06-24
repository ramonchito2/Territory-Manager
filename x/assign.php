<h2>Asignar Territorios</h2>

<?php // ADDED THE BASIS FOR SENDING EMAILS THROUGH KHPROGRAMS GMAIL
// include('informOldTerrs'); ?>

<?php if( current_user_can('edit_others_pages') ): ?>
<select id="group" onchange="groupFilter()">
	<option>Todos los grupos</option>
	<option>Calle 89</option>
	<option>Crisp</option>
	<option>Grandview</option>
	<option>Harris</option>
	<option>Stark</option>
</select>
<?php endif; ?>

<form id="chOut" method="post">
	<select name="publisher" id="publisher" required>
		<option value="" disabled selected>Seleccionar un publicador...</option>
		<?php 
		foreach($publishers as $publisher): 
			$pg 	= $publisher['group'];
			$pid	= $publisher['id'];
			$pname 	= $publisher['last'] . ', ' . $publisher['first']; 
		?>
		<option	group="<?= $pg; ?>"	value="<?= $pid; ?>"><?= $pname; ?></option>
		<?php endforeach; ?>
	</select>
	<div id="terr-select">
		<?php foreach($territories as $territory): ?>
		<input type="checkbox" name="terrs[]" value="<?= $territory['id']; ?>" id="terr<?= $territory['id']; ?>">
		<label group="<?= $territory['group']; ?>" for="terr<?= $territory['id']; ?>" data-attr="<?= $territory['id']; ?>"></label>
		<?php endforeach; ?>
	</div>
	<input type="hidden" placeholder="Territory Number(s)">
	<input type="submit" value="Asignar">
</form>


<?php
if( isset($territoriesCOd) && ! empty($territoriesCOd) ): ?>

<h2>Territorios Asignados</h2>

<div id="all-checkedout">

	<?php
	$tco = array();

	// Group each user and territories into it's own array
	// keeps queried order
	foreach ($territoriesCOd as $key => $item) {
		$tco[$item['userID']][$key] = $item;
	}
	// dd($+tco);

	foreach ($tco as $t): 
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
	endforeach; ?>

	<?php
	else: ?>

	<h2>No Territorios Asignados</h2>
	<span>Puede asignar un territorio arriba.</span>
	<?php
	endif; ?>

</div>