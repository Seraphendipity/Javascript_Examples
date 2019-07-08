function calculateResult() {
    var x = Number($("#xBtn").val());
    var y = Number($("#yBtn").val());
    var op = $("#opDrop").val();
    var result;
    switch(op) {
        case "add":
            result = x + y;
            break;
        case "subtract":
            result = y - x;
            break;
        case "multiply":
            result = y * x;
            break;
        case "divide":
            result = y / x;
            break;
        case "power":
            result = Math.pow(y,x);
            break;
        case "modulus":
            result = y % x;
            break;
        case "gteq":
            result = Number(y >= x);
            break;
        case "lteq":
            result = Number(y <= x);
            break;
        default:
            alert("Somethings gone wrong, horribly wrong...");
    }
    $("#yBtn").val(result);
    // $("#yBtn").text(result);
}