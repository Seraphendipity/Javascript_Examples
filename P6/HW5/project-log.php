<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../Styles/normalize.css"></link>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="../Scripts/common.js"></script>
</head>
<body>
   <?php
    $bValid = true;
    //FORM HANDLING
    if (isset($_POST["BlazerID"])) {$BlID = $_POST["BlazerID"];} else {$bValid = false;}
    if (isset($_POST["TeamNumber"])) {$teamNum = floatval($_POST["TeamNumber"]);} else {$bValid = false;}
    if (isset($_POST["TotalTime"])) {$time = floatval($_POST["TotalTime"]);} else {$bValid = false;}
    if (isset($_POST["pAnalysisAndDesign"])) {$AnD = floatval($_POST["pAnalysisAndDesign"]);} else {$bValid = false;}
    if (isset($_POST["pCoding"])) {$code = floatval($_POST["pCoding"]);} else {$bValid = false;}
    if (isset($_POST["pTesting"])) {$test = floatval($_POST["pTesting"]);} else {$bValid = false;}
    if (isset($_POST["pMeeting"])) {$meet = floatval($_POST["pMeeting"]);} else {$bValid = false;}
    if (isset($_POST["pOther"])) {$other = floatval($_POST["pOther"]);} else {$bValid = false;}
    if($bValid) {
    $timeStamp = date("H:m:sa");
    $dateStamp = date("d-m-Y");

    //VALIDATION
    $bValid = false;
    $msg = "Standard Error.";
    $sum = $AnD + $code + $test + $meet + $other;
    if (preg_match("/\s/", $BlID) !== 0) {
        $msg = "BlazerID has spaces in it.";
    } else if ($teamNum < 1 || $teamNum > 6) {
        $msg = "Team Number outside of range 1-6.";
    } else if ($time < 0 || $teamNum > 99999) {
        $msg = "Project total time outside of range 0-99999.";
    } else if ($AnD < 0 || $AnD > 100) {
        $msg = "% Analysis and Design outside of range 0-100.";
    } else if ($code < 0 || $code > 100) {
        $msg = "% Coding outside of range 0-100.";
    } else if ($test < 0 || $test > 100) {
        $msg = "% Testing outside of range 0-100.";
    } else if ($meet < 0 || $meet > 100) {
        $msg = "% Meeting outside of range 0-100.";
    } else if ($other < 0 || $other > 100) {
        $msg = "% Other outside of range 0-100.";
    } else if ($sum < 98 || $sum > 102) {
        $msg = "Sum of %'s is not near 100%.";
    } else{$bValid = true;}
    if($bValid) {
    $fo = fopen("../Database/project-log.csv", "a"); 
        $nl = "\n";
        $line = "{$BlID},{$teamNum},{$time},{$timeStamp},{$dateStamp},{$AnD},{$code},{$meet},{$test},{$other}
";//.$nl;
        fwrite($fo, $line);
    fclose($fo);
    echo <<<FORMRECEIPT
        <h3>Project Meta Information</h3>
        <p>BlazerID: {$BlID}</p>
        <p>Team Number: {$teamNum}</p>
        <p>Total Time: {$time}</p>
        <p>Submission TimeStamp (H:M:S D-M-Y): {$timeStamp} {$dateStamp}</p>
        
        <h3>Project Resource Composition</h3>
        <p>Analysis and Design: {$AnD}%</p>
        <p>Coding: {$code}%</p>
        <p>Meeting: {$meet}%</p>
        <p>Testing: {$test}%</p>
        <p>Other: {$other}%</p>
FORMRECEIPT;
    } else {
        echo '<p>"Data is Invalid: '.$msg.'"<p>';
        echo '<script>alert("Data is Invalid: '.$msg.'");</script>"';
        // header("Location:./project-logger.html");
    } } else {
        echo '<p>Data not Found (empty field)<p>';
        echo "<script>alert('Data not Found (empty field)');</script>";

        // header("Location:./project-logger.html");
    }
    ?>


</body>
<!-- style='background-image: url(../Images/{$file[1]});' -->