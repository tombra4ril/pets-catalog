//This script is used to generate random pictures to display each time the page is reloaded
//Create an object to hold the necessary information of the path to the image file
const name = ["bird", "bird150", "birds1", "birds2", "birds3", "p3", "pic_camelcase", "sealions"];
const extension = ".jpg";
const element = document.getElementById("random-pic");
const path = "images/";

getRandomNum = Math.floor(Math.random() * name.length);
//Load the image file
element.src = path + name[getRandomNum] + extension;