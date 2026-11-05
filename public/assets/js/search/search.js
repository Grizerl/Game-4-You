/*
 * Пошук у шапці: результати — у випадаючому списку під полем (окремої сторінки немає).
 * Від 2 символів, debounce 250 мс, клавіатурна навігація. Порожнє значення не шукається:
 * показується підказка, а поле позначається як некоректне. «Нічого не знайдено» — теж у списку.
 */
(function () {
    'use strict';

    var MIN_LENGTH = 2;
    var DELAY = 250;

    function init(form) {
        var input = form.querySelector('input[name="q"]');
        var list = form.querySelector('.hs-search__list');
        var url = form.getAttribute('data-suggest-url');
        var texts = {};

        try {
            texts = JSON.parse(form.getAttribute('data-texts') || '{}');
        } catch (e) {
            texts = {};
        }

        var types = texts.types || {};
        var timer = null;
        var controller = null;
        var active = -1;
        var seq = 0;

        function setInvalid(invalid) {
            form.classList.toggle('is-invalid', invalid);
            input.setAttribute('aria-invalid', invalid ? 'true' : 'false');
        }

        function close() {
            list.hidden = true;
            list.innerHTML = '';
            active = -1;
            input.setAttribute('aria-expanded', 'false');
        }

        function links() {
            return list.querySelectorAll('li[role="option"]');
        }

        function highlight(index) {
            links().forEach(function (node, i) {
                node.classList.toggle('is-active', i === index);
            });
            active = index;
        }

        function message(text, kind) {
            list.innerHTML = '';

            var li = document.createElement('li');
            li.className = 'hs-search__msg' + (kind ? ' is-' + kind : '');
            li.setAttribute('role', 'status');
            li.textContent = text; // textContent — без HTML-ін'єкцій
            list.appendChild(li);

            active = -1;
            list.hidden = false;
            input.setAttribute('aria-expanded', 'true');
        }

        function render(items) {
            if (!Array.isArray(items) || items.length === 0) {
                message(texts.notFound || '', 'empty');
                return;
            }

            list.innerHTML = '';

            items.forEach(function (item) {
                var li = document.createElement('li');
                li.setAttribute('role', 'option');

                var a = document.createElement('a');
                a.href = item.url; // URL будує сервер локалізованими маршрутами

                var type = document.createElement('span');
                type.className = 'hs-search__type';
                type.textContent = types[item.type] || item.type;

                var title = document.createElement('span');
                title.className = 'hs-search__title';
                title.textContent = item.title;

                a.appendChild(type);
                a.appendChild(title);

                if (item.label) {
                    var label = document.createElement('span');
                    label.className = 'hs-search__label';
                    label.textContent = item.label;
                    a.appendChild(label);
                }

                li.appendChild(a);
                list.appendChild(li);
            });

            active = -1;
            list.hidden = false;
            input.setAttribute('aria-expanded', 'true');
        }

        // Повертає false, якщо значення не пройшло перевірку (запит на сервер не надсилається).
        function validate(showMessage) {
            var value = input.value.trim();

            if (value === '') {
                setInvalid(showMessage);
                showMessage ? message(texts.enterQuery || '', 'error') : close();
                return false;
            }

            if (value.length < MIN_LENGTH) {
                setInvalid(showMessage);
                showMessage ? message(texts.tooShort || '', 'error') : close();
                return false;
            }

            setInvalid(false);
            return true;
        }

        function request() {
            if (!validate(false)) {
                return;
            }

            if (controller) {
                controller.abort();
            }
            controller = typeof AbortController !== 'undefined' ? new AbortController() : null;

            var current = ++seq;

            fetch(url + '?q=' + encodeURIComponent(input.value.trim()), {
                headers: { Accept: 'application/json' },
                signal: controller ? controller.signal : undefined,
            })
                .then(function (response) {
                    return response.json().then(function (data) {
                        return { status: response.status, data: data };
                    });
                })
                .then(function (result) {
                    if (current !== seq) {
                        return; // застаріла відповідь
                    }

                    if (result.status === 200) {
                        render(result.data.items);
                    } else if (result.status === 422) {
                        message((result.data && result.data.message) || texts.tooShort || '', 'error');
                    } else {
                        message(texts.unavailable || '', 'error');
                    }
                })
                .catch(function (error) {
                    if (!error || error.name !== 'AbortError') {
                        message(texts.unavailable || '', 'error');
                    }
                });
        }

        input.addEventListener('input', function () {
            clearTimeout(timer);
            seq++; // скасовує відповіді на попередні запити

            if (input.value.trim() === '') {
                setInvalid(false);
                close();
                return;
            }

            timer = setTimeout(request, DELAY);
        });

        // Enter / кнопка: порожнє значення не шукається; вибраний пункт відкривається; інакше — негайний пошук.
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            clearTimeout(timer);

            var nodes = links();

            if (active >= 0 && nodes[active]) {
                window.location.href = nodes[active].querySelector('a').href;
                return;
            }

            if (validate(true)) {
                request();
            } else {
                input.focus();
            }
        });

        input.addEventListener('keydown', function (event) {
            var nodes = links();

            if (event.key === 'ArrowDown' && nodes.length) {
                event.preventDefault();
                highlight((active + 1) % nodes.length);
            } else if (event.key === 'ArrowUp' && nodes.length) {
                event.preventDefault();
                highlight(active <= 0 ? nodes.length - 1 : active - 1);
            } else if (event.key === 'Escape') {
                close();
            }
        });

        document.addEventListener('click', function (event) {
            if (!form.contains(event.target)) {
                close();
                setInvalid(false);
            }
        });
    }

    document.querySelectorAll('[data-hs-search]').forEach(init);
})();
