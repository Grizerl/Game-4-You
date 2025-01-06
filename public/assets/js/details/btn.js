document.addEventListener("DOMContentLoaded", () => {
    const btn_description = document.getElementById("btn-description");
    const btn_platform = document.getElementById("btn-platform");

    const description_info = document.getElementById("description-info");
    const platform_info = document.getElementById("platform-info");

    const hideAllCardsAndResetButtons = () => {
        description_info?.classList.remove('show');
        platform_info?.classList.remove('show');

        btn_description?.classList.remove('active');
        btn_platform?.classList.remove('active');
    };

    btn_description?.addEventListener('click', (event) => {
        event.preventDefault();
        hideAllCardsAndResetButtons();
        description_info?.classList.add('show');
        btn_description?.classList.add('active');
    });

    btn_platform?.addEventListener('click', (event) => {
        event.preventDefault();
        hideAllCardsAndResetButtons();
        platform_info?.classList.add('show');
        btn_platform?.classList.add('active');
    });

});
