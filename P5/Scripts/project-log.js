$(onPageLoad).ready( function() {
    if( typeof progressBar.values == 'undefined' ) {
        progressBar.values= [];
        for(i=0; i < 5; i++) {
            progressBar.values[i] = parseInt($($(".formPercentContainer").
            children(".formPercent").get(i)).val());
        }
    }
    progressBar();
    preValidation();
    postValidation();
});


function progressBar() {
    $(".formPercent").change(function() {
        var i = 0; 
        var name;
        var vals = progressBar.values;
        var elem = $(".formPercent");
        var currIndex = $(".formPercentContainer .formPercent").index(this);
        var min = parseInt($(this).attr("min"));
        var max = parseInt($(this).attr("max"));

        //ERROR-CHECKING
        numValidation(this);

        //STEP_01: Get diff of old and new val.
        var oldVal = vals[currIndex];       // alert(oldVal); //     DEBUG
        var newVal = parseInt($(this).val());         // alert(newVal); //     DEBUG
        var diff = oldVal - newVal;         // alert(diff);   //     DEBUG  
            
        //STEP_02: Multiply diff and ratios to add back in.
        var sum = 100 - oldVal;
        vals.forEach(function(val, i) {
            if(i != currIndex) {
            $(elem.get(i)).val(function(index, value) {
                vals[i] += (Math.round(sum) !==  0 ? diff*(vals[i]/sum) : diff/(vals.length-1));
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

function preValidation() {
    // Validation as the user clicks outside the box
    $(".blID").change(function() {
        $(this).val($(this).val().replace(/\s/g, ''));
    });
    $(".teamNum").change(function() {
        numValidation(this);
    });
    $(".time").change(function() {
        numValidation(this);
    });

}

function numValidation (obj) {
    var min = parseInt($(obj).attr("min"));
    var max = parseInt($(obj).attr("max"));
    if($(obj).val() > max) {$(obj).val(max)};
    if($(obj).val() < min) {$(obj).val(min)};
}

function postValidation() {
    // Validation when they hit "Submit"
    $(".form").removeClass("validInput");
    $(".form").removeClass("invalidInput");
    var bValid = true;
    if ( /\s/.test( $(".blID").val() ) ) {
        alert("BlazerID's cannot have spaces.");
        bValid = false;
        $(".blID").addClass("invalidInput");
    } else {
        $(".blID").addClass("validInput");
    }

    $(".form[type='number'").toArray().forEach( function(elem, index) {
        if ( !numPostValidation(elem) ) {bValid = false;}
    });

    return bValid;
}

function numPostValidation(obj) {
    var val = parseInt($(obj).val());
    var min = parseInt($(obj).attr("min"));
    var max = parseInt($(obj).attr("max"));
    var name = $(obj).attr("name");
    var bValid = true; var msg;
    if (val > max) {
        msg = name + "cannot be greater than " + max;
        bValid = false;
    } else if (val < min) {
        msg = name + "cannot be less than " + min;
        bValid = false
    } 

    if (bValid) {
        $(obj).addClass("validInput");
        return true;
    } else {
        $(obj).addClass("invalidInput");
        alert("Validation Error: " + msg + ". Current Value: " + val);
        return false;
    }
}
