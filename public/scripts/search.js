var dropDownBtn = document.querySelector('.dropDown-btn')
var dropDownMenu = document.querySelector('.dropDown-list')
var items = document.querySelectorAll('.item')
var currentlySelected = document.querySelector('.item.active')
var navText = document.getElementById('selected-item')
var deviceList = document.querySelector(".device-list")
var searchBox = document.getElementById('search')
var messageBox = document.getElementById('message')

// return proper path to device photo
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

// when phone/laptop/desktop is clicked it runs the function to display devices
items.forEach(item => item.addEventListener('click',itemClickHandler))

// toggle dropdown Menu, expand when it's closed and close when it's open
dropDownBtn.addEventListener('click', toggleMenu)

// animation using CSS to expand dropdown menu
function toggleMenu() {
    dropDownMenu.classList.toggle('open')
}

// get devices from API
async function fetchDevices(data) {
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

    return await response.json();
}

// Search menu by type of device, get and display data
async function itemClickHandler(e) {
    navText.innerHTML = e.target.textContent;
    currentlySelected.classList.remove('active')
    e.target.classList.add('active')
    currentlySelected = document.querySelector('.item.active')

    const data = { type: e.target.textContent };
    const devices = await fetchDevices(data);

    renderDevices(devices);

    if (devices.length) {
        renderDevices(devices);
    } else {
        deviceNotFound();
    }
    
    toggleMenu();
}

// Searchbox, check if any data was inserted, then get and display devices by SN
searchBox.addEventListener("keyup", async function(e) {
    if(e.key !== 'Enter') {
        return;
    }

    e.preventDefault();

    const data = { search: this.value };
    const devices = await fetchDevices(data);

    if (devices.length) {
        renderDevices(devices);
    } else {
        deviceNotFound();
    }

});

// render div containers of devices
function renderDevices(devices) {
    // Clear list of devices before insert new
    deviceList.innerHTML = '';

    // insert new devices
    devices.forEach(device => {
        displayDevice(device);
    })
}

// generate structure of HTML to display device
function displayDevice(device) {
    
    // generate basic structure of device
    const deviceDiv = document.createElement('div');
    deviceDiv.classList.add('device', 'show');

    const buttonDevice = document.createElement('button');
    buttonDevice.classList.add('button-device');
    
    const icon = document.createElement('img');
    icon.src = chooseImage(device.type);
    const serialNumber = document.createElement('p');
    serialNumber.textContent = device.serial_number;
    
    buttonDevice.appendChild(icon);
    buttonDevice.appendChild(serialNumber);

    // create structure of edit button
    const buttonEdit = document.createElement('button');
    buttonEdit.classList.add('button-edit');
    const editIcon = document.createElement('img');
    editIcon.src = 'images/icons/edit.png';
    editIcon.alt = 'edit icon';
    buttonEdit.textContent = 'Edit';
    buttonEdit.insertBefore(editIcon, buttonEdit.firstChild);
    
    // add action to edit button
    buttonEdit.addEventListener('click', function() {
        window.location.href = `/editDevice?device=${device.serial_number}`;
    });

    // create structure of delete button
    const buttonRemove = document.createElement('button');
    buttonRemove.classList.add('button-remove');
    const removeIcon = document.createElement('img');
    removeIcon.src = 'images/icons/remove.png';
    removeIcon.alt = 'remove icon';
    buttonRemove.textContent = 'Delete';
    buttonRemove.insertBefore(removeIcon, buttonRemove.firstChild);
    
    // add action to delete button
    buttonRemove.addEventListener('click', function() {
        window.location.href = `/deleteDevice?device=${device.serial_number}`;
    });

    // add buttons to div structure
    deviceDiv.appendChild(buttonDevice);
    deviceDiv.appendChild(buttonEdit);
    deviceDiv.appendChild(buttonRemove);
    deviceList.appendChild(deviceDiv);
}

function deviceNotFound() {
    deviceList.innerHTML = "Brak dostepnych elementow !";
}

