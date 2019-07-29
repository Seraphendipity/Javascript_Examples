<?php 

function db_connect($database) {
    $db_servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = $database;
    $conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
    if ($conn->connect_error) {
        throw new DatabaseConnectionException($conn->error);
        //die("Connection failed: " . $conn->connect_error);
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
                uid INT AUTO_INCREMENT, 
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

function db_insertData($database, $table, $namesArr, $arrVals) {
    $qmarks = ''; $types = ''; $values = []; $bFirst = true; $i = 0;
    $names = implode(',', $namesArr);
    foreach($arrVals as $j => $value) {
        if (!$bFirst) {
            $qmarks .= ', ';
        } else {$bFirst = false;}
        $qmarks .= '?';
        $types .= 's';
            //if( gettype($value[0]) == 'integer' ) {$types .= 'i';} else {}

        if ( gettype($value) == 'array' ) {
            $values[$i] = implode('', $value);
        } else { 
            $values[$i] = $value;
        } $i++;
    }
        
    log::debugDump( $names );
    log::debugDump( $arrVals );
    log::debugDump( $values );
    log::debugDump( $qmarks );
    log::debugDump( $types );
        $conn = db_connect($database);
        
        $sql = $conn->prepare("INSERT INTO {$table} ({$names}) VALUES ({$qmarks})");
        if($sql === false) {throw new DatabaseInsertException($conn->error);} else{
            $sql->bind_param("{$types}", ...$values); //Arguement Unpacking
        }
    try {
        if( $sql->execute() === false) {
            throw new DatabaseInsertException($conn->error);
        } 
    } finally {
        db_disconnect($conn);
    }
    // var_dump( $result );
    // echo $conn->error;
    return;
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

function fileUploadToArray($name) {
    // Takes the $_FILES super global and converts the given filename to an array.
    // https://stackoverflow.com/questions/5593473/how-to-upload-and-parse-a-csv-file-in-php
    // https://www.php.net/manual/en/function.fgetcsv.php
    // https://www.php.net/manual/en/features.file-upload.php 
    try {
        if( (isset($_FILES[$name]['name'])) && ($_FILES[$name]['type'] == '.csv') ) {
            //No Error, Proceed
            if ( ($file = fopen($_FILES[$name]['name'], 'r')) !== false ) {
                return (fgetcsv($file));
            } else {
                throw new FileOpenException($_FILES[$name]['name']);
            }
        } else {
            throw new FileUploadException('.csv', $_FILES[$name]['type'], true, 'error');
        }
    }  catch (Exception $e) {
        // Msg stated, back out.
        return false;
    }
}


?>