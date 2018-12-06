//This file is used to show or hide a fieldset when the checkbox is checked
//Get the radio buttons
const radios = document.querySelectorAll("input[name='pet-category']");
const hiddenRadio = document.getElementById("check");
const hiddenField= document.getElementById("hidden");

//Add an onclick listener to all the radio buttons
for(let item = 0; item < radios.length; item++){
	radios[item].addEventListener("click", handleChecked);
}


function handleChecked(){
	//first get the attribute
	if(hiddenRadio.checked){
		//Show the hidden fieldset
		hiddenField.style.display = "block";
	}else{
		hiddenField.style.display = "none";
	}
}