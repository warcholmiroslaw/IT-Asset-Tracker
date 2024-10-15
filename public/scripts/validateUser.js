const fields = [
    {
        name: 'name',
        error: 'Must start with an uppercase letter and contain only letters',
        type: 'text',
        pattern: "^[A-Z][a-z]*$",
        required: true
    },
    {
        name: 'surname',
        error: 'Must start with an uppercase letter and contain only letters',
        type: 'text',
        pattern: "^[A-Z][a-z]*$",
        required: true
    },
    {
        name: 'job_title',
        error: 'Job Title is required',
        type: 'text',
        required: true
    },
    {
        name: 'department',
        error: 'Department is required',
        type: 'text',
        required: true
    },
    {
        name: 'manager',
        error: 'Format: "Firstname Lastname", both should start with uppercase',
        type: 'text',
        pattern: "^[A-Z][a-z]*\\s[A-Z][a-z]*$",
        required: true
    },
    {
        name: 'email',
        error: 'Invalid email format',
        type: 'email',
        pattern: "^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}$",
        required: true
    },
    {
        name: 'phone_number',
        error: 'Invalid phone number format. Example: +48783092092 or 783092092',
        type: 'tel',
        pattern: "^\\+?[0-9]{7,15}$",
        required: true
    },
    {
        name: 'password',
        error: 'Password must be at least 8 characters',
        type: 'password',
        minlength: 8,
        required: true
    },
    {
        name: 'confirm_password',
        error: 'Password must be at least 8 characters',
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


async function handleSubmit(e) {


    e.preventDefault();
    errors = false;
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
            else if (field.minlength && value.length < field.minlength) {
                errorMessageText.innerHTML = `Minimum length is ${field.minlength} characters.`;
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


    const password = form.elements['password'].value;
    const confirmPassword = form.elements['confirm_password'].value;

    if (password !== confirmPassword) {
        const confirmPasswordError = form.querySelector('.errorMessage[name="confirm_password"]');
        confirmPasswordError.innerHTML = "Passwords must match!";
        errors = true;
    }

    if (errors === false) {
        alert('Dane zostały wypełnione prawidłowo!');
        e.target.submit();
    }
}

