const fields = [
    {
        name: 'name',
        label: 'First Name',
        type: 'text',
        pattern: "^[A-Z][a-z]*$",
        required: true
    },
    {
        name: 'surname',
        label: 'Surname',
        type: 'text',
        pattern: "^[A-Z][a-z]*$",
        required: true
    },
    {
        name: 'job_title',
        label: 'Job Title',
        type: 'text',
        required: true
    },
    {
        name: 'department',
        label: 'Department',
        type: 'text',
        required: true
    },
    {
        name: 'manager',
        label: 'Manager',
        type: 'text',
        pattern: "^[A-Z][a-z]*\\s[A-Z][a-z]*$",
        required: true
    },
    {
        name: 'email',
        label: 'Email',
        type: 'email',
        pattern: "^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}$",
        required: true
    },
    {
        name: 'phone_number',
        label: 'Phone Number',
        type: 'tel',
        pattern: "^\\+?[0-9]{7,15}$",
        required: true
    },
    {
        name: 'password',
        label: 'Password',
        type: 'password',
        minlength: 8,
        required: true
    },
    {
        name: 'confirm_password',
        label: 'Confirm Password',
        type: 'password',
        minlength: 8,
        required: true
    }
];

// wait for HTML to load
var form = '';
document.addEventListener('DOMContentLoaded', init);
var errors = false;


function init() {
    form = document.querySelector('form')

    if (form) {
        form.addEventListener('submit', handleSubmit);
    }
}


function handleSubmit(e) {


    e.preventDefault();

    fields.forEach(function (field) {
        const value = form.elements[field.name].value;
        var errorMessageText = form.querySelector(`.errorMessage[name="${field.name}"]`);
        console.log(errorMessageText);
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


    const password = form.elements['password'].value;
    const confirmPassword = form.elements['confirm_password'].value;

    if (password !== confirmPassword) {
        const confirmPasswordError = form.querySelector('.errorMessage[name="confirm_password"]');
        confirmPasswordError.innerHTML = 'Hasła muszą być takie same!';
        errors = true;
    }

    if (errors === false) {
        alert('Dane zostały wypełnione prawidłowo!');
        e.target.submit();
    }
}

