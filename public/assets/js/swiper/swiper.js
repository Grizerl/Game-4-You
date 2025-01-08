document.addEventListener("DOMContentLoaded", function () {
    var swiper = new Swiper(".mySwiper", {
        loop: true,
       
        spaceBetween: 30,
        autoplay: {
            delay: 2000, 
            disableOnInteraction: false, 
        },
        speed: 1000, 
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            800: {
                slidesPerView: 3, 
            },
            600: {
                slidesPerView: 2, 
            },
        },
    });   
});
