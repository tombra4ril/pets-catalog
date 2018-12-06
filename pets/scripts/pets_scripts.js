//This file contains javascripts codes used for the show_pets.php file

//This function is used to display a modal box for the picture
function display_hidden_picture(path){
	//Get the div needed to show the picture
	const imageDiv = document.getElementById("hidden");
	const image = imageDiv.querySelector("img");

	//Change attributes to block to show the image
	image.removeAttribute("src");
	image.setAttribute("src", path);
	imageDiv.style.display = "block";
}

//This function is used to close the hidden picture displayed
function close_image(){
	//Get the div
	const imageDiv = document.getElementById("hidden");

	//Change the display attribute to none to hide the image
	imageDiv.style.display = "none";
}