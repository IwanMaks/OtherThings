
const input = document.querySelector('.input-value');
const output = document.querySelector('.output-value');
const button = document.querySelector('button');
const selectInput = document.querySelector('#input');
const selectOutput = document.querySelector('#output');

const addFetch = () => {
    return fetch('https://api.exchangeratesapi.io/latest');
};

const konvert = (data) => {
    let result;
    if (selectInput.value === 'EUR' && selectOutput.value !== 'EUR') {
        result = input.value * data.rates[selectOutput.value];
    } else if (selectOutput.value !== 'EUR') {
        result = (input.value / data.rates[selectInput.value]) * data.rates[selectOutput.value];
    } else if (selectOutput.value === 'EUR' && selectInput.value !== 'EUR') {
        result = input.value * (1 / data.rates[selectInput.value]);
    } else {
        result = input.value;
    }
    output.value = result;
};

addFetch()
    .then((response) => {
        if (response.status !== 200) {
            throw new Error('Status network is not 200');
        }
        console.log(response);
        return response.json();
    })
    .then((response) => {
        button.addEventListener('click', () => {
           konvert(response);
        });
    });