function changeTheme() {
    $("p").toggleClass("altP");
    $("li").toggleClass("altP");
    $("h1").toggleClass("altH");
    $("h2").toggleClass("altH");
    $("body").toggleClass("altBody");
}

// window.onload = onPageLoad();
$(onPageLoad).ready( function() {
    progressBar();
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
            <a href="../HW5/project-log"><div>Project Log</div></a>
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

function progressBar() {
    $(".formPercent").change(function() {
        var i = 0; var name; var sum = 0; var ratio;
        var others = $(".formPercent").not($(this));
        if( typeof progressBar.values == 'undefined' ) {
            for(i=0; i < 5; i++) {
                progressBar.values[i] = parseInt($($(others).get(i)).val());
            }
        }

        //STEP_01: Get diff of old and new val.
        others.forEach( function(other) {
            sum += parseInt($(other).val());
        });
        alert(sum);
        var oldVal = 100 - (sum);
        var newVal = $(this).val();
        var diff = newVal - oldVal;

        //STEP_02: Get ratios of Others.
        for(i=0; i < 4; i++) {
            $(others.get(i)).val(function(index, val) {
                val = parseInt(val);

                return(alert(Math.round(val + val/sum)));
            });   
        }

        //STEP_03: Multiply diff and ratios to add back in.


        for (i = 0; i < 5; i++) {
            name = $($(".formPercentContainer").children(".form").get(i)).attr("name");
            $(".progressBar ."+name).height($(".formPercentContainer input[name="+name+"]").val()+'%');
        }
    });
}
