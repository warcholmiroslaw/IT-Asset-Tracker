var dropDownBtn = document.querySelector('.dropDown-btn')
var dropDownMenu = document.querySelector('.dropDown-list')
var items = document.querySelectorAll('.item')
var currentlySelected = document.querySelector('.item.active')
var navText = document.getElementById('selected-item')
var devicesContainer = document.querySelector(".device-list")
var searchBox = document.getElementById('search')



dropDownBtn.addEventListener('click', toggleMenu)

items.forEach(item => item.addEventListener('click',itemClickHandler))

function toggleMenu() {
    dropDownMenu.classList.toggle('open')
}


function closeMenu() {
    dropDownMenu.classList.remove('open')
}


async function itemClickHandler(e) {
    navText.innerHTML = e.target.textContent;
    currentlySelected.classList.remove('active')
    e.target.classList.add('active')
    currentlySelected = document.querySelector('.item.active')

    const data = {type: e.target.textContent}

    const response = await fetch("/search", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });


    const devices = await response.json();
    console.log(devices);

    devicesContainer.innerHTML = "";
    devices.forEach(device => {
        displayDevice(device);
    })



    closeMenu()
}

searchBox.addEventListener("keyup", async function(e) {
    if(e.key !== 'Enter') {
        return;
    }

    e.preventDefault();

    const data = {search: this.value};

    const response = await fetch("/search", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });
    
    if (!response.ok) {
        throw new Error('Network response was not ok');
    }
    
    const devices = await response.json();
    console.log(devices.length);
    if (devices.length){
        devicesContainer.innerHTML = "";
        devices.forEach(device => {
            displayDevice(device);
        })
    
        searchBox.value = '';
    }
    else {
        devicesContainer.innerHTML = "";
        deviceNotFound();
    }

});

// check which edit button was cliked and redirect edit page
document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.button-edit');

    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const deviceId = this.previousElementSibling.textContent.trim();
            console.log(deviceId);
            window.location.href = `/editDevice?device=${deviceId}`;
        });
    });
});

function chooseImage(deviceType) {

    switch(deviceType) {
        case 'laptop':
            return 'images/icons/laptop.png';
        case 'desktop':
            return 'images/icons/desktop.png';
        case 'phone':
            return 'images/icons/phone.png';
        default:

    }
}


function displayDevice(device) {
    const template = document.querySelector("#nowaNazwa");

    const clone = template.content.cloneNode(true);
    const icon = clone.querySelector("img");
    icon.src = chooseImage(device.type);
    
    const description = clone.querySelector("p");
    description.innerHTML = device.serial_number;

    devicesContainer.appendChild(clone);

}

function deviceNotFound() {
    const template = document.querySelector("#nowaNazwa");

    const clone = template.content.cloneNode(true);

    const buttons = clone.querySelectorAll('button');
        buttons.forEach(button => {
            button.remove();
        });

    const description = clone.querySelector("p");
    description.innerHTML = "Device not found !";

    devicesContainer.appendChild(clone);
}
