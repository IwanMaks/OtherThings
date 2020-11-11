const input = document.querySelector('input');
const dropdownListsListDefault = document.querySelector('.dropdown-lists__list--default');
const dropdownListsListSelect = document.querySelector('.dropdown-lists__list--select');
const dropdownListsListAutocomplete = document.querySelector('.dropdown-lists__list--autocomplete');
const button = document.querySelector('.button');
const body = document.body;
const loader = body.querySelector('.preload');
let localstr;
const closeButton = document.querySelector('.close-button');


dropdownListsListDefault.style.display = 'none';
button.style.pointerEvents = 'none';

if (!document.cookie) {
    let answer;
    answer = prompt('Выберите язык: русский(RU), немецкий(DE), английский(EN)');
    document.cookie = 'local=' + answer.toUpperCase();
}

const blockAnimation = (blockIn, blockOut) => {
    blockOut.style.display = '';
    blockIn.style.position = 'absolute';
    blockIn.style.left = '-1000px';
    blockOut.style.left = '0px';
    blockOut.style.position = 'absolute';
    blockOut.style.background = 'white';
    blockIn.style.background = 'white';
    const draw = () => {
        blockIn.style.left = (parseInt(blockIn.style.left) + 50) + 'px';
        blockOut.style.left = (parseInt(blockOut.style.left) + 50) + 'px';
        if (parseInt(blockIn.style.left) !== 0) {
            requestAnimationFrame(draw);
        } else {
            blockIn.style.position = '';
            blockOut.style.position = '';
            blockOut.style.display = 'none';
        }
    }

    requestAnimationFrame(draw);
}

/**
 * Этот метод позволяет получить значение локали, которое выбрал пользователь при первом заходе на сайт
 */

const getCookie = () => {
    const result = document.cookie.split('=');
    return result[1];
}

const addCloseBtn = () => {
    if (!(closeButton.style.display === 'block')) {
        closeButton.style.display = 'block';
        closeButton.addEventListener('click', () => {
            input.value = '';
            closeButton.style.display = 'none';
        });
    }
};

/**
 * Этот метод производит поиск совпадений с введёнными значениями в инпут среди городов и выводит их в отдельный блок
 * @param {Array} response Содержит массив с объектами стран с сервера
 */
const outputAuto = (response) => {
    const dropdownListsCol = document.createElement('div');
    dropdownListsCol.classList.add('dropdown-lists__col');
    const dropdownListsCountryBlock = document.createElement('div');
    dropdownListsCountryBlock.classList.add('dropdown-lists__countryBlock');
    input.addEventListener('input', () => {
        addCloseBtn();
        dropdownListsListAutocomplete.style.display = 'block';
        dropdownListsListAutocomplete.textContent = '';
        dropdownListsCol.textContent = '';
        dropdownListsCountryBlock.textContent = '';
        dropdownListsListDefault.style.display = 'none';
        dropdownListsListSelect.style.display = 'none';
        let buf;
        if (input.value) {
            response.forEach(elem => {
                elem.cities.forEach(city => {
                    if (city.name.toLocaleLowerCase().includes(input.value.toLocaleLowerCase())) {
                        const reg = new RegExp(input.value + "+", "gi");
                        let cityName = '';
                        cityName = city.name.replace(reg, (match) => '<b>' + match + '</b>');
                        const dropdownListsLine = document.createElement('div');
                        dropdownListsLine.classList.add('dropdown-lists__line');
                        dropdownListsLine.insertAdjacentHTML('beforeend', `
                            <div class="dropdown-lists__city">${cityName}</div>
                            <div class="dropdown-lists__count">${elem.country}</div>
                        `);
                        dropdownListsCountryBlock.append(dropdownListsLine);
                        dropdownListsLine.addEventListener('click', () => {
                            input.value = elem.country + ', ' + city.name;
                            button.href = city.link;
                            button.style.pointerEvents = '';
                            input.focus();
                        });
                    }
                }) 
            }) 
        }
        if(!dropdownListsCountryBlock.textContent) {
            const dropdownListsLine = document.createElement('div');
            dropdownListsLine.classList.add('dropdown-lists__line');
            dropdownListsLine.insertAdjacentHTML('beforeend', `
                <div class="dropdown-lists__city">Ничего не найдено</div>
            `);
            dropdownListsCountryBlock.append(dropdownListsLine);
        }
        dropdownListsCol.append(dropdownListsCountryBlock);
        dropdownListsListAutocomplete.append(dropdownListsCol);
        if (input.value) {
            dropdownListsListAutocomplete.style.display = 'block';
            button.style.pointerEvents = 'none';
        } else {
            closeButton.style.display = 'none';
            dropdownListsListAutocomplete.style.display = 'none';
            dropdownListsListDefault.style.display = '';
            dropdownListsListSelect.style.display = '';
        }
        
    });
};

/**
 * Этот метод производит вывод блока при нажатии на страну
 * @param {Array} response Содержит массив с объектами стран с сервера
 * @param {Array} item Похож на response
 * @param {HTMLElement} dropdownListsCountryBlock Элемент на который нажимает пользователь 
 * @param {Array} sortCities Отсортированный массив с городами
 */
const outputSelect = (response, item, dropdownListsCountryBlock, sortCities) => {
    const dropdownListsTotalLine = dropdownListsCountryBlock.querySelector('.dropdown-lists__total-line');
    dropdownListsListSelect.textContent = '';
    const dropdownLlistsCol = document.createElement('div');
    dropdownLlistsCol.classList.add('dropdown-lists__col');
    dropdownListsTotalLine.addEventListener('click', () => {
        input.focus();
        //dropdownListsListDefault.style.display = 'none';
        const dropdownListsCountryBlock = document.createElement('div');
        dropdownListsCountryBlock.classList.add('dropdown-lists__countryBlock');
        dropdownListsCountryBlock.insertAdjacentHTML('beforeend', `
            <div class="dropdown-lists__total-line">
                <div class="dropdown-lists__country">${item.country}</div>
                <div class="dropdown-lists__count">${item.count}</div>
            </div>
        `);
        sortCities.forEach(elem => {
            const dropdownListsLine = document.createElement('div');
            dropdownListsLine.classList.add('dropdown-lists__line');
            dropdownListsLine.insertAdjacentHTML('beforeend', `
                <div class="dropdown-lists__city">${elem.name}</div>
                <div class="dropdown-lists__count">${elem.count}</div>
            `);
            dropdownListsCountryBlock.append(dropdownListsLine);
            const dropdownListsCity = dropdownListsLine.querySelector('.dropdown-lists__city');
            dropdownListsCity.addEventListener('click', () => {
                input.value = item.country + ', ' + elem.name;
                addCloseBtn();
                button.href = elem.link;
                button.style.pointerEvents = '';
                input.focus();
            });
        });
        dropdownLlistsCol.append(dropdownListsCountryBlock);
        dropdownListsListSelect.append(dropdownLlistsCol);
        dropdownListsListSelect.classList.remove('dropdown-lists__list--select');
        blockAnimation(dropdownListsListSelect, dropdownListsListDefault);
        const dropdownListsCountry = dropdownListsCountryBlock.querySelector('.dropdown-lists__total-line');
        dropdownListsCountry.addEventListener('click', () => {
            input.focus();
            dropdownListsListDefault.style.display = 'block';
            blockAnimation(dropdownListsListDefault, dropdownListsListSelect);
            outputDefault(response);
        });
    });
};

/**
 * Этот метод выводит начальне значения со всеми страннами и топ городами этих стран
 * @param {Array} response Содержит массив с объектами стран с сервера
 */
const outputDefault = response => {
    dropdownListsListAutocomplete.style.display = 'none';
    dropdownListsListSelect.classList.add('dropdown-lists__list--select');
    dropdownListsListDefault.textContent = '';
    const dropdownLlistsCol = document.createElement('div');
    dropdownLlistsCol.classList.add('dropdown-lists__col');
    if (getCookie() === 'DE' && response[0].country !== 'Deutschland') {
        buf = response[0];
        response[0] = response[1];
        response[1] = buf;
    } else if (getCookie() === 'EN' && response[0].country !== 'United Kingdom') {
        buf = response[0];
        response[0] = response[2];
        response[2] = buf;
    }
    response.forEach(item => {
        const sortCities = item.cities.sort((prev, next) => next.count - prev.count);
        const dropdownListsCountryBlock = document.createElement('div');
        dropdownListsCountryBlock.classList.add('dropdown-lists__countryBlock');
        dropdownListsCountryBlock.insertAdjacentHTML('beforeend', `
            <div class="dropdown-lists__total-line">
                <div class="dropdown-lists__country">${item.country}</div>
                <div class="dropdown-lists__count">${item.count}</div>
            </div>
            <div class="dropdown-lists__line">
                <div class="dropdown-lists__city dropdown-lists__city--ip">${sortCities[0].name}</div>
                <div class="dropdown-lists__count">${sortCities[0].count}</div>
            </div>
            <div class="dropdown-lists__line">
                <div class="dropdown-lists__city">${sortCities[1].name}</div>
                <div class="dropdown-lists__count">${sortCities[1].count}</div>
            </div>
            <div class="dropdown-lists__line">
                <div class="dropdown-lists__city">${sortCities[2].name}</div>
                <div class="dropdown-lists__count">${sortCities[2].count}</div>
            </div>
        `);
        const dropdownListsCity = dropdownListsCountryBlock.querySelectorAll('.dropdown-lists__line');
        dropdownListsCity.forEach((element, index) => {
            element.addEventListener('click', () => {
                input.value = item.country + ', ' + sortCities[index].name;
                addCloseBtn();
                button.href = sortCities[index].link;
                button.style.pointerEvents = '';
                input.focus();
            });
        });
        dropdownLlistsCol.append(dropdownListsCountryBlock);
        dropdownListsListDefault.append(dropdownLlistsCol);
        outputSelect(response, item, dropdownListsCountryBlock, sortCities);
    });
};

/**
 * Этот метод делает запрос на сервер и запускает работу программы
 */
 const postData = () => {
    const request = new XMLHttpRequest();
    request.addEventListener('readystatechange', () => {
        if (request.readyState !== 4) {
            return;
        }
        if (request.status === 200) {
            let answer = JSON.parse(request.responseText);
            localStorage.setItem('DataCity', JSON.stringify(answer[getCookie()]));
            outputDefault(answer[getCookie()]);
            outputAuto(answer[getCookie()]); 
            loader.style.display = 'none';
        } else {
            input.value = 'Извините, произошла ошибка';
            input.focus();
            const error = new Error('Network status is not 200!!!!!!');
        }
    });
    request.open('GET', './db_cities.json');
    request.setRequestHeader('Content-Type', 'application/json');
    request.send();
};

if (!localStorage.getItem('DataCity')) {
    setTimeout(postData, 10000);
} else {
    localstr = JSON.parse(localStorage.getItem('DataCity'));
    outputDefault(localstr);
    outputAuto(localstr);
    loader.style.display = 'none';
}

input.addEventListener('click', () => {
    dropdownListsListDefault.style.display = '';
});

body.addEventListener('click', (event) => {
    if (event.target !== input) {
            if (!event.target.closest('.dropdown-lists__total-line')){ 
                dropdownListsListDefault.style.display = 'none';
                dropdownListsListSelect.style.display = 'none';
                dropdownListsListAutocomplete.style.display = 'none';
                if (input.value) {
                    input.focus();
                }
            }
    }
});