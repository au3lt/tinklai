
function validate(){
    var email=document.f1.email.value;
    var password=document.f1.password.value;
    var password2=document.f1.password2.value;
    var name=document.f1.name.value;
    var surname=document.f1.surname.value;
    var status=true;
    var atposition=email.indexOf("@");
    var dotposition=email.lastIndexOf(".");

    if(email.length<1 || email.length>50){
        document.getElementById("emailLoc").innerHTML=
            "Prašome įvesti el. paštą teisingu formatu";
        status=false;
    }else{
        document.getElementById("emailLoc").innerHTML="";
    }

    if(name.length<1 || name.length>50){
        document.getElementById("nameLoc").innerHTML=
            "Prašome įvesti vardą teisingu formatu";
        status=false;
    }else{
        document.getElementById("nameLoc").innerHTML="";
    }

    if(surname.length<1 || surname.length>50){
        document.getElementById("surnameLoc").innerHTML=
            "Prašome įvesti pavardę teisingu formatu";
        status=false;
    }else{
        document.getElementById("surnameLoc").innerHTML="";
    }

    if(password.length<8 || password.length>16){
        status=false;
        document.getElementById("passwordloc").innerHTML=
            "Prašome įvesti slaptažodį nurodytu formatu";
    }else{
        document.getElementById("passwordloc").innerHTML="";
    }

    if(password != password2){
        document.getElementById("password2Loc").innerHTML= "Slaptažodžiai nesutampa";
        status=false;
    }else{
        document.getElementById("password2Loc").innerHTML="";
    }

    if (atposition<1 || dotposition<atposition+2 || dotposition+2>=email.length) {
        document.getElementById("emailLoc").innerHTML=
            "Prašome įvesti el. paštą teisingu formatu";
        status = false;
    }else {
        document.getElementById("emailLoc").innerHTML = "";
    }
    return status;
}

function validateCreateCourseForm(){
    console.log('xd');
    var category=document.createCourseForm.category.value;
    var description=document.createCourseForm.description.value;
    var priceBoth=document.createCourseForm.priceBoth.value;
    var pricePractise=document.createCourseForm.pricePractise.value;
    var priceTheory=document.createCourseForm.priceTheory.value;
    var slots=document.createCourseForm.slots.value;
    var status=true;

    var days = document.querySelectorAll("#createCourseForm select[name='days[]']");
    var startTime = document.querySelectorAll("#createCourseForm input[name='startTime[]']");
    var endTime = document.querySelectorAll("#createCourseForm input[name='endTime[]']");
    var types = document.querySelectorAll("#createCourseForm input[name='type[]']");

    if(days.length > 0 || startTime.length > 0 || endTime.length > 0) {
        if(days.length != startTime.length && days.length != endTime.length && startTime.length != endTime.length && days.length != types.length && startTime.length != types.length && endTime.length != types.length) {
            status = false;
        }
        else {
            for(var i = 0; i < days.length; i++) {
                if(startTime[i].value == "" || endTime[i].value == "") {
                    status = false;
                    document.getElementById("timeLoc").innerHTML="Prašome pasirinkti laikus";
                }
                else {
                    document.getElementById("timeLoc").innerHTML="";
                }
            }
        }
    }

    if(category == ""){
        document.getElementById("categoryLoc").innerHTML=
            "Prašome pasirinkti kategoriją";
        status=false;
    }else{
        document.getElementById("categoryLoc").innerHTML="";
    }
    if(description.length < 10 || description.length > 300){
        document.getElementById("descriptionLoc").innerHTML=
            "Prašome įvesti aprašymą teisingu formatu";
        status=false;
    }else{
        document.getElementById("descriptionLoc").innerHTML="";
    }
    if(isNaN(priceBoth) || priceBoth.length < 1){
        document.getElementById("priceBothLoc").innerHTML=
            "Prašome įvesti kainą skaitine reikšme";
        status=false;
    }else{
        document.getElementById("priceBothLoc").innerHTML="";
    }
    if(isNaN(pricePractise) || pricePractise.length < 1){
        document.getElementById("pricePractiseLoc").innerHTML=
            "Prašome įvesti kainą skaitine reikšme";
        status=false;
    }else{
        document.getElementById("pricePractiseLoc").innerHTML="";
    }
    if(isNaN(priceTheory) || priceTheory.length < 1){
        document.getElementById("priceTheoryLoc").innerHTML=
            "Prašome įvesti kainą skaitine reikšme";
        status=false;
    }else{
        document.getElementById("priceTheoryLoc").innerHTML="";
    }
    if(isNaN(slots) || slots.length < 1){
        document.getElementById("slotsLoc").innerHTML=
            "Prašome įvesti kainą skaitine reikšme";
        status=false;
    }else{
        document.getElementById("slotsLoc").innerHTML="";
    }
    return status;
}
