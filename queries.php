<?php
// GET RESULTS FOR...
$group = "Calle 89";

// GROUP OVERSEERS
switch ($group) {
	case 'Calle 89':
		$go = 'Jirrod';
		break;
	
	case 'Salon':
		$go = 'Jose';
		break;
	
	case 'Grandview':
		$go = 'Raul';
		break;
	
	case 'Crisp':
		$go = 'Josue';
		break;
	
	case 'Stark':
		$go = 'Enrique';
		break;
	
	case 'Harris':
		$go = 'Armando';
		break;
	
	default:
		$go = 'Admin';
		break;
}

// OPEN DB CONNECTION
$conn = mysqli_connect('localhost', 'root', 'root', 'terrapp');
if (!$conn):
    die("Connection failed: " . mysqli_connect_error());
endif;

// INSERT SUBMITTED DATA INTO DB
if ( isset($_POST['terrs']) && isset($_POST['publisher']) ):
	$insert_sql = '';
	$currentTime = time();
	$terrs = $_POST['terrs'];
	$pub = $_POST['publisher'];
	$validData = true;
	// ...but check if it's valid first
	if (!filter_var($pub, FILTER_VALIDATE_INT) === false):
	    foreach( $terrs as $terr ):
	    	if ( !filter_var($terr, FILTER_VALIDATE_INT) === false && $validData ):
	    		$insert_sql .= "UPDATE territory SET checked_out = '".$currentTime."', user_iduser = '".$pub."' WHERE terr_num = '".$terr."';";
	    		$validData = true;
	    	else:
	    		$validData = false;
	    	endif;
	    endforeach;
	endif;
	// INSERT VALID DATA
	if ( $validData && mysqli_multi_query($conn, $insert_sql) ) {
	    echo "Territorie(s) " . implode(', ',$terrs) . " were sucessfully assigned.";
	} else {
	    echo "Error: " . $insert_sql . "<br>" . mysqli_error($conn);
	}
endif;

// get publishers
$pub_sql = "SELECT * FROM user WHERE `group` = '".$group."'";
$pub_result = mysqli_query($conn, $pub_sql);
$publishers = array();
if (mysqli_num_rows($pub_result) > 0):
    while($row = mysqli_fetch_assoc($pub_result)):
        $publishers[] = array("id" => $row["iduser"], "first" => $row["first_name"], "last" => $row["last_name"]);
    endwhile;
else:
    echo "0 results";
endif;
$publishers = array_sort($publishers, 'last');

// get checked-in territories
$ter_sql = "SELECT * FROM territory WHERE `group_name` = '".$group."' AND `checked_out` IS NULL;";
$ter_result = mysqli_query($conn, $ter_sql);
$territories = array();
if (mysqli_num_rows($ter_result) > 0):
    while($row = mysqli_fetch_assoc($ter_result)):
        $territories[] = $row['terr_num'];
    endwhile;
else:
    echo "0 results";
endif;

// get checked-out territories
$ter_sql = "SELECT * FROM territory WHERE `group_name` = '".$group."' AND NOT `checked_out` IS NULL;";
$ter_result = mysqli_query($conn, $ter_sql);
$territoriesCOd = array();
if (mysqli_num_rows($ter_result) > 0):
    while($row = mysqli_fetch_assoc($ter_result)):
        $territoriesCOd[] = $row['terr_num'];
    endwhile;
else:
    echo "0 results";
endif;


mysqli_close($conn);

// FUNCTION TO SORT ARRAY BY PREFERENCE
function array_sort($array, $on, $order=SORT_ASC){

    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
                break;
            case SORT_DESC:
                arsort($sortable_array);
                break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}

// SET TERRITORIES TO RESPECTIVE GROUP OWNERS
/* $conn = mysqli_connect('localhost', 'root', 'root', 'terrapp');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql  = "UPDATE territory SET group_name = 'Stark' WHERE idterritory BETWEEN 1 AND 10;";
$sql .= "UPDATE territory SET group_name = 'Grandview' WHERE idterritory BETWEEN 11 AND 20;";
$sql .= "UPDATE territory SET group_name = 'Harris' WHERE idterritory BETWEEN 21 AND 30;";
$sql .= "UPDATE territory SET group_name = 'Crisp' WHERE idterritory BETWEEN 31 AND 40;";
$sql .= "UPDATE territory SET group_name = 'Salon' WHERE idterritory BETWEEN 41 AND 49;";
$sql .= "UPDATE territory SET group_name = 'Calle 89' WHERE idterritory BETWEEN 50 AND 58;";

if (mysqli_multi_query($conn, $sql)) {
    echo "New records created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn); */