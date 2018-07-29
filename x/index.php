<?php

include('tapplogin.php');

if( IS_PRODUCTION_SERVER )
	$version = '?v=1.3';
else
	$version = null;

date_default_timezone_set("America/Chicago");
?>

<!DOCTYPE html>
<html lang="en-us">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="apple-touch-icon" sizes="180x180" href="<?= get_bloginfo('template_url');?>/assets/images/favicons/apple-touch-iconn.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?= get_bloginfo('template_url');?>/assets/images/favicons/faviconn-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?= get_bloginfo('template_url');?>/assets/images/favicons/faviconn-16x16.png">
<link rel="manifest" href="<?= get_bloginfo('template_url');?>/assets/images/favicons/manifest.json">
<link rel="mask-icon" href="<?= get_bloginfo('template_url');?>/assets/images/favicons/safari-pinned-tabb.svg" color="#f47c48">
<meta name="theme-color" content="#f47c48">
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?= get_bloginfo('template_url'); ?>/x/style.css<?= $version; ?>">
<?php wp_head(); ?>
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

<?php $view = isset($_GET['view']) ? $_GET['view'] : false; ?>

<?php
// RUN DB QUERIES
include('queries.php'); ?>

<div class="container">
	<div id="menu-button"></div>
</div>
<nav id="menu">
	<h2>Menú</h2>
	<span id="menu-close"></span>
	<a href="?view=assign"<?= ($view == 'assign' || $view == false) ? 'class="active"' : null; ?>>Asignar Territorios</a>
	<a href="?view=groups"<?= $view == 'groups' ? 'class="active"' : null; ?>>Groupos</a>
	<a href="?view=publishers"<?= $view == 'publishers' ? 'class="active"' : null; ?>>Publicadores</a>
	<a href="?view=territories"<?= $view == 'territories' ? 'class="active"' : null; ?>>Territorios</a>
	<?php /* <a href="?view=report"<?= $view == 'report' ? 'class="active"' : null; ?>>Imprimir Reporte</a> */ ?>
</nav>

<section id="main-container">

	<span class="welcome">Bienvenido <?= $current_user->user_firstname; ?></span>
	<h1>Territorios - Raytown Spanish</h1>

	<?php
		if( $view ):
			switch ($view) {
				case 'assign':
					include('assign.php');
					break;
				
				case 'groups':
					include('groups.php');
					break;
				
				case 'publishers':
					include('publishers.php');
					break;
				
				case 'territories':
					include('territories.php');
					break;
				
				case 'report':
					include('report.php');
					break;
				
				default:
					include('assign.php');
					break;
			}
		else:
			include('assign.php');
		endif;
	?>

</section>

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
<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="blur-svg">
    <defs>
        <filter id="blur-filter">
            <feGaussianBlur stdDeviation="3"></feGaussianBlur>
        </filter>
    </defs>
</svg>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="<?= get_bloginfo('template_url'); ?>/x/script.js<?= $version; ?>"></script>
</body>
</html>

<?php

function dd($data) {
	highlight_string("<?php\n\$data =\n" . var_export($data, true) . ";\n?>");
	die();
}