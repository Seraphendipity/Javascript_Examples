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


<div class="main">
    <form action="" class="searchBar">
        <select name="sortBy">
            <option value="default">Default (semester>enrollment(act))</option>    
            <option value="inverse">Inverse (enrollment(act)>semester)</option>    
            <option value="summary">Summary (semester)</option>    
        </select>
        <input type="submit" value="Search">
    </form>
    <?php 
        $data = db_getData('test', 'courses');
        switch($_POST["sortBy"]) {
            case 'default':
                sort
                break;
        }

            echo <<<FORMRECEIPT
                <div class="centeredBox">
                    <h3>Project Meta Information</h3>
                    <p>BlazerID: {$BlID}</p>
                    <p>Team Number: {$teamNum}</p>
                    <p>Total Time: {$time}</p>
                    <p>Submission TimeStamp (H:M:S D-M-Y): {$timeStamp} {$dateStamp}</p>
                    <hr/>
                    <h3>Project Resource Composition</h3>
                    <p>Analysis and Design: {$AnD}%</p>
                    <p>Coding: {$code}%</p>
                    <p>Meeting: {$meet}%</p>
                    <p>Testing: {$test}%</p>
                    <p>Other: {$other}%</p>
                </div>
FORMRECEIPT;
            }
            $i++;
        }
        fclose($fo);



//_________________________________________________________
   } else if ( ($_GET["BlazerID"] !== NULL) && ($_GET["BlazerID"] !== '\0') ) {
        $sumTime = 0; $numProjects = 0;
        $AnDAvg = $codeAvg = $meetAvg = $testAvg = $otherAvg = 0;
        $fo = fopen("../Database/project-log.csv", "r"); 
        $nl = "\n"; $i = 0;
        while ( (!feof($fo))) {
            $line = fgets($fo, 200);
            if(trim($line) == '') {
                if ($i == 0) {
                    echo "<p>No data to work with, sire.</p>";
                } else {
                    //nothing, skip
                }
            } else {
                $data[$i] = str_getcsv($line, ",");

                //FORM HANDLING
                $BlID       = $data[$i][0];
                $teamNum    = $data[$i][1];
                $time       = $data[$i][2];
                $AnD        = $data[$i][5];
                $code       = $data[$i][6];
                $test       = $data[$i][7];
                $meet       = $data[$i][8];
                $other      = $data[$i][9];
                $timeStamp  = $data[$i][3];
                $dateStamp  = $data[$i][4];
                if ($BlID == $_GET["BlazerID"]) {
                echo <<<FORMRECEIPT
                <div class="centeredBox">
                    <h3>Project Meta Information</h3>
                    <p>BlazerID: {$BlID}</p>
                    <p>Team Number: {$teamNum}</p>
                    <p>Total Time: {$time}</p>
                    <p>Submission TimeStamp (H:M:S D-M-Y): {$timeStamp} {$dateStamp}</p>
                    <hr/>
                    <h3>Project Resource Composition</h3>
                    <p>Analysis and Design: {$AnD}%</p>
                    <p>Coding: {$code}%</p>
                    <p>Meeting: {$meet}%</p>
                    <p>Testing: {$test}%</p>
                    <p>Other: {$other}%</p>
                </div>
FORMRECEIPT;
                    $sumTime += $time;
                    $numProjects++;
                    $AnDAvg +=   floatval($AnD);
                    $codeAvg +=  floatval($code);
                    $meetAvg +=  floatval($meet);
                    $testAvg +=  floatval($test);
                    $otherAvg += floatval($other);
                }
            }
            $i++;
        }
        fclose($fo);
        //Summary
        $AnDAvg     *= 1/$numProjects;
        $codeAvg    *= 1/$numProjects;
        $meetAvg    *= 1/$numProjects;
        $testAvg    *= 1/$numProjects;
        $otherAvg   *= 1/$numProjects;
        $AnDTime     =  ($AnDAvg/100) * $sumTime;
        $codeTime    =  ($codeAvg/100) * $sumTime;
        $meetTime    =  ($meetAvg/100) * $sumTime;
        $testTime    =  ($testAvg/100) * $sumTime;
        $otherTime   =  ($otherAvg/100) * $sumTime;
        echo <<<FORMSUMMARY
        <div class="centeredBox">
            <h3>User Summary</h3>
            <p>BlazerID: {$_GET["BlazerID"]}</p>
            <p>Number of Projects: {$numProjects}</p>
            <p>Total Time (all projects): {$sumTime}</p>
            <hr/>
            <p>Avg. Analysis and Design: {$AnDAvg}% for {$AnDTime} hours</p>
            <p>Avg. Coding: {$codeAvg}% for {$codeTime} hours</p>
            <p>Meeting: {$meetAvg}% for {$meetTime} hours</p>
            <p>Testing: {$testAvg}% for {$testTime} hours</p>
            <p>Other: {$otherAvg}% for {$otherTime} hours</p>
        </div>
FORMSUMMARY;
   } else {
        echo "<p> Unrecognizable BlazerID.</p>";
   }
    ?>

</div>




















<!-----------------------------------------------------------------------------
____ ____ ____ _  _     _ _  _ ___  _  _ ___ 
|___ |  | |__/ |\/|     | |\ | |__] |  |  |  
|    |__| |  \ |  | ___ | | \| |    |__|  |  
------------------------------------------------------------------------------>
    <div class="centeredBox">
        <h1>Course Creation Display</h1>
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
<div class="errorBox"><p>
<?php

//INPUT_VALIDATION - https://www.w3schools.com/php/showphp.asp?filename=demo_form_validation_complete
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //var_dump($_POST); // DEBUG:
    $arrVals = [
        'semester'      =>  [$semester = '',     'select',         [['sp', 'su', 'fa'], false]                   ],
        'course'        =>  [$course = '',       'alphanum',       []                                        ],
        'title'         =>  [$title = '',        'alphanum',       []                                        ],
        'days'          =>  [$days = '',         'select',         [['m', 't', 'w', 'r', 'f', 's', 'u'], true]  ],
        'timeStart'     =>  [$timeStart = '',    'time',           ['00:00', '23:59']                        ],
        'timeEnd'       =>  [$timeEnd = '',      'time',           ['00:00', '23:59']                        ],
        'instructor'    =>  [$instructor = '',   'alphanum',       []                                        ],
        'location'      =>  [$location = '',     'alphanum',       []                                        ] , 
        'enrolledAct'   =>  [$enrolledAct = '',  'num',            [0, 99999]                                ],
        'enrolledMax'   =>  [$enrolledMax = '',  'num',            [0, 99999]                                ]
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
            foreach ($data as &$val) {
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
    foreach ($arrVals as $name => &$value) {
        $valid = validate_get($name, $value[0]);
        // echo "<br><b>Returned Value: {$value[0]}</b><br>"; // DEBUG:

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
        require 'db_connect.php';
        //restartCourses();

        $sqlResult = db_insertData('test','courses', $arrVals);
        if (!($sqlResult == 1)) {
            echo "Error in Processing SQL Request - ".$sqlResult.'|'.$conn->connect_error;
        }
    }
}
?>
</p></div>

</div> </body>