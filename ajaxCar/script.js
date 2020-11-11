document.addEventListener('DOMContentLoaded', () => {
    'use strict';

    const select = document.getElementById('cars'),
        output = document.getElementById('output');

    const addResponse = () => {
        return new Promise((resolve, reject) => {
            const request = new XMLHttpRequest();
            request.open('GET', './cars.json');
            request.addEventListener('readystatechange', () => {
                if (request.status === 200) {
                    const answer = request.responseText;
                    const data = JSON.parse(answer);
                    console.log(data);
                    resolve(data);
                } else {
                    reject();
                }
            }); 
            request.setRequestHeader('Content-type', 'application/json');
            request.send();
        });
    };

    select.addEventListener('change', () => {
        addResponse()
            .then((data) => {
                data.cars.forEach(item => {
                    if (item.brand === select.value) {
                        const {brand, model, price} = item;
                        output.innerHTML = `Тачка ${brand} ${model} <br>
                        Цена: ${price}$`;
                    }
                });
            })
            .catch(() => {
            output.innerHTML = 'Произошла ошибка';
            });
    });

});