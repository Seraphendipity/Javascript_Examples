function changeTheme() {
    $("p").toggleClass("altP");
    $("li").toggleClass("altP");
    $("h1").toggleClass("altH");
    $("h2").toggleClass("altH");
    $("body").toggleClass("altBody");
}

// window.onload = onPageLoad();
$(onPageLoad).ready( function() {

}); // I love you.
// This one little line of code. He's just here to make us happy.
// This is my son. Do not disrespect him.
function onPageLoad() {
    genNavBar();
}

$(window).on("load", function() {
    genFooter();
});

function genNavBar() {
    var contents = `
    <nav class="navMain">
    <div class="primaryLink">
        <a href="./start"><div>Home</div></a>
    </div>
    <div class="primaryLink">
        <a href="../HW1/hw1"><div>HW_01</div></a>
        <div class="secondaryLink">
            <a href="../HW1/start"><div>Start</div></a>
            <a href="../HW1/index"><div>Index</div></a>
            <a href="../HW1/examples"><div>Examples</div></a>
            <a href="../HW1/notes"><div>Notes</div></a>
        </div>
    </div>
    <div class="primaryLink">
        <a href="./HW_02"><div>HW_02</div></a>
        <div class="secondaryLink">
            <a href="../HW1/start"><div>Start</div></a>
            <a href="../HW1/index"><div>Index</div></a>
            <a href="../HW2/indexAlt"><div>Index Alt</div></a>
            <a href="../HW1/notes"><div>Notes</div></a>
        </div>
    </div>
    <div class="primaryLink">
        <a href="../HW3/hw3"><div>HW_03</div></a>
        <div class="secondaryLink">
            <a href="../HW3/rubric"><div>Rubric</div></a>
        </div>
    </div>
    <div class="primaryLink">
        <a href="../HW4/hw4"><div>HW_04</div></a>
        <div class="secondaryLink">
            <a href="../HW4/calculator"><div>Calculator</div></a>
            <a href="../HW4/elevator"><div>Elevator</div></a>
            <a href="../HW4/features"><div>Features</div></a>
        </div>
    </div>
    <div class="primaryLink">
        <a href="../HW5/hw5"><div>HW_05</div></a>
        <div class="secondaryLink">
            <a href="../HW5/project-logger"><div>Project Logger</div></a>
            <a href="../HW5/project-log-all.php"><div>Project Log</div></a>
        </div>
    </div>
    <div class="primaryLink">
        <a href="../HW6/hw6"><div>HW_06</div></a>
        <div class="secondaryLink">
            <a href="../HW6/course-entry-form.php"><div>Course Entry Form</div></a>
            <a href="../HW6/course-display.php"><div>Course Display</div></a>
        </div>
    </div>
    <button onclick="changeTheme()">Theme</button>
    </nav>
    <div class="breakHeader"></div>
    `;
    $("body").prepend(contents);
}

function genFooter() {
    var contents = `
        <div class="breakFooter"></div>
    `;
    $("body").append(contents);
}


