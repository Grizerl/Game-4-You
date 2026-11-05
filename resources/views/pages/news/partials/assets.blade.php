{{-- Шрифти (Oswald + Manrope), спільні стилі (games.scss: чіпи, кнопки, постери) і стилі новин. Підключається через @push('styles'). --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Oswald:wght@500;600;700&display=swap">
@vite(['resources/scss/public/games.scss', 'resources/scss/public/news.scss'])
