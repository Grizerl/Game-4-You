document.addEventListener("DOMContentLoaded", () => {
    const btn_silver = document.getElementById("btn-description");
    const btn_platinum = document.getElementById("btn-platform");
    const btn_gold = document.getElementById("btn-stores");

    const card_silver = document.getElementById("description-info");
    const card_platinum = document.getElementById("platform-info");
    const card_gold = document.getElementById("stores-info");

    // Функція для приховування всіх карток і скидання активного стану кнопок
    const hideAllCardsAndResetButtons = () => {
        card_silver?.classList.remove('show');
        card_platinum?.classList.remove('show');
        card_gold?.classList.remove('show');

        btn_silver?.classList.remove('active');
        btn_platinum?.classList.remove('active');
        btn_gold?.classList.remove('active');
    };

    // Обробник для кнопки "Silver"
    btn_silver?.addEventListener('click', (event) => {
        event.preventDefault();
        hideAllCardsAndResetButtons();
        card_silver?.classList.add('show');
        btn_silver?.classList.add('active');
    });

    // Обробник для кнопки "Platinum"
    btn_platinum?.addEventListener('click', (event) => {
        event.preventDefault();
        hideAllCardsAndResetButtons();
        card_platinum?.classList.add('show');
        btn_platinum?.classList.add('active');
    });

    // Обробник для кнопки "Gold"
    btn_gold?.addEventListener('click', (event) => {
        event.preventDefault();
        hideAllCardsAndResetButtons();
        card_gold?.classList.add('show');
        btn_gold?.classList.add('active');
    });
});
