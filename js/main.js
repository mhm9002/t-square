var script = document.createElement('script');
script.src = 'js/jquery-3.1.1.min.js';
script.type = 'text/javascript';
document.getElementsByTagName('head')[0].appendChild(script);

jQuery.noConflict()(function ($) { 

	$( document ).ready(function() {
		
		$( document ).on("click",".FuncBtn", function() {		
		
		if ($(this).attr('id').indexOf("--")) {
	
			key_st = $(this).attr('id').indexOf("--") + 2;
			key_length = $(this).attr('id').length - key_st +1;
			key = $(this).attr('id').substr(key_st, key_length);
			func = $(this).attr('id').substr(0, key_st - 2 );
			
			switch (func) {
			
			case "search":
				CallPHPFun("searchInSite");
				break;
			
			case "newproject":
				if ($("#ProjectName").val()==null) {
				proj_con = "<li class='drpmenu col-xs-10'>Project Name:<br><input class='input-text' type='text' id='ProjectName' name='ProjectName' placeholder='Enter Project name'></li><br>"+
		
					"<li class='drpmenu col-xs-10'>Project Area (m2) [roughly]:<br><input class='input-text' type='text' id='ProjectArea' name='ProjectArea' placeholder='Enter the rough area of the project'></li><br>"+
		
					"<li class='drpmenu col-xs-10'>Location:<br><input class='input-text' type='text' id='ProjectLocation' name='ProjectLocation' placeholder='Enter project Details'></input></li><br>"+
		
					"<li class='drpmenu col-xs-10'>Lot No.:<br><input class='input-text' type='text' id='ProjectLot' name='ProjectLot' placeholder='Enter project lot details (number and area)'></input></li><br>"+
		
					"<li class='drpmenu col-xs-10'>Status:<br>"+
					"<select id='ProjectStatus' name='ProjectStatus'>"+
  						"<option value='Not started'>Not Started</option>"+
  						"<option value='In progress'>In progress</option>"+
  						"<option value='Postponed'>Postponed</option>"+
  						"<option value='Terminated'>Terminated</option>"+
  						"<option value='Completed'>Completed</option>"+
					"</select></li><br>"+
					"<li class='divider col-xs-12'></li>";
				
				$(proj_con).insertAfter('#newproject-divider');
				} else {
					var proj_info = [$("#ProjectName").val(),$("#ProjectArea").val(),$("#ProjectLocation").val(),$("#ProjectLot").val(),$("#ProjectStatus").val()];
					CallPHPFun("CreateProject", proj_info);	
				}
				break;
			case "logout":
				CallPHPFun("logout");
				break;			
			case "AssignProjTeam":
				var arg=[];
				userEmail = window.prompt("Enter member email:");
				arg.push (key);
				arg.push (userEmail);
				CallPHPFun('AssignProjectTeam',arg);
				break;
			}
		}

		});

	});


});

function cancelEditpost( key , postContent){
	
	document.getElementById("postcontentBox-" + key).innerHTML = document.getElementById("original-" + key).innerHTML;
	
}

function cancelNewcomment($postID) {
	document.getElementById("comment-bar-"+$postID).innerHTML="";

}

function CallPHPFun (func, arg=[]) {
	
	if (func) {
	
		var par = "";
		var arg_no = 0;
		
	if (arg.length>0) {
		
		arg.forEach( function(e) {
			arg_no = arg_no + 1;
			par = par + "&arg" +arg_no+"="+e;
		});
	}
	
	var xmlhttp = new XMLHttpRequest();
    
	functionURL =  'functions-handler.php'
	param = 'func=' + func + "&arg_no=" + arg_no + par;

	
	xmlhttp.open("POST", functionURL , true);
    
	xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xmlhttp.send(param);
	
	return true;
	
	/*
	$.ajax({ 
		 url: document.dir + 'inc/functions-handler.php',
		 data: par,
		 type: 'POST',
		  :'application/x-www-form-urlencoded; charset=UTF-8',
         success: function() {
                    alert('done');
                },
		 error: function() {
					alert ('error');
				}
	});*/
	} else {
		return false;
	}
}


function CallPHPFileFun (func, form) {
            
    var fData = new FormData(form);
	//fData.append ('func', func);
	//alert ("hello");	
			
	//for (i=0; i<arg.length; i++) {
	//	fData.append('file'+i , arg[i]);
	//}
    
    //fData.append("file_no",x);
	
	//for (i=0; i<files.length; i++) {
				
		
	//}

	var xmlhttp = new XMLHttpRequest();            
	
    /* xmlhttp.addEventListener('progress', function(e) {
    	var done = e.position || e.loaded, total = e.totalSize || e.total;
        console.log('xmlhttp progress: ' + (Math.floor(done/total*1000)/10) + '%');
    }, false);
    
    if ( xmlhttp.upload ) {
    	xmlhttp.upload.onprogress = function(e) {
        var done = e.position || e.loaded, total = e.totalSize || e.total;
        console.log('xmlhttp.upload progress: ' + done + ' / ' + total + ' = ' + (Math.floor(done/total*1000)/10) + '%');
    	};
    }
            
    xmlhttp.onreadystatechange = function(e) {
    	if ( 4 == this.readyState ) {
        	console.log(['xmlhttp upload complete', e]);
    	}
    };
	*/
	
	xmlhttp.open("POST", "functions-filehandler.php" , true);
    alert(fData);
	xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded'); //'multipart/form-data');
	var param = "func="+func;
    xmlhttp.send("func="+func);

}