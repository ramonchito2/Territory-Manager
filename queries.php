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
	    		$insert_sql .= "UPDATE territories SET checkedOut = '".$currentTime."', userID_users = '".$pub."' WHERE terrNum = '".$terr."';";
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
$pub_sql = "SELECT * FROM users WHERE `group` = '".$group."'";
$pub_result = mysqli_query($conn, $pub_sql);
$publishers = array();
if (mysqli_num_rows($pub_result) > 0):
    while($row = mysqli_fetch_assoc($pub_result)):
        $publishers[] = array("id" => $row["userID"], "first" => $row["firstName"], "last" => $row["lastName"]);
    endwhile;
endif;
$publishers = array_sort($publishers, 'last');

// get checked-in territories
$ter_sql = "SELECT * FROM territories WHERE `group` = '".$group."' AND `checkedOut` IS NULL;";
$ter_result = mysqli_query($conn, $ter_sql);
$territories = array();
if (mysqli_num_rows($ter_result) > 0):
    while($row = mysqli_fetch_assoc($ter_result)):
        $territories[] = $row['terrNum'];
    endwhile;
endif;

// get checked-out territories
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

// FUNCTION TO GET TIME ELAPSED SINCE $datetime
function time_elapsed_string($datetime, $wrap = false, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }
    if (!$full) $string = array_slice($string, 0, 1);
    $result = $string ? implode(', ', $string) . ' ago' : 'just now';
    if ($wrap)
    	$result = '<span class="ago '.implode(', ', $string).'">'.$result.'</span>';
    return $result;
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