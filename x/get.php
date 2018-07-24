<?php
/* GET CURRENT USER'S GROUP  */
$group = null;
$current_user = wp_get_current_user();
$email = $current_user->user_email;
$group_sql = "SELECT * FROM users WHERE email = '".$email."';";
$group_result = mysqli_query($conn, $group_sql);
if (mysqli_num_rows($group_result) > 0):
    while($row = mysqli_fetch_assoc($group_result)):
        $group = $row["group"];
    endwhile;
endif;

/* GET ALL GROUPS  */
$allGroups = [];
$allGroups_sql = "SELECT DISTINCT `group` FROM `users` ORDER BY `group` ASC;";
$allGroups_result = mysqli_query($conn, $allGroups_sql);
if (mysqli_num_rows($allGroups_result) > 0):
    while($row = mysqli_fetch_assoc($allGroups_result)):
        $allGroups[] = $row["group"];
    endwhile;
endif;

/* CHECK USER ROLE 
-- change WHERE clause if editor or admin */
if( !current_user_can('edit_others_pages') ):
	$where = "WHERE `group` = '".$group."'";
	$where2 = "WHERE u.group = '".$group."'";
else:
	$where = "WHERE `group` IS NOT NULL";
	$where2 = "WHERE u.group IS NOT NULL";
endif;

/* GET PUBLISHERS
--- creates $publishers array(); */
$pub_sql = "SELECT * FROM users ".$where;
$pub_result = mysqli_query($conn, $pub_sql);
$publishers = array();
if (mysqli_num_rows($pub_result) > 0):
    while($row = mysqli_fetch_assoc($pub_result)):
        $publishers[] = array(
        	"id" => $row["userID"],
        	"first" => $row["firstName"],
        	"last" => $row["lastName"],
        	"group" => $row["group"]
        );
    endwhile;
endif;
$publishers = array_sort($publishers, 'last');

/* GET CHECKED-IN TERRITORIES
--- creates $territories array() */
$ter_sql = "SELECT * FROM territories ".$where." AND `checkedOut` IS NULL;";
$ter_result = mysqli_query($conn, $ter_sql);
$territories = array();
if (mysqli_num_rows($ter_result) > 0):
    while($row = mysqli_fetch_assoc($ter_result)):
        $territories[] = array(
        	"id" => $row['terrNum'],
        	"group" => $row['group']
        );
    endwhile;
endif;

/* GET CHECKED OUT TERRITORIES
--- creates $territoriesCOd array() */
$ter_sql = 
	"
		SELECT t.checkedOut, t.terrNum, t.byID, u.firstName, u.lastName, u.userID, u.group
		FROM territories t
		INNER JOIN users u on t.userID_users = u.userID
		".$where2."
		ORDER BY t.checkedOut ASC
	";
$ter_result = mysqli_query($conn, $ter_sql);
$territoriesCOd = array();
if (mysqli_num_rows($ter_result) > 0):
    while($row = mysqli_fetch_assoc($ter_result)):
        $territoriesCOd[] = $row;
    endwhile;
endif;
