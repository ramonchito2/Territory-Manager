<?php 
global $user_login;

if( !is_user_logged_in() ) : 

	if( IS_PRODUCTION_SERVER )
		$version = '?v=1.0';
	else
		$version = null;
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
		<?php //<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> ?>
		<link rel="stylesheet" href="<?= get_bloginfo('template_url'); ?>/x/login.css<?= $version; ?>">
	</head>
	<body>

		<section class="loginForm">

			<img src="<?= get_bloginfo('template_url');?>/assets/images/logo.png" style="width:100%;">
			<?php // <i class="fa fa-map" aria-hidden="true"></i> ?>
		    <?php 
		    // In case of a login error.
		    if ( isset( $_GET['login'] ) && $_GET['login'] == 'failed' ) : ?>
		        <div class="loginError">
		            <p><?php _e( '<span class="fail">Failed login attempt</span>', 'Tapp' ); ?></p>
		        </div>
		    <?php 
		    endif;
		            
		    // Login form arguments.
		    $args = array(
		        'echo'           => true,
		        'redirect'       => home_url(), 
		        'form_id'        => 'loginform',
		        'label_username' => __( 'Username' ),
		        'label_password' => __( 'Password' ),
		        'label_remember' => __( 'Remember Me' ),
		        'label_log_in'   => __( 'Log In' ),
		        'id_username'    => 'user_login',
		        'id_password'    => 'user_pass',
		        'id_remember'    => 'rememberme',
		        'id_submit'      => 'wp-submit',
		        'remember'       => true,
		        'value_username' => NULL,
		        'value_remember' => true
		    ); 
		    
		    // Calling the login form.
		    wp_login_form( $args ); ?> 
		</section>
	</body>
	</html>

<?php die();
endif;