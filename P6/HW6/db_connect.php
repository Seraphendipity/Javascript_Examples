<?php 

function db_connect($database) {
    $db_servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = $database;
    $conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }  return  $conn;
}

function db_createTable($database, $table, $colNames) {
    $listSQL = ''; $listCols = ''; $bFirst = true;
    foreach($colNames as $col) {
        $listSQL .= "{$col} VARCHAR(100) NOT NULL  , ";
        if($bFirst) {
            $listCols .= "{$col}";
            $bFirst = false;
        } else {
            $listCols .= ",{$col}";
        }
    }
    $conn = db_connect($database);
    $sql = "CREATE TABLE IF NOT EXISTS {$table} ( 
                uid INT NOT NULL , 
                {$listSQL}
                PRIMARY KEY (uid) ,
                CONSTRAINT uniqueCols UNIQUE NONCLUSTERED (
                    {$listCols}
                )
            ) 
            ENGINE = InnoDB;";
    //var_dump($sql);
    //var_dump( $conn->query($sql) );
    $conn->query($sql);
    return(true);
}

function db_clearTable() {
    $conn = db_connect($database);
    $sql = "DELETE FROM {$table}";
    $conn->query($sql);
}

function db_dropTable($database, $table) {
    $conn = db_connect($database);
    $sql = "DROP TABLE {$table}";
    $conn->query($sql);
}

function db_insertData($database, $table, $arrVals) {

    $conn = db_connect($database);

    $names = ''; $qmarks = ''; $types = ''; $values = []; $bFirst = true; $i = 0;

    foreach($arrVals as $name => $value) {
        if (!$bFirst) {
            $names .= ', ';
            $qmarks .= ', ';
        } else {$bFirst = false;}
        $names .= $name;    
        $qmarks .= '?';
        $types .= 's';
            //if( gettype($value[0]) == 'integer' ) {$types .= 'i';} else {}

        if ( gettype($value[0]) == 'array' ) {
            $values[$i] = implode('', $value[0]);
        } else { 
            $values[$i] = $value[0];
        } $i++;
    }
        // DEBUG:
        // var_dump($names);
        // var_dump(...$values);
        // var_dump($qmarks);
        // var_dump($types);

    $sql = $conn->prepare("INSERT INTO {$table} ({$names}) VALUES ({$qmarks})");
    $sql->bind_param("{$types}", ...$values); //Arguement Unpacking
    $sql->execute();
    // var_dump( $result );

    echo $conn->error;

    db_disconnect($conn);
    return(1);
}

function db_selectData($database, $table) {
    $conn = db_connect($database);
    $sql = "SELECT * FROM {$table};";
    $result = $conn->query($sql);
    while($row = $result->fetch_array()) {
        $data[] = $row;
    }
    return $data;
}

function db_disconnect($conn) {
    $conn->close();
}





function restartCourses () {
    //DEBUG:
    $courseNames = [
        'semester',
        'course',
        'title',
        'days',
        'timeStart',
        'timeEnd',
        'instructor',
        'location',
        'enrolledAct',
        'enrolledMax'
    ];
    db_dropTable('test', 'courses');
    db_createTable('test', 'courses', $courseNames);
}
?>