<!DOCTYPE HTML></div></body>
<head>
    <link rel="stylesheet" type="text/css" href="../Styles/normalize.css">
    <link rel="stylesheet" type="text/css" href="../Styles/project-log.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous"> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="../Scripts/common.js"></script>
    <script src="../Scripts/course-log.js"></script>
</head>
<body> <div class="main">

    <!-- <form action="Post" class="searchBar"> -->
        <select class="selSearch" name="sortBy">
            <option value="default">Default (semester>enrollment(act))</option>    
            <option value="inverse">Inverse (enrollment(act)>semester)</option>    
            <option value="summary">Summary (semester)</option>    
        </select>
        <button type="button" alt="Search" class="btnSearch" value="Search"><i class="fas fa-search"></i></button>
    <!-- </form> -->
    <?php 
        require_once('db_connect.php');
        $data = db_selectData('test', 'courses');
        var_dump($data);
        // $sortBy = (isset($_POST['sortBy'])) ? $_POST['sortBy'] : 'default';
        // switch($sortBy) {
        //     case 'default':
        //         break;
        //     case 'inverse':
        //         array_multisort($data['semester'], $data);
        //         break;
        //     case 'summary':
        //         array_multisort($data['semester'], $data);
        //         break;
        //     default: 
        //         echo "ERROR - Sorting: Unknown parameter to sort by.";
        // } 

        // array_multisort($data[$], $data);
        $colNames = array_keys($data[0]);
        echo '<table class="tableSortable"><tr>';
        foreach($colNames as $colName) {
            echo '<th>'.$colName.'</th>';
        }
        echo '</tr>';
        foreach($data as $row) {
            echo '<tr>';
            foreach($row as $value) {
               echo '<td>'.$value.'</td>';
            }
            echo '</tr>';
        }
        ?>

</div> </body>