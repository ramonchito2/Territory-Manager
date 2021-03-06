<h2>Asignar Territorios</h2>

<?php // ADDED THE BASIS FOR SENDING EMAILS THROUGH KHPROGRAMS GMAIL
// include('informOldTerrs'); ?>

<?php if( current_user_can('edit_others_pages') ): ?>
<select id="group" onchange="groupFilter()">
	<option all>Todos los grupos</option>
	<?php foreach($allGroups as $g): ?>
		<?php $selected = $g === $group ? ' selected' : ''; ?>
		<option<?= $selected; ?>><?= $g; ?></option>
	<?php endforeach; ?>
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
			$class = $group && $pg !== $group ? "hidden" : '';
		?>
		<option	group="<?= $pg; ?>"	value="<?= $pid; ?>" class="<?= $class; ?>"><?= $pname; ?></option>
		<?php endforeach; ?>
	</select>
	<div id="terr-select">
		<?php foreach($territories as $territory): ?>
		<?php $class = $group && $territory['group'] !== $group ? "hidden" : ''; ?>
		<input type="checkbox" name="terrs[]" value="<?= $territory['id']; ?>" id="terr<?= $territory['id']; ?>">
		<label group="<?= $territory['group']; ?>" for="terr<?= $territory['id']; ?>" class="<?= $class; ?>" data-attr="<?= $territory['id']; ?>"></label>
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
		$key = key($t); 
		$class = $group && $t[$key]['group'] !== $group ? " hidden" : '';?>

		<div group="<?= $t[$key]['group']; ?>" class="userWterrs<?= $class; ?>">
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
							Asignado <?= $daysAgo; ?> <br>el <?= $exactX; ?>
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

<div id="popup">
	<div id="pcontainer">
		<h3>Nada que ver aqui...</h3>
		<span class="yes">Sí</span>
		<span class="no" onclick="resetPop()">Cancelar</span>
		<form id="chIn" method="post">
			<input id="uid" type="hidden" name="uid">
			<input id="tid" type="hidden" name="tid">
			<input id="time" type="hidden" name="time">
		</form>
	</div>
</div>