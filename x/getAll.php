<?php
/* GET ALL TERRITORIES
--- creates $territoriesAll array() */
$ter_sql = 
	"
		SELECT l.user_id, l.terr_id, l.checked_out, l.checked_in, u.firstName, u.lastName, u.userID
		FROM log l
		INNER JOIN users u on l.user_id = u.userID
		ORDER BY l.terr_id ASC
	";
$countTerrs = mysqli_query($conn, "SELECT * FROM territories");
$numOfTerrs = mysqli_num_rows($countTerrs);
$ter_result = mysqli_query($conn, $ter_sql);
$territoriesAll = array();
if (mysqli_num_rows($ter_result) > 0):
    while($row = mysqli_fetch_assoc($ter_result)):
        $territoriesAll[] = $row;
    endwhile;
endif;
