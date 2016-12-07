var users = new Array();

function user() {
	this.name = "";
	this.password="";
	this.email="";
	this.posts= new Array();
}

user.prototype.setName = function (newName) {
	this.name= newName;

}

user.prototype.setPasswd = function (newPasswd) {
	this.password = newPasswd;

}

user.prototype.setEmail = function (newEmail) {
	this.email= newEmail;

}

user.prototype.getName = function () {
	return this.name;
}

user.prototype.getPasswd = function () {
	return this.password;
}

user.prototype.getEmail = function () {
	return this.email;
}

function addUser ($name, $passwd, $email ) {
		
	msg = "The entered email is already registered or the input format is invalid";
	
	if (!checkUserEmail($email))  {
		document.getElementById('formStatus').innerHTML = msg;	
		return false;
	}

	if (checkPwd($passwd)!="ok") {return false;}
	
	var newUser = new user;
	newUser.setName ($name);
	newUser.setPasswd ($passwd);
	newUser.setEmail ($email);
	
	users.push (newUser);
	resetInputfields();		

	document.getElementById('formStatus').innerHTML = "User Added";
	updateUserList();	

	return true;
}

function updateUserList(){

	var output = "<div class=\"row\"><a class=\"col-xs-3 text-center\"> User Name</a> <a class=\"col-xs-3 text-center\">User Email</a></div><br>";



	for (var i = 0, len = users.length; i < len; i++) 
	{
		output = output + "<div class=\"container-fluid fs-shaded\" id=\"cont-" + users[i].email + "\"><a class=\"col-xs-3\"><span style=\"color:red;\">" +
				users[i].name + "</span></a><a class=\"col-xs-3\">" + users[i].email  +
				"</a><a class=\"col-xs-6 text-center\"><input type=\"button\" class=\"btn button-margin\" value=\"Edit User\" id=\"edit-user-" +
				users[i].email + "\" onClick=\"editUser(\'" + users[i].email + "\')\">" + 
				"<input type=\"button\" class=\"btn button-margin\" value=\"Remove User\" id=\"remove-user-" + users[i].email +
				"\" onClick=\"removeUser(\'" + users[i].email + "\')\"></input>"+
				"<input type=\"button\" class=\"btn button-margin\" value=\"Add Post\" id=\"add-post-" +
				users[i].email + "\" onClick=\"addPostArea(\'" + users[i].email + "\')\"></input>"+
				"<input type=\"button\" class=\"btn button-margin\" value=\"View Posts\" id=\"view-posts-" + users[i].email +
				"\" onClick=\"viewPosts(\'" + users[i].email + "\')\"></input></a></div>" ;
	}
		
	document.getElementById('userList').innerHTML = output;

}

function listUsers () {
	var output = "";

	for (var i = 0, len = users.length; i < len; i++) 
	{
		output = output + "\n" + users[i].name;
	}
	alert (output);
}

function checkUserEmail ($email){

	var emailFormat = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+?\.[a-zA-Z]{2,3}$/;
	if (!emailFormat.test($email)) {
		return false;
	}
	
	i = get_user_index($email);
	
	if (i == -1) {
		return true;
	} else {
		return false;
	}
}

function editUser($email){

	i = get_user_index($email);

	if (i == -1 || document.getElementById("change-bar-"+$email)) {
		return false;
	} else {
		document.getElementById("cont-"+$email).innerHTML= document.getElementById("cont-"+$email).innerHTML +
		"<div class=\"row\" id=\"change-bar-"+$email+"\"><input type=\"text\" id=\"change-name-" +
		$email + "\" placeholder=\"Enter valid name\" value=\""+users[i].name+"\"></input><input type=\"text\" id=\"change-passwd-" + $email +
		"\" placeholder=\"Enter valid password\" value=\""+users[i].password+"\"></input><input type=\"text\" id=\"change-email-" + $email +
		"\" placeholder=\"Enter valid Email address\" value=\""+users[i].email+"\"></input><input type=\"button\"  class=\"btn button-margin\" id=\"change-user-" + $email +
		"\" value=\"Modify\" onClick=\"confirmUserEdit(\'" + $email + "\')\"></input><input type=\"button\" class=\"btn button-margin\" value=\"Cancel\" onClick=\"removeEditbar(\'"+$email+"\')\"</input></div>" ;
		
	}
}

function confirmUserEdit( $email) {
	
	newName = document.getElementById("change-name-" +$email).value;
	newPWD = document.getElementById("change-passwd-" +$email).value;
	newEmail = document.getElementById("change-email-" +$email).value;
	
	if (newEmail != $email) {
		if (!checkUserEmail(newEmail) )  {
			alert ("invalid email formar or existing email address");	
			return false;
		}
	}

	if (checkPwd(newPWD)!="ok") {
		alert ("Entered password doesn\'t meet the criteria")
		return false;
	}
	
	i = get_user_index($email);
	if (i== -1) {return false;}
	
	$conf = confirm("Are you sure to edit user: " + users[i].name)
	
	if ($conf) {
		users[i].setName (newName);
		users[i].setPasswd (newPWD);
		users[i].setEmail (newEmail);
		
		removeEditbar ($email);
		updateUserList();
		
		return true;
	}	else {return false;}
		
}

function removeEditbar($email) {
	
	document.getElementById("change-bar-"+$email).outerHTML="";
	
}


function removeUser($email) {
	
	i = get_user_index($email);
	
	if (i == -1) {
		return false;
	} else {
	
		$conf = confirm ("Are you sure to remove " + users[i].name + "?")
		if ($conf) {
			users.splice(i,1);
			updateUserList();
			return true;
		}
	}
}

function addPostArea ($email) {
	
	i = get_user_index($email);
	
	if (i==-1 || document.getElementById("add-post-bar-"+$email)) {return false;}
	
	document.getElementById("cont-"+$email).innerHTML= document.getElementById("cont-"+$email).innerHTML +
		"<div class=\"row\" id=\"add-post-bar-"+$email+"\">New post<input type=\"textarea\" placeholder=\"Enter post text here\" id=\"post-content-"+$email+
		"\"></input><input type=\"button\" class=\"btn button-margin\" value=\"Submit\" id=\"submitPost"+$email+"\" onClick=\"addPost(\'"+$email+
		"\')\"></input><input type=\"button\" class=\"btn button-margin\" value=\"Cancel\" id=\"cancelPost"+$email+"\" onClick=\"removePostbar(\'"+$email+
		"\')\"></input></div>";
}

function addPost ($email){
	
	var $post= document.getElementById("post-content-"+$email).value;
	
	i = get_user_index($email);
	
	if (i == -1 || $post == null) {
		return false;
	} else {
		users[i].posts.push($post);
		removePostbar($email);
		return true;
	}
}

function removePostbar($email){
	document.getElementById("add-post-bar-"+$email).outerHTML="";

}	
	
function viewPosts ($email){

	var output = "";
	
	i = get_user_index($email);
	
	if (i == -1) 
		{ 
		return false; 
		}
	
		output = "<HTML><BODY><h1 class=\"text-primary text-center\">" + users[i].name + " " +" Posts</h1>";

		post_no = users[i].posts.length
		if (post_no == 0) {
			output = "No posts";

			} else {			

			for (var j = 0; j < post_no; j++) 
			{		
			output = output + "<BR><div class=\"container-fluid\"><p>" + users[i].posts[j] +"</p></div>";
			}
		}

	
	output = output + "</BODY></HTML>";				

	newwindow = window.open();
	newdocument = newwindow.document;
	newdocument.write (output);

}

function insertPostWindow() {
	
	var postContent = "";
	var content = "<p> Insert your post content</p><br><textarea id=\"postContent\"></textarea><br><input type=\"submit\" id=\"submitPost\"></input>";
	
	newwindow = window.open();
	newdocument = newwindow.document;
	newdocument.write (content);
	
	newdocument.getElementById("submitPost").onClick = function() {
		newwindow.close();
		newdocument.close();
		return newdocument.getElementById("postContent").value;
	};
	
	return newdocument.getElementById("submitPost").getAttribute('onclick');
}


function get_user_index ($email) {
	
	var len = users.length;	
	
	for (var i = 0; i < len; i++) 
	{
		if ($email == users[i].email )
		{
			return i;
		}
	}
	return -1;
}

function checkPwd(str) {
    
	var x="";
	
	if (str.length < 6) {
        x=("too_short");
    } else if (str.length > 50) {
        x=("too_long");
    } else if (str.search(/\d/) == -1) {
        x=("no_num");
    } else if (str.search(/[a-zA-Z]/) == -1) {
        x=("no_letter");
    } else if (str.search(/[^a-zA-Z0-9\!\@\#\$\%\^\&\*\(\)\_\+]/) != -1) {
        x=("bad_char");
    } else {
    x=("ok");
	}
	
	return x;
}

function returnCheckPwd (x) {


	document.getElementById("pwdStatus").innerHTML = checkPwd(x);

}


function resetInputfields() {

	x = document.getElementsByClassName("input-text");
	var i;

	for (i = 0; i < x.length; i++) {
	    x[i].value = "";
	}
}