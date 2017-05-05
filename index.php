<!DOCTYPE html>
<html lang="en-us">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
</head>
<body>

<?php include('queries.php'); ?>

<span class="welcome">Welcome <?= $go; ?></span>
<h1>Manage Group Territories</h1>

<h2>Assign Territory</h2>


<form method="post">
	<select name="publisher" id="publisher">
		<?php foreach($publishers as $publisher): ?>
		<option value="<?= $publisher['id']; ?>"><?= $publisher['last'] . ', ' . $publisher['first']; ?></option>
		<?php endforeach; ?>
	</select>
	<div id="terr-select">
		<?php foreach($territories as $territory): ?>
		<input type="checkbox" name="terrs[]" value="<?= $territory; ?>" id="terr<?= $territory; ?>">
		<label for="terr<?= $territory; ?>" data-attr="<?= $territory; ?>"></label>
		<?php endforeach; ?>
	</div>
	<input type="hidden" placeholder="Territory Number(s)">
	<input type="submit" value="Assign">
</form>


<?php
if( isset($territoriesCOd) && ! empty($territoriesCOd) ): ?>

<h2>Territories Checked Out</h2>

<ul>
<?php
$name = '';
foreach ($territoriesCOd as $t):
	$newName = $t['first_name'].$t['last_name'];
	if( $name !== $newName ):
		$name = $t['first_name'].$t['last_name']; ?>

	<li><?= $t['first_name'] .' '. $t['last_name']; ?> - <?= date('M jS Y h:i:s a', $t['checked_out']); ?></li>
	
	<?php
	endif;
	?>
	<span><?= $t['terr_num'] . ' - ' . date('M jS Y h:i:s a', $t['checked_out']); ?></span><br>
<?php
endforeach; ?>
</ul>

<?php
else: ?>

<h2>No Territories Checked Out</h2>
<span>You can check out a territory above.</span>
<?php
endif; ?>

<script src="script.js"></script>
</body>
</html>