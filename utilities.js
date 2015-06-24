 
 $(function() {
    $( "#tabs" ).tabs();
  });
 function catVal() {
    var x = document.forms["catForm"]["cat_id"].value;
	var y = document.forms["catForm"]["cat_name"].value;
    if (x == null || x == "") {
        alert("Category id must be filled out");
        return false;
    }
	
	  if (y == null || y == "") {
        alert("Category name must be filled out");
        return false;
    }
	
	return true;
}