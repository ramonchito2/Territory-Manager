<?php
/* GET PUBLISHERS
--- creates $publishers array(); */
$pub_sql = "SELECT * FROM users WHERE `group` = '".$group."'";
$pub_result = mysqli_query($conn, $pub_sql);
$publishers = array();
if (mysqli_num_rows($pub_result) > 0):
    while($row = mysqli_fetch_assoc($pub_result)):
        $publishers[] = array("id" => $row["userID"], "first" => $row["firstName"], "last" => $row["lastName"]);
    endwhile;
endif;
$publishers = array_sort($publishers, 'last');

/* GET CHECKED-IN TERRITORIES
--- creates $territories array() */
$ter_sql = "SELECT * FROM territories WHERE `group` = '".$group."' AND `checkedOut` IS NULL;";
$ter_result = mysqli_query($conn, $ter_sql);
$territories = array();
if (mysqli_num_rows($ter_result) > 0):
    while($row = mysqli_fetch_assoc($ter_result)):
        $territories[] = $row['terrNum'];
    endwhile;
endif;

/* GET CHECKED OUT TERRITORIES
--- creates $territoriesCOd array() */
$ter_sql  = "SELECT t.checkedOut, t.terrNum, u.firstName, u.lastName, u.userID ";
$ter_sql .= "FROM territories t ";
$ter_sql .= "INNER JOIN users u on t.userID_users = u.userID ";
$ter_sql .= "WHERE u.group = '".$group."' ";
$ter_sql .= "ORDER BY t.checkedOut ASC;";
$ter_result = mysqli_query($conn, $ter_sql);
$territoriesCOd = array();
if (mysqli_num_rows($ter_result) > 0):
    while($row = mysqli_fetch_assoc($ter_result)):
        $territoriesCOd[] = $row;
    endwhile;
endif;
