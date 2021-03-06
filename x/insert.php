<?php
// CHECKOUT TERR TO USER
if ( $checkingOut ):
	$insert_sql = '';
	$currentTime = time();
	$terrs = $_POST['terrs'];
	$pub = $_POST['publisher'];
	$validData = true;
	// ...but check if it's valid first
	if (!filter_var($pub, FILTER_VALIDATE_INT) === false):
	    foreach( $terrs as $terr ):
	    	if ( !filter_var($terr, FILTER_VALIDATE_INT) === false && $validData ):
	    		$insert_sql .= "UPDATE territories SET checkedOut = '".$currentTime."', userID_users = '".$pub."', byID = '".$current_user->ID."' WHERE terrNum = '".$terr."';";
	    		$validData = true;
	    	else:
	    		$validData = false;
	    	endif;
	    endforeach;
	endif;
	// INSERT VALID DATA
	if( $validData ):
		if ( mysqli_multi_query($conn, $insert_sql) ) {
			$terrNumbs = implode(', ',$terrs);
			if ( count($terrs) > 1 ):
				$msg = "?msg=Territorios " . $terrNumbs . " fueron asignados con éxito.";
			else:
				$msg = "?msg=Territorio " . $terrNumbs . " fue asignado con éxito.";
			endif;
		} else {
		    $msg = "?err=Error: " . $insert_sql . mysqli_error($conn);
		}
	else:
		$msg = "?err=Error: Los datos enviados no son válidos. Si el problema persiste, póngase en contacto con el administrador";
	endif;
endif;

// CHECK-IN TERRITORY(IES)
if( $checkingIn ):
	
	$currentTime = time();
	$insert_sql = ''; $log = '';
	$re = '/^\d+(?:,\d+)*$/'; // validate only nums & commas
	$tid = $_POST['tid'];
	$uid = $_POST['uid'];
	$time = $_POST['time'];
	$continue = true;
	if ( !preg_match($re, $tid) || !preg_match($re, $uid) || !preg_match($re, $time) )
		$continue = false;
	if( $continue ):
		$user  = filter_var($uid, FILTER_VALIDATE_INT);
		$terrs = explode(',', $tid);
		$time = explode(',', $time);
		foreach( $terrs as $n => $terr ):
			$t = filter_var($terr, FILTER_VALIDATE_INT);
			$x = filter_var($time[$n], FILTER_VALIDATE_INT);
			$insert_sql .= "UPDATE territories ";
			$insert_sql .= "SET checkedOut = NULL, userID_users = NULL, byID = NULL ";
			$insert_sql .= "WHERE terrNum = ".$t." ";
			$insert_sql .= "AND userID_users = ".$user.";";
			$insert_sql .= "INSERT INTO log VALUES (NULL,".$user.",".$t.",".$x.",".time().");";
		endforeach;
		// INSERT VALID DATA
		if ( mysqli_multi_query($conn, $insert_sql) ) {
			if ( count($terrs) > 1 ):
				$msg = get_bloginfo('url')."?msg=Territorios " . $tid . " fueron asignados con éxito.";
			else:
				$msg = get_bloginfo('url')."?msg=Territorio " . $tid . " fue asignado con éxito.";
			endif;
		} else {
		    $msg = get_bloginfo('url')."?err=Error: " . $insert_sql . mysqli_error($conn);
		}
	endif;

endif;

mysqli_close($conn);
header('Location:'.$msg);
?>
