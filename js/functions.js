
function checkEmail ($email){

	var emailFormat = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+?\.[a-zA-Z]{2,3}$/;
	if (!emailFormat.test($email)) {
		return false;
	} else {
		return true;
	}
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
