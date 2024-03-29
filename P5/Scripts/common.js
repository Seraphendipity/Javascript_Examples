function changeTheme() {
    $("p").toggleClass("altP");
    $("li").toggleClass("altP");
    $("h1").toggleClass("altH");
    $("h2").toggleClass("altH");
    $("body").toggleClass("altBody");
}

// window.onload = onPageLoad();
$(onPageLoad).ready( function() {
    if( typeof progressBar.values == 'undefined' ) {
        progressBar.values= [];
        for(i=0; i < 5; i++) {
            progressBar.values[i] = parseInt($($(".formPercentContainer").
            children(".formPercent").get(i)).val());
        }
    }
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
        var i = 0; 
        var name;
        var vals = progressBar.values;
        var elem = $(".formPercent");
        var currIndex = $(".formPercentContainer .formPercent").index(this);
        var min = parseInt($(this).attr("min"));
        var max = parseInt($(this).attr("max"));

        //STEP_01: Get diff of old and new val.
        var oldVal = vals[currIndex];       // alert(oldVal); //     DEBUG
        var newVal = parseInt($(this).val());         // alert(newVal); //     DEBUG

        //ERROR-CHECKING
        if (newVal > max) {newVal = 100; $(elem.get(i)).val(newVal);}
        if (newVal < min) {newVal = 0; $(elem.get(i)).val(newVal);}
        var diff = oldVal - newVal;         // alert(diff);   //     DEBUG  
            
        //STEP_02: Multiply diff and ratios to add back in.
        var sum = 100 - oldVal;
        vals.forEach(function(val, i) {
            if(i != currIndex) {
            $(elem.get(i)).val(function(index, value) {
                vals[i] += (sum !== 0 ? diff*(vals[i]/sum) : diff/(vals.length-1));
                return(Math.round(vals[i]));
            }); } 
        });
        // console.log(vals); //DEBUG
        vals[currIndex] = parseInt(newVal);
        progressBar.values = vals;

        //STEP_03: Apply the new vals to the divs.
        for (i = 0; i < 5; i++) {
            name = $($(".formPercentContainer").children(".form").get(i)).attr("name");
            $(".progressBar ."+name).height($(".formPercentContainer input[name="+name+"]").val()+'%');
        }
    });
}
