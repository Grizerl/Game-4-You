const menu = document.getElementById('navbar-menu');
const btn_open = document.getElementById('btn-open');
const btn_close = document.getElementById('btn-close');

btn_open.addEventListener("click",()=>{
    menu.classList.toggle('active');
});

btn_close.addEventListener("click",()=>{
    menu.classList.remove('active');
});