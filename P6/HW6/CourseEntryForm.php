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
            <select name="semester" required>
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
            <select name="days" multiple required>
                <option value="m">Monday</option>
                <option value="t">Tuesday</option>
                <option value="w">Wednesday</option>
                <option value="r">Thursday</option>
                <option value="f">Friday</option>
                <option value="s">Saturday</option>
                <option value="u">Sunday</option>
            </select></label>

            <label>Time (start -> end, hh:mm:ss, 24-hour notation):  <br>
                <input type="time" name="timeStart" class="form teamNum" placeholder="08:00" required>
                to
                <input type="time" name="timeStart" class="form teamNum" placeholder="10:00" required>
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

//INPUT_VALIDATION - https://www.w3schools.com/php/showphp.asp?filename=demo_form_validation_complete
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $arrVals = [
        'semester'      =>  $semester,
        'course'        =>  $course,
        'title'         =>  $title,
        'days'          =>  $days,
        'time'          =>  $time,
        'enrolledAct'   =>  $enrolledAct,
        'enrolledMax'   =>  $enrolledMax,
        'instructor'    =>  $instructor,
        'location'      =>  $location
    ]
    
    //Basic Validation and Set
    foreach ($arrVals as $name => $value) {
        $value = validate($name);
    }
    extract($arrValues);

    //Semester - Only 1 of 3 options
    $options = ['sp', 'su', 'fa'];
    validate_select($semester, $options, false, 'semester');

    validate_alphanum($course);

    validate_alphanum($title);

    $options = ['m', 't', 'w', 'r', 'f', 's', 'u'];
    validate_select($days, $options, true, 'days');

    validate_time($timeStart);
    
    validate_time($timeEnd,,$timeStart);

    validate_num($enrolledAct, 0, $enrolledMax,true);
    
    validate_num($enrolledMax, 0,,true);

    validate($instructor);
    
    validate($location);

    function validate_time($time, $timeMin = '00:00', $timeMax = '24:00', $dtFormat = 'HH:mm') {
        $dt = new DateTime->date_create_from_format($dtFormat, $time);
        $dtMin = new DateTime->date_create_from_format($dtFormat, $timeMin);
        $dtMax = new DateTime->date_create_from_format($dtFormat, $timeMax);

        if ($dt == false) {
            $errorMsg .= "<br>Invalid Datetime: Time {$time} is not of 'HH:mm' format. ";
        } elseif ($dtMin == false) {
            $errorMsg .= "<br>Invalid Datetime: Time Minimum {$timeMin} is not of 'HH:mm' format. ";
        } elseif ($dtMax == false) {
            $errorMsg .= "<br>Invalid Datetime: Time Maximum {$timeMax} is not of 'HH:mm' format. ";
        } else if ($dt < $dtMin) {
            $errorMsg .= "<br>Invalid Datetime: {$time} cannot be less than the minimum {$timeMin}. "
        } else if ($dt > $dtMax) {
            $errorMsg .= "<br>Invalid Datetime: {$time} cannot be more than the maximum {$timeMax}. "
        } else {return 1;}
        return $errorMsg;
    }

    function validate_num($num, $min = '0', $max = '999999') {
        if (!is_numeric($num)) {
            $errorMsg .= "<br>Invalid Number: {$num} is not numeric. ";
        } else if (is_numeric($min)) {
            $errorMsg .= "<br>Invalid Number: {$min} is not numeric. "
        } else if (is_numeric($max)) {
            $errorMsg .= "<br>Invalid Number: {$max} is not numeric. "
        } else if ($num < $min) {
            $errorMsg .= "<br>Invalid Number: {$num} cannot be less than the minimum {$min}. "
        } else if ($num > $max) {
            $errorMsg .= "<br>Invalid Number: {$num} cannot be more than the maximum {$max}. "
        } else {return 1;}
        return $errorMsg;
    }

    function validate_select($value, $options, $bMultiselect = false, $name = '') {
        $bValid = false;
        foreach ($options as $option) {
            if ( $semester == $option ) {
                $bValid = true;
            }
        }
        if ($bValid == false) {
            $errorMsg .= "<br>{{$name} Selection Error}: Invalid option {$semester}, requires one of the following -";
            foreach($options as $option) {
                $errorMsg .= " {$option} |";
            }
            return $errorMsg;
        } else {return 1;}
    }

    function validate_alphanum($value) {
        if( preg_match("/^[a-zA-Z0-9 ]*$/",$value) ) {
            return 1;
        } else {
            return "Alphanum Error: {$value} does not solely consist of numbers, letters, and whitespace."
        }
    }








    if( !isset($bValid) || !isset($errorMsg) ) {
        static $bValid = true;
        static $errorMsg = '';
    }
    if (empty($_POST[$s])) {
        $errorMsg += "{$s}: a value is required. ";
        $bValid = false;
    } else {
        $value = test_input($_POST[$s]);
        // check if value only contains letters and whitespace
        if (validate($value)) {
            $errorMsg = "{$s}: Only letters, numbers, and white space allowed, given {$value}. "; 
            $bValid = false;
        }
    }  
    if ($bValid) {return $value};
  
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function validate($s) {
        return preg_match("/^[a-zA-Z0-9 ]*$/",$s);
    }

    function safeGet($s) {
        if( !isset($bValid) || !isset($errorMsg) ) {
            static $bValid = true;
            static $errorMsg = '';
        }
        if (empty($_POST[$s])) {
            $errorMsg += "{$s}: a value is required. ";
            $bValid = false;
        } else {
            $value = test_input($_POST[$s]);
            // check if value only contains letters and whitespace
            if (validate($value)) {
                $errorMsg = "{$s}: Only letters, numbers, and white space allowed, given {$value}. "; 
                $bValid = false;
            }
        }  
        if ($bValid) {return $value};
    }




    if (!isset($_GET["BlazerID"])) {
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
require 'db_connect.php';

$conn = db_connect();

$sqlcmd = "SELECT * FROM test_table";
$result = $conn->query($sqlcmd);
var_dump( $result );

echo '<br>';

$sql = $conn->prepare("INSERT INTO test_table (students) VALUES (?)");
$sql->bind_param('s', $name);
//$stmt->bind_param("sss", $firstname, $lastname, $email); with ? marks in statement

$name = 'Dath Vader"; DROP students; --?';
$sql->execute();

// $sqlcmd = "INSERT INTO test_table (students) VALUES ('Pikachu');";
// $result = $conn->query($sqlcmd);
// var_dump( $result );

echo '<br>';

echo $conn->error;

db_disconnect($conn);*/
?>

</div> </body>