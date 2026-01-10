const baseUrl = "http://localhost:8000/api/";


var token = null;


$(document).ready(function () {
	hideDiv("main");
});

function upload(file, title, artist, lyric) {
	console.log(file,  title, artist, lyric);
	const formData = new FormData();
	formData.append("music_file", file);
	formData.append("token", token);
	formData.append("title", title);
	formData.append("artist", artist);
	formData.append("lyric", lyric);


	$.ajax({
		type: "post",
		url: baseUrl + "upload.php",
		data: formData,
		processData: false,
		contentType: false, 
		success: function (response) {
			console.log(response);
			alert(response.message);	
		}
	});
}

function login(username, password) {

	const data = {
		"user": username,
		"password": password
	}
	
	$.ajax({
		type: "post",
		url: baseUrl + "login.php",
		data: data,
		success: function (response) {
			console.log(response);
			if (response.status == "success") {
				// alert("Login successful! Token: " + response.token);
				showDiv("main");
				token = response.token;
				alert(token);
			} else {
				hideDiv("main");
				alert("Login failed: " + response.message);
				token = null;
			}
		}
	});
}






function showDiv(id) {
	document.getElementById(id).style.display = "block";
}


function hideDiv(id) {
	document.getElementById(id).style.display = "none";
}
