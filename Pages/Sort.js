//Pass php array into a JS array
var jsArray = <?php echo json_encode($/*phpArray*/) ?>;

//Sorting in alphabetical order
function naturalCompare(a, b) {
    var array1 = [], array2 = [];

    a.replace(/(\d+)|(\D+)/g, function(_, $1, $2) { array1.push([$1 || Infinity, $2 || ""]) });
    b.replace(/(\d+)|(\D+)/g, function(_, $1, $2) { array2.push([$1 || Infinity, $2 || ""]) });
    
    while(array1.length && array2.length) {
        var newArray1 = array1.shift();
        var newArray2 = array2.shift();
        var thirdArray = (newArray1[0] - newArray2[0]) || newArray1[1].localeCompare(newArray2[1]);
        if(thirdArray) return thirdArray;
    }

    return array1.length - array2.length;
}

var sortedArray = jsArray.sort(naturalCompare);

