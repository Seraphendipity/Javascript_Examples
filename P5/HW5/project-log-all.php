<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../Styles/normalize.css"></link>
    <link rel="stylesheet" type="text/css" href="../Styles/project-log.css"></link>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="../Scripts/common.js"></script>
</head>
<body>
    <div class="main">
   <?php
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

    ?>

</div>
</body>
<!-- style='background-image: url(../Images/{$file[1]});' -->