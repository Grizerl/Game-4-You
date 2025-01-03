document.addEventListener("DOMContentLoaded", function () {
    var swiper = new Swiper(".mySwiper", {
        loop: true,
        slidesPerView: 3,
        spaceBetween: 30,
        autoplay: true,
        autoplaySpeed: 2000,
        speed: 1000,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });   

    
});
 