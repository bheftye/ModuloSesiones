$(function() {
  $("table").tablesorter({
	  debug: true,
	  headers: {
		  0: {
			   sorter: false
		  },
		  
		  5: { 
		  	   sorter: "shortDate" 
		  }
	  },
	   dateFormat : "mmddyyyy",
	  });
});
