//This file is used to make the page(catalog.php) reload when the reload image button is clicked

//Get the button clicked
const button = document.getElementById("button-reload");

//Get the number to display
const number = document.getElementById("select").value;

//add a click listener to the button
button.addEventListener("click", reloadPage);

function reloadPage(){
	document.getElementById("form").onSubmit = "true";
}