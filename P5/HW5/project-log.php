<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../Styles/normalize.css"></link>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="../Scripts/common.js"></script>
</head>
<body>
    
   <?php
    //FORM HANDLING
    $BlID = $_POST["BlazerID"];
    $teamNum = $_POST["TeamNumber"];
    $time = $_POST["TotalTime"];
    $AnD = $_POST["pAnalysisAndDesign"];
    $code = $_POST["pCoding"];
    $test = $_POST["pTesting"];
    $meet = $_POST["pMeeting"];
    $other = $_POST["pOther"];
    $timeStamp = date("H:m:sa");
    $dateStamp = date("d-m-Y");
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
    ?>


</body>
<!-- style='background-image: url(../Images/{$file[1]});' -->