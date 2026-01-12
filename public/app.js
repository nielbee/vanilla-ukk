const baseUrl = "http://localhost:8000/api/";


var token = null;


$(document).ready(function () {
	// hideDiv("main");
	getData("","#list_lagu")
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



function getData(search,id_target){
	$.ajax({
		type: "get",
		url: baseUrl+"list.php?search="+search,
		success: function (response) {
			// $(id_target).append(response);		
			// console.log(response);

			$.each(response, function (indexInArray, valueOfElement) { 
				//  $(id_target).append(indexInArray);
				console.log(valueOfElement.id);
				$(id_target).append("<tr>");
				$(id_target).append("<td>"+valueOfElement.artist+" - "+valueOfElement.title+"</td>");
				$(id_target).append("<td> <button class='btn btn-danger' onclick='deleteMusic("+valueOfElement.id+")'>Delete</button> </td>");
				$(id_target).append("</tr>");
			});
		}
	});
}


function showDiv(id) {
	document.getElementById(id).style.display = "block";
}


function hideDiv(id) {
	document.getElementById(id).style.display = "none";
}
