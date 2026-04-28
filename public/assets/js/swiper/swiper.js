let swiper = null;

function initSwiper() {
    swiper = new Swiper(".mySwiper", {
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
            800: { slidesPerView: 3 },
            600: { slidesPerView: 2 },
        },
    });
}

document.addEventListener("DOMContentLoaded", function () {
    initSwiper();
});