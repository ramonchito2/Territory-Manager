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

// CHECK FOR POST VARS
$checkingOut = isset($_POST['terrs']) && isset($_POST['publisher']);
$checkingIn = isset($_POST['tid']) && isset($_POST['uid']) && isset($_POST['time']);

if( $checkingIn or $checkingOut ):
	include('insert.php');
	// close msqli inside
else:
	include('get.php');
	mysqli_close($conn);
endif;


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