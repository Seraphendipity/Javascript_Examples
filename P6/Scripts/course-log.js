$(onPageLoad).ready( function() {
    $('.uploadCSV').on("change", function() {
        //I'm not dealing with a csv parsing tool rn, so Papa Parse will
        //credit: https://github.com/typeiii/jquery-csv
        //credit: https://www.js-tutorials.com/javascript-tutorial/reading-csv-file-using-javascript-html5/
        e.preventDefault();
        $(this).parse({
            config: {
            delimiter: "auto",
            complete: displayCSV,
            },
            before: function(file, inputElem)
            {
            //console.log("Parsing file...", file);
            },
            error: function(err, file)
            {
            //console.log("ERROR:", err, file);
            },
            complete: function()
            {
            //console.log("Done with all files");
            }
        });
    });
});

function displayCSV(results) {
	var table = "<table class='table'>";
	var data = results.data;
	 
	for(i=0;i<data.length;i++){
		table+= "<tr>";
		var row = data[i];
		var cells = row.join(",").split(",");
	 
		for(j=0;j<cells.length;j++){
		table+= "<td>";
		table+= cells[j];
		table+= "</th>";
		}
		table+= "</tr>";
	}
	table+= "</table>";
	$(".uploadCSV").after(table);
}