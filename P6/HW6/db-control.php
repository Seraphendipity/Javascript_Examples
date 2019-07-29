<!DOCTYPE HTML></div></body>
<head>
    <link rel="stylesheet" type="text/css" href="../Styles/normalize.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous"> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="../Scripts/common.js"></script>
</head>
<body> <div class="main">
<div class="centeredBox">
        <h1>Database Management Form</h1>
        <p>FOR DEBUGGING PURPOSES ONLY. It should go without saying that the ability
            to drop and create databases willy-nilly should/will not be on an actual site,
            however as this is a test program, this allows ease of use of various functions
            and debugging. The typical setup is "test" and "courses" for this project,
            however you can name it whatever you want.</p>
        <p>Due to the fact that this is for only debugging and programmers, it is not
            entirely validated and secure -- if you try hard enough you can likely break it,
            if you so choose.</p>
        <p> As of now, the only data type is varchar(100). Primary key is already added, and all
            columns are part of a unique ID -- there cannot be an exact duplicate row. No data
            can be NULL. A better web app could work around this better, but I'm not coding
            PHPMyAdmin here.</p>
        <ul>
            <li>CREATE - if table does not exist, create it with the specified columns.</li>
            <li>DROP - drops the table completly, erasing all data and columns.</li>
            <li>CLEAR - deletes the data from the table, leaving columns/structure/ID.</li>
            <li>RESET - DROP then CREATE.</li>
            <li>STANDARD - RESETS with standard course names list, as used by this web app.</li>
        </ul>
    <form action="" method="POST" class="searchBar">
        <fieldset> 
            <legend>Database | Table Names</legend>
            <input type="text"   name="database" value="test" placeholder="test" required>
            <input type="text"   name="table"    value="courses" placeholder="courses" required>
        </fieldset> 

        <fieldset class="colHeaders"> 
            <legend>Column Names</legend>

            <button type="button" name="addColBtn" class="addColBtn">+</button>
        </fieldset> 

        <fieldset> 
            <legend>Submit SQL Request</legend>
        
            <select name="action" required>
                <option value="create">Create</option>
                <option value="drop">Drop</option>
                <option value="clear">Clear Data</option>
                <option value="reset">Reset</option>
                <option value="standard">Standard</option>
            </select>
            <input type="submit" value="Process SQL Request">
        </fieldset> 
    </form>

    <?php 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require_once 'db_connect.php';
        $dbName = $_POST['database'];
        $tableName = $_POST['table'];
        $colNames = isset($_POST['colNames']) ? $_POST['colNames'] : [];
        $action = $_POST['action'];

        switch($action) {
            case 'create':
                if (db_createTable($dbName, $tableName, $colNames)) {
                    $success = "Database created successfully.";
                } else {
                    $fail = "Database not created.";
                }
                break;
            case 'drop':
                db_dropTable($dbName, $tableName);
                break;
            case 'clear':
                db_clearTable($dbName, $tableName);
                break;
            case 'reset':
                db_dropTable($dbName, $tableName);
                db_createTable($dbName, $tableName, $colNames);
                break;
            case 'standard':
                require_once 'course-functions.php';
                restartCourses();
                break;
            default: 
                echo "ERROR - Sorting: Unknown parameter to sort by.";
        }
        
    }
    ?>

</div> </div>
    <script>
        $('.addColBtn').on('click', function() {
            colInput = `
            <label class="colNames">
                <input type="text"   name="colNames[]">
                <button type="button" name="remColBtn" class="remColBtn">-</button> 
            </label>
            `;
            //$('.colHeaders').append(colInput);
            $(this).before(colInput);
        });

        $('.colHeaders').on('click', '.remColBtn', function() {
            $(this).parent().remove();
        }); //NOTE: In this context, `this` refers to the btn that was clicked
        //        This is called event delegation, useful here due to dynamic gen
    </script>
</body>