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
            <p>BlazerID: {$BlID}</p>
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
</body>
<!-- style='background-image: url(../Images/{$file[1]});' -->