<?php
// DB QUERIES GO HERE
include('queries.php'); ?>

<!DOCTYPE html>
<html lang="en-us">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta HTTP-EQUIV="Pragma" content="no-cache">
<meta HTTP-EQUIV="Expires" content="-1" >
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="style.css">
</head>
<body>

<?php if( isset($_GET['msg']) || isset($_GET['err']) ):

	if( isset($_GET['err']) ):
		$msg = $_GET['err'];
		$cls = 'msg err';
	else:
		$msg = $_GET['msg'];
		$cls = 'msg';
	endif;

	?>
	<script>history.pushState('', document.title, window.location.pathname);</script>
	<div class="<?= $cls; ?>"><?= $msg; ?></div>

<?php endif; ?>

<section id="main-container">

	<span class="welcome">Welcome <?= $go; ?></span>
	<h1>Manage Group Territories</h1>

	<h2>Assign Territory</h2>


	<form id="chOut" method="post">
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

		<div class="userWterrs">
			<div class="user">
				<?php $fullName = $t[$key]['firstName'] .' '. $t[$key]['lastName']; ?>
				<h3><?= $fullName; ?></h3>
				<i>oldest - <?= time_elapsed_string('@'.$t[$key]['checkedOut'], true); ?></i>
				<a class="checkin all">
					<span class="cin"><i class="fa fa-check"></i>in</span> ALL
				</a>			
			</div>
			
			<div class="tco">
			
				<?php
				foreach ($t as $tt): ?>
					<div class="terrDetails">
						<h4 class="tnum">Terr #<?= $tt['terrNum']; ?> - </h4>
						<a class="checkin">
							<span class="cin"><i class="fa fa-check"></i>in</span>
							<span class="details"
								name="<?= $fullName; ?>"
								id="<?= $tt['userID']; ?>"
								tid="<?= $tt['terrNum']; ?>"
								time="<?= $tt['checkedOut']; ?>"></span>
						</a>
						<span class="codate">
							<?php
							date_default_timezone_set("America/Chicago");
							$daysAgo = time_elapsed_string('@'.$t[$key]['checkedOut']);
							$exactX  = date('M jS Y \a\t g:i:s a', $tt['checkedOut']); ?>
							Checked out <?= $daysAgo; ?> <br>on <?= $exactX; ?>
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

	<h2>No Territories Checked Out</h2>
	<span>You can check out a territory above.</span>
	<?php
	endif; ?>

</section>

<div id="popup">
	<div id="pcontainer">
		<h3>Nothing to see here...</h3>
		<span class="yes">Yes</span>
		<span class="no" onclick="resetPop()">Cancel</span>
		<form id="chIn" method="post">
			<input id="uid" type="hidden" name="uid">
			<input id="tid" type="hidden" name="tid">
			<input id="time" type="hidden" name="time">
		</form>
	</div>
</div>
<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="blur-svg">
    <defs>
        <filter id="blur-filter">
            <feGaussianBlur stdDeviation="3"></feGaussianBlur>
        </filter>
    </defs>
</svg>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="script.js"></script>
</body>
</html>

<?php

function dd($data) {
	highlight_string("<?php\n\$data =\n" . var_export($data, true) . ";\n?>");
	die();
}