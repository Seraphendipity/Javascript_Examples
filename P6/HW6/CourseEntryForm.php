<!DOCTYPE HTML></div></body>
<head>
    <link rel="stylesheet" type="text/css" href="../Styles/normalize.css">
    <link rel="stylesheet" type="text/css" href="../Styles/project-log.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous"> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="../Scripts/common.js"></script>
    <script src="../Scripts/project-log.js"></script>
</head>
<body> <div class="main">
<!-----------------------------------------------------------------------------
____ ____ ____ _  _     _ _  _ ___  _  _ ___ 
|___ |  | |__/ |\/|     | |\ | |__] |  |  |  
|    |__| |  \ |  | ___ | | \| |    |__|  |  
------------------------------------------------------------------------------>
    <div class="centeredBox">
        <h1>Course Creation Form</h1>
        <p>Create a course for the <a href='./course-listing'>course listing</a> 
            page. All input fields are required unless specified otherwise.</p>
        <!--https://www.smashingmagazine.com/2009/07/web-form-validation-best-practices-and-tutorials/-->
        <form action="" method="post" id="project-log" onsubmit="return postValidation()">
            <!--
            <h3>Name (First-Middle-Last)</h3>
            <input type="text" name="fName" class="form formText" ></input>
            <input type="text" name="mName" class="form formText" ></input>
            <input type="text" name="lName" class="form formText" ></input>
            -->
            <label> Semester: <br>
            <select name="semester[]" required>
                <option value="sp">Spring</option>
                <option value="su">Summer</option>
                <option value="fa">Fall</option>
            </select></label>

            <label>Course (Subject + Number):  <br>
                <input type="text" name="course" placeholder="EE447" required>
            </label>

            <label>Title:  <br>
                <input type="text" name="title" placeholder="EE447" alt="Insert the standard name of the course." required>
            </label>

            <label> Days (use CTRL to select multiple):  <br>
            <select name="days[]" multiple required>
                <option value="m">Monday</option>
                <option value="t">Tuesday</option>
                <option value="w">Wednesday</option>
                <option value="r">Thursday</option>
                <option value="f">Friday</option>
                <option value="s">Saturday</option>
                <option value="u">Sunday</option>
            </select></label>

            <label>Time (start -> end, HH:mm XM):  <br>
                <input type="time" name="timeStart" class="form teamNum" placeholder="08:00 AM" required>
                to
                <input type="time" name="timeEnd" class="form teamNum" placeholder="10:00 PM" required>
            </label>

            <label>Instructor:  <br>
                <input type="text" name="instructor" placeholder="Elijah R. Green" required>
            </label>       

            <label>Location:  <br>
                <input type="text" name="location" placeholder="BEC 347" required>
            </label>

            <label>Enrolled (actual of maximum, typically actual starts at 0):  <br>
                <input type="number" name="enrolledAct" placeholder="0" required min="0">
                of
                <input type="number" name="enrolledMax" placeholder="30" required min="0">
            </label>

            <label>
                <input type="submit" class="formSubmit">
            </label>
        </form>
    </div>
    
    



<!-----------------------------------------------------------------------------
____ ____ ____ _  _     _  _ ____ _  _ ___  _    _ _  _ ____ 
|___ |  | |__/ |\/|     |__| |__| |\ | |  \ |    | |\ | | __ 
|    |__| |  \ |  | ___ |  | |  | | \| |__/ |___ | | \| |__] 
------------------------------------------------------------------------------>
<?php 
var_dump($_POST);

//INPUT_VALIDATION - https://www.w3schools.com/php/showphp.asp?filename=demo_form_validation_complete
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $arrVals = [
        'semester'      =>  [$semester = '',     'select',         [['sp', 'su', 'fa'], false]                   ],
        'course'        =>  [$course = '',       'alphanum',       []                                        ],
        'title'         =>  [$title = '',        'alphanum',       []                                        ],
        'days'          =>  [$days = '',         'select',         [['m', 't', 'w', 'r', 'f', 's', 'u'], true]  ],
        'timeStart'     =>  [$timeStart = '',    'time',           ['00:00', '23:59']                        ],
        'timeEnd'       =>  [$timeEnd = '',      'time',           ['00:00', '23:59']                        ],
        'enrolledAct'   =>  [$enrolledAct = '',  'num',            [0, 99999]                                ],
        'enrolledMax'   =>  [$enrolledMax = '',  'num',            [0, 99999]                                ],
        'instructor'    =>  [$instructor = '',   'alphanum',       []                                        ],
        'location'      =>  [$location = '',     'alphanum',       []                                        ]  
    ];

    //Validation Functions
    function validate_get($s, &$value) {
        if (empty($_POST[$s])) {
            return "ERROR - \"{$s}\": a value is required.";
        } else {
            $value = clean_input($_POST[$s]);
            return 1;
        }
    }

    function clean_input_base($d) {
        $d = trim($d);
        $d = stripslashes($d);
        $d = htmlspecialchars($d);
        return $d;
    }

    function clean_input($data) {
        if (gettype($data) == 'array') {
            foreach ($data as $val) {
                $val = clean_input_base($val);
            }
            return ($data);
        } else {
            return clean_input_base($data);
        }
    }

    function validate_time($time, $timeMin = '00:00 AM', $timeMax = '23:59 PM', $dtFormat = 'H:i') {
        $dt = DateTime::createFromFormat($dtFormat, $time);
        $dtMin = DateTime::createFromFormat($dtFormat, $timeMin);
        $dtMax = DateTime::createFromFormat($dtFormat, $timeMax);
        $errorMsg = '';
        if ($dt === false) {
            $errorMsg .= "<br>ERROR - Invalid Datetime: Time \"{$time}\" is not of 'HH:mm XM' format. ";
        } elseif ($dtMin === false) {
            $errorMsg .= "<br>ERROR - Invalid Datetime: Time Minimum \"{$timeMin}\" is not of 'HH:mm XM' format. ";
        } elseif ($dtMax === false) {
            $errorMsg .= "<br>ERROR - Invalid Datetime: Time Maximum \"{$timeMax}\" is not of 'HH:mm XM' format. ";
        } else if ($dt < $dtMin) {
            $errorMsg .= "<br>ERROR - Invalid Datetime: \"{$time}\" cannot be less than the minimum \"{$timeMin}\". ";
        } else if ($dt > $dtMax) {
            $errorMsg .= "<br>ERROR - Invalid Datetime: \"{$time}\" cannot be more than the maximum \"{$timeMax}\". ";
        } else {return 1;}
        return $errorMsg;
    }

    function validate_num($num, $min = '0', $max = '999999') {
        $errorMsg = '';
        if (!is_numeric($num)) {
            $errorMsg .= "<br>ERROR - Invalid Number: \"{$num}\" is not numeric. ";
        } else if (!is_numeric($min)) {
            $errorMsg .= "<br>ERROR - Invalid Number: \"{$min}\" is not numeric. ";
        } else if (!is_numeric($max)) {
            $errorMsg .= "<br>ERROR - Invalid Number: \"{$max}\" is not numeric. ";
        } else if ($num < $min) {
            $errorMsg .= "<br>ERROR - Invalid Number: \"{$num}\" cannot be less than the minimum \"{$min}\". ";
        } else if ($num > $max) {
            $errorMsg .= "<br>ERROR - Invalid Number: \"{$num}\" cannot be more than the maximum \"{$max}\". ";
        } else {return 1;}
        return $errorMsg;
    }

    function validate_select($value, $options, $bMultiselect = false) {
        $value = array_unique($value);
        if ( (!$bMultiselect) && (count($value) !== 1) ) {
            return "ERROR - Selection: Multiple values in selection \"{$value}\", only one allowed.";
        }
        foreach ($value as $val) {
            $bValid = false;
            foreach ($options as $option) {
                if ( $val == $option ) {
                    $bValid = true;
                }
            }

            if ($bValid == false) {
                $errorMsg .= "ERROR - Selection: Invalid option \"{$semester}\", requires one of the following -";
                foreach($options as $option) {
                    $errorMsg .= " \"{$option}\" |";
                }
                return $errorMsg;
            } 
        }
        if($bValid) {return 1;}
        
    }

    function validate_alphanum($value) {
        if( preg_match("/^[a-zA-Z0-9 ]*$/",$value) ) {
            return 1;
        } else {
            return "ERROR - Alphanum: \"{$value}\" does not solely consist of numbers, letters, and whitespace.";
        }
    }

    //CONSIDER using call_user_func_array
    function validate_apply($value, $method, $arrInputs = NULL) {
        switch ($method) {
            case 'alphanum':
                $result = validate_alphanum($value);
                break;
            case 'select':
                $result = validate_select($value, $arrInputs[0], $arrInputs[1]);
                break;
            case 'num':
                $result = validate_num($value, $arrInputs[0], $arrInputs[1]);
                break;
            case 'time':
                $result = validate_time($value, $arrInputs[0], $arrInputs[1]);
                break;
            default:
                $result = "ERROR: Unknown function method to apply.";
        }
        return $result;
    }

    //Basic Validation
    $valid;
    foreach ($arrVals as $name => $value) {
        $valid = validate_get($name, $value[0]);
        if( $valid === 1 ) {
            $valid = validate_apply($value[0], $value[1], $value[2]);
            if( $valid === 1 ) {
                continue;
            } else {
                break;
            }
        } else {
            break;
        }
    }

    //SQL Input
    if( !($valid === 1) ) {
        echo $valid;
    } else {
        
    }
}

require 'db_connect.php';

$conn = db_connect();




echo '<br>';

$names = ''; $qmarks = ''; $types = ''; $values = ''; $bFirst = true; $i = 0;
$sql = $conn->prepare("INSERT INTO test_table ({$names}) VALUES ({$qmarks})");

foreach($arrVals as $name => $value) {
    if (!$bFirst) {
        $names = ', ';
        $qmarks = ', ';
        $values = ', ';
    } else {$bFirst = false;}
    $names .= $name    
    $qmarks .= '?';

    if( gettype($value[0]) == 'integer' ) {
        $types .= 'i';
    } else {$types .= 's';}

    if ( gettype($value[0]) == 'array' ) {
        $values[$i] .= implode('', $value[0]);
    } else { 
        $values[$i] .= $value[0];
    } $i++;
}
$sql->bind_param("{$types}", ...$values);

// var_dump( $result );

echo '<br>';

echo $conn->error;

db_disconnect($conn);
?>

</div> </body>