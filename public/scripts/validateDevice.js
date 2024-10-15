const fields = [
    {
        name: 'type',
        error: 'Select icon with device',
        type: 'text',
        required: true
    },
    {
        name: 'brand',
        error: 'Brand should start with an uppercase letter.',
        type: 'text',
        pattern: "^[A-Z][a-zA-Z0-9]*(\\s[A-Z][a-zA-Z0-9]*)*$",
        required: true
    },
    {
        name: 'model',
        error: 'Model should start with an uppercase letter followed by letters or numbers.',
        type: 'text',
        pattern: "[A-Z][a-z0-9]*",
        required: true
    },
    {
        name: 'serial_number',
        error: 'Serial number is required.',
        type: 'text',
        required: true
    },
    {
        name: 'purchase_date',
        error: 'Purchase date is required.',
        type: 'date',
        required: true
    },
    {
        name: 'primary_user',
        error: 'Primary user should be in the format: "Firstname Lastname".',
        type: 'text',
        pattern: "^[A-Z][a-z]*\\s[A-Z][a-z]*$",
        required: true
    }
];


// wait for HTML to load
var form = '';
document.addEventListener('DOMContentLoaded', init);
var errorMessage = document.querySelector('#errorMessage');
const errors = [];


async function fetchErrors(data) {
    const response = await fetch("/addDevice", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });

    if (!response.ok) {
        throw new Error('Network response was not ok');
    }

    return await response.json();
}


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
            console.log(errorMessageText);
            errorMessageText.innerHTML   = '';


            if (field.required) {
                if (value.length === 0) {
                    errorMessageText.innerHTML = "This field cannot be empty!";
                    errors = true;
                }
            }

            if (field.pattern) {
                const reg = new RegExp(field.pattern);
                console.log(value);
                if (!reg.test(value)) {
                    errorMessageText.innerHTML = field.error;

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
