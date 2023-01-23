const navBtn = document.getElementById('nav-btn');
const cancelBtn = document.getElementById('cancel-btn');

const sideNav = document.getElementById('sidenav');

const modal = document.getElementById('modal');

navBtn.addEventListener("click", function(){
    sideNav.classList.add('show');
    modal.classList.add('showModal');
});

cancelBtn.addEventListener('click', function(){
    sideNav.classList.remove('show');
    modal.classList.remove('showModal');
});
console.log(cancelBtn)
window.addEventListener('click', function(event){
    if(event.target === modal){
        sideNav.classList.remove('show');
        modal.classList.remove('showModal');
    }
});

window.addEventListener("load", function(){
    setTimeout(
        function open(event){
            document.querySelector(".popup").style.display = "block";
        },
        1000
    )
});


document.querySelector("#close2").addEventListener("click", function(){
    document.querySelector(".popup").style.display = "none";
});
