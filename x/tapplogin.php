<?php 
global $user_login;

if( !is_user_logged_in() ) : ?>

	<!DOCTYPE html>
	<html lang="en-us">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?= get_bloginfo('template_url'); ?>/x/login.css">
	</head>
	<body>

		<section class="loginForm">

			<i class="fa fa-map" aria-hidden="true"></i>
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