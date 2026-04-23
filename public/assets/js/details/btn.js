document.addEventListener("DOMContentLoaded", () => {
    const btn_description = document.getElementById("btn-description");
    const btn_platform = document.getElementById("btn-platform");
    const btn_comments = document.getElementById("btn-comments");

    const description_info = document.getElementById("description-info");
    const platform_info = document.getElementById("platform-info");
    const comments_info = document.getElementById("comments-info");

    const hideAllCardsAndResetButtons = () => {
        description_info?.classList.remove('show');
        platform_info?.classList.remove('show');
        comments_info?.classList.remove('show');

        btn_description?.classList.remove('active');
        btn_platform?.classList.remove('active');
        btn_comments?.classList.remove('active');
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

    btn_comments?.addEventListener('click', (event) => {
        event.preventDefault();
        hideAllCardsAndResetButtons();
        comments_info?.classList.add('show');
        btn_comments?.classList.add('active');
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("comment-modal");
    const openBtn = document.getElementById("open-comment-modal");
    const closeBtn = document.querySelector(".close-modal");

    openBtn?.addEventListener("click", () => {
        modal.style.display = "flex";
    });

    closeBtn?.addEventListener("click", () => {
        modal.style.display = "none";
    });

    window.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    });
});