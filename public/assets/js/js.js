const navBtn = document.getElementById('nav-btn');
const navch = document.getElementById('cha');
console.log(navch );
const cancelBtn = document.getElementById('cancel-btn');
const cancelch = document.getElementById('cancel-ch');
console.log(cancelch)
const sideNav = document.getElementById('sidenav');
const modal = document.getElementById('modal');

navBtn.addEventListener("click", function(){
    sideNav.classList.add('show');
    modal.classList.add('showModal');
});

cancelBtn.addEventListener('click', function(){
    navch.classList.remove('alert alert-danger alert-dismissible fade show');
    console.log( navch.classList.remove('cha'))

});


window.addEventListener('click', function(event){
    if(event.target === modal){
        sideNav.classList.remove('show');
        modal.classList.remove('showModal');
    }
});
