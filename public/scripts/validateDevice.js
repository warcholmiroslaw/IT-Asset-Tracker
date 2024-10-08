const fields = [
    { 
        name: 'type', 
        label: 'Type', 
        type: 'text', 
        required: true },
    { 
        name: 'brand', 
        label: 'Brand', 
        type: 'text', 
        required: true },
    { 
        name: 'model',
        label: 'Model', 
        type: 'text',
        pattern: "[A-Z][a-z0-9]*", 
        required: true },
    { 
        name: 'serial_number', 
        label: 'Serial number', 
        type: 'text', 
        required: true},
    { 
        name: 'purchase_date', 
        label: 'Purchase date', 
        type: 'date',
        required: true },
    {
        name: 'primary_user',
        label: 'Primary user',
        type: 'text',
        pattern: "^[A-Z][a-z]*\\s[A-Z][a-z]*$",
        required: true}
];


// wait for HTML to load
var form = '';
document.addEventListener('DOMContentLoaded', init);
var errorMessage = document.querySelector('#errorMessage');
const errors = [];


function init() {
    form = document.querySelector('form')
  
    if (form) {
        form.addEventListener('submit', handleSubmit);
    }
}


function handleSubmit(e) {
    
    e.preventDefault();
    let errors = false;

    fields.forEach(function (field) {
            const value = form.elements[field.name].value;
            var errorMessageText = form.querySelector(`.errorMessage[name="${field.name}"]`);
            console.log(errorMessageText)
            errorMessageText.innerHTML   = '';


            if (field.required) {
                if (value.length === 0) {
                    errorMessageText.innerHTML = "Pole nie moze byc puste!";
                    errors = true;
                }
            }

            if (field.pattern) {
                const reg = new RegExp(field.pattern);
                console.log(value);
                if (!reg.test(value)) {
                    errorMessageText.innerHTML = ('Dane zawierają niedozwolone znaki lub nie są zgodne z przyjętym wzorem.');
                    
                    errors = true;
                }
            }

        });
    if (errors == false) {
        alert('Dane zostały wypełnione prawidłowo!');
        e.target.submit();
        //clearForm();
    }
}
