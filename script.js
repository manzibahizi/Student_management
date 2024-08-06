document.getElementById("add_student").addEventListener("click",function(e){
    e.preventDefault();
    document.getElementById("add_student_form").style.display="block";
    document.getElementById("add_student_form").style.position="fixed";
    document.getElementById("add_student_form").style.background="white";

    document.getElementById("add_student").style.marginLeft="50%"
})

// Get all elements with the class 'update_student_btn'
const buttons = document.getElementsByClassName("update_student_btn");

// Loop through each element and add an event listener
for (let i = 0; i < buttons.length; i++) {
    buttons[i].addEventListener("click", function(e) {
        e.preventDefault();
        document.getElementById("update_student_form").style.display = "block";
        document.getElementById("update_student_form").style.position = "fixed";
        document.getElementById("update_student_form").style.background = "white";
        document.getElementById("update_student_form").style.marginLeft = "50%";
    });
}
