<!--
	var ff_workaround;
	function selecttext(element) {
		var obj = document.getElementById(element);
		ff_workaround = obj;
		//obj.focus(); obj.select();
		
		// stupid firefox workaround
		setTimeout("ff_workaround.focus()",10);
		setTimeout("ff_workaround.select()",100);
	}
	
	function checkForEmpty(element) {
		var obj = document.getElementById(element);
		if (obj.value == "") {
			popup("Du f&aring;r inte spara ett tomt f&auml;lt.", true);
			return false;
		}
		else {
			return true;
		}
	}
	
	function popup(str, show) {
		var p = document.getElementById("popup");
		if (show == true) {
			p.innerHTML = "<p>" + str + "</p>";
			p.style.display = "block";
			setTimeout("popup('', false)", 3000);
		}
		else {
			p.style.display = "none";
		}
	}
	
	function showreader(show) {
		var world = document.getElementById("world");
		var reader = document.getElementById("reader");
		var readerContent = document.getElementById("readerContent");
		var text = document.getElementById("pastedText").innerHTML;
		
		text = text.replace(/</g,"&lt;");
		text = text.replace(/>/g,"&gt;");
		text = text.replace(/\n/g,"<br />");
		text = text.replace(/\t/g,"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
		/*text = text.replace(/&nbsp;&nbsp;&nbsp;&nbsp;/g,"\t");
		text = text.replace(/&nbsp;/g," ");
		text = text.replace(/\t/g,"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");*/
		
		if (show == true) {
			readerContent.innerHTML = "<p id=\"toplink\"><a href=\"javascript:showreader(false);\">St&auml;ng f&ouml;nster [X]</a></p>\n<hr />\n";
			readerContent.innerHTML += "<p>\n" + text + "\n</p>";
			world.style.display = "none";
			reader.style.display = "block";
		}
		else {
			reader.style.display = "none";
			world.style.display = "block";
		}
	}
//-->