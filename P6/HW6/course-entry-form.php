<!DOCTYPE HTML></div></body>
<head>
    <link rel="stylesheet" type="text/css" href="../Styles/normalize.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous"> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="../Scripts/jquery-csv.js"></script>
    <script src="../Scripts/common.js"></script>
    <script src="../Scripts/course-log.js"></script>
</head>
<body> <div class="main">
<!-----------------------------------------------------------------------------
____ ____ ____ _  _     _ _  _ ___  _  _ ___ 
|___ |  | |__/ |\/|     | |\ | |__] |  |  |  
|    |__| |  \ |  | ___ | | \| |    |__|  |  
------------------------------------------------------------------------------>
    <div class="centeredBox">
        <h1>Course Entry Form</h1>
        <p>Create a course for the <a href='./course-display'>course listing</a> 
            page. All input fields are required unless specified otherwise.</p>
        <!--https://www.smashingmagazine.com/2009/07/web-form-validation-best-practices-and-tutorials/-->
        <form action="" method="post" enctype="multipart/form-data" id="project-log" onsubmit="return postValidation()">
            <!--
            <h3>Name (First-Middle-Last)</h3>
            <input type="text" name="fName" class="form formText" ></input>
            <input type="text" name="mName" class="form formText" ></input>
            <input type="text" name="lName" class="form formText" ></input>
            -->
            <!-- Course ID Info -->
            <fieldset>
                <legend>Upload Course CSV File</legend> 
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

                <!-- Course Schedule Info (semester actually probably goes here) -->
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

                <!-- Course Logistics/Specifics/Members? -->
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
                    <input type="submit" name="submit" value="Add Course" class="formSubmit">
                </label>
            </fieldset>
            <hr>
            <fieldset>
                <legend>Upload Course CSV File</legend>
                <input type="file"  name="uploadFile" accept=".csv,.txt" value="Upload CSV" class="formSubmit uploadBtn">
                <input type="submit" name="submit" value="Add Course(s)" class="formSubmit" disabled>
            </fieldset>
        </form>
    </div>
    
    



<!-----------------------------------------------------------------------------
____ ____ ____ _  _     _  _ ____ _  _ ___  _    _ _  _ ____ 
|___ |  | |__/ |\/|     |__| |__| |\ | |  \ |    | |\ | | __ 
|    |__| |  \ |  | ___ |  | |  | | \| |__/ |___ | | \| |__] 
------------------------------------------------------------------------------>
<div class="errorBox"><p>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require('course-functions.php');

    $postType = $_POST['submit'];
    if ( $postType == 'Add Course' ) {
        createCourse($_POST);
    } else if ( $postType == 'Add Course(s)' ) {
        $data = fileUploadToArray('uploadFile');
        foreach($data as $row) {
            createCourse($row);
        }
    }
}
?>
</p></div>

</div> </body>