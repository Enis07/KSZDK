const selectBtn = document.querySelector(".select-btn"),
    items = document.querySelectorAll(".item");

selectBtn.addEventListener("click", () => {
    selectBtn.classList.toggle("open");
});



items.forEach(item => {
    item.addEventListener("click", () => {
        item.classList.toggle("checked");

        let checked = document.querySelectorAll(".checked"),
           btnText = document.querySelector(".btn-text");

           
    });
});



const selectBtn2 = document.querySelector(".select-btn2"),
    items2 = document.querySelectorAll(".item2");

selectBtn2.addEventListener("click", () => {
    selectBtn2.classList.toggle("open");
});

items2.forEach(item => {
    item.addEventListener("click", () => {
        item.classList.toggle("checked");

        let checked = document.querySelectorAll(".checked"),
           btnText2 = document.querySelector(".btn-text2");


    });
});

const selectBtn3 = document.querySelector(".select-btn3"),
    items3 = document.querySelectorAll(".item3");

selectBtn3.addEventListener("click", () => {
    selectBtn3.classList.toggle("open");
});

items3.forEach(item => {
    item.addEventListener("click", () => {
        item.classList.toggle("checked");

        let checked = document.querySelectorAll(".checked"),
           btnText3 = document.querySelector(".btn-text3");


    });
});


document.getElementById("dateIcon").addEventListener("click", function() {
    var dateInput = document.getElementById("datum");
    dateInput.setAttribute("open", "true"); // Toggle the 'open' attribute
    dateInput.focus(); // Focus on the date input
  });
  
  