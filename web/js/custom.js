
    	

	function myFunction() {
	    myVar = setTimeout(showPage, 3000);
	}

	function showPage() {
		document.getElementById("loader").style.display = "none";
		// document.getElementById("myDiv").style.display = "block";
	}

	function readCookie(name) {
	    var nameEQ = name + "=";
	    var ca = document.cookie.split(';');
	    for(var i=0;i < ca.length;i++) {
	        var c = ca[i];
	        while (c.charAt(0)==' ') c = c.substring(1,c.length);
	        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	    }
	    return null;
	}


	function setCookiess()
	{
		document.cookie = "lastElvar=9";
	}


	function scrollFunction() {
	    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
	        document.getElementById("btn-go-to-top").style.display = "block";
	    } else {
	        document.getElementById("btn-go-to-top").style.display = "none";
	    }
	}
	

		
