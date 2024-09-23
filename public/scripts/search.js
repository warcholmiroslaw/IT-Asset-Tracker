var dropDownBtn = document.querySelector('.dropDown-btn')
var dropDownMenu = document.querySelector('.dropDown-list')
var items = document.querySelectorAll('.item')
var currentlySelected = document.querySelector('.item.active')
var navText = document.getElementById('selected-item')
var devicesContainer = document.querySelector(".device-list")
var searchBox = document.getElementById('search')
var messageBox = document.getElementById('message')



dropDownBtn.addEventListener('click', toggleMenu)

items.forEach(item => item.addEventListener('click',itemClickHandler))

function toggleMenu() {
    dropDownMenu.classList.toggle('open')
}


function closeMenu() {
    dropDownMenu.classList.remove('open')
}


// get and display list of devices
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
    // console.log(devices);

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
    // console.log(devices.length);
    if (devices.length){
        devicesContainer.innerHTML = "";
        devices.forEach(device => {
            displayDevice(device);
        })
    
        searchBox.value = '';
    }
    else {
        devicesContainer.innerHTML = "";
        //deviceNotFound();
    }

});
document.addEventListener('DOMContentLoaded', function () {
    const deviceList = document.querySelector('.device-list');

    // Funkcja, która renderuje urządzenia na podstawie otrzymanych danych
    function renderDevices(devices) {
        // Czyszczenie listy urządzeń przed wstawieniem nowych
        deviceList.innerHTML = '';

        devices.forEach(device => {
            // Tworzenie nowego elementu dla urządzenia
            const deviceDiv = document.createElement('div');
            deviceDiv.classList.add('device');

            // Tworzenie przycisku urządzenia
            const buttonDevice = document.createElement('button');
            buttonDevice.classList.add('button-device');
            const imgDevice = document.createElement('img');
            imgDevice.src = device.image; // zakładamy, że JSON zawiera `image`
            const serialNumber = document.createElement('p');
            serialNumber.textContent = device.serialNumber;

            buttonDevice.appendChild(imgDevice);
            buttonDevice.appendChild(serialNumber);

            // Tworzenie przycisku edytuj
            const buttonEdit = document.createElement('button');
            buttonEdit.classList.add('button-edit');
            const imgEdit = document.createElement('img');
            imgEdit.src = 'images/icons/edit.png';
            imgEdit.alt = 'edit icon';
            buttonEdit.textContent = 'Edit';
            buttonEdit.insertBefore(imgEdit, buttonEdit.firstChild);

            // Tworzenie przycisku usuń
            const buttonRemove = document.createElement('button');
            buttonRemove.classList.add('button-remove');
            const imgRemove = document.createElement('img');
            imgRemove.src = 'images/icons/remove.png';
            imgRemove.alt = 'remove icon';
            buttonRemove.textContent = 'Delete';
            buttonRemove.insertBefore(imgRemove, buttonRemove.firstChild);

            // Dodawanie elementów do kontenera urządzenia
            deviceDiv.appendChild(buttonDevice);
            deviceDiv.appendChild(buttonEdit);
            deviceDiv.appendChild(buttonRemove);

            // Dodawanie urządzenia do listy
            deviceList.appendChild(deviceDiv);
        });
    }

    // Delegacja zdarzeń dla dynamicznie dodawanych przycisków
    deviceList.addEventListener('click', async function(event) {
        if (event.target && event.target.matches('.button-remove')) {
            const button = event.target.closest('.button-remove');
            const deviceDiv = button.closest('.device');
            const deviceButton = deviceDiv.querySelector('.button-device');
            const deviceId = deviceButton.querySelector('p').textContent.trim();

            try {
                const response = await fetch(`/deleteDevice?device=${deviceId}`, {
                    method: 'DELETE' // Używamy metody DELETE do usunięcia
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                // Jeśli usunięcie się powiodło, usuń element z DOM
                deviceDiv.remove();
                console.log(`Device with serial number ${deviceId} removed.`);
            } catch (error) {
                console.error('Error:', error);
            }
        }
    });
});
// document.addEventListener('DOMContentLoaded', function () {
//     const deviceList = document.querySelector('.device-list');

//     // Funkcja, która renderuje urządzenia na podstawie otrzymanych danych
//     function renderDevices(devices) {
//         // Czyszczenie listy urządzeń przed wstawieniem nowych
//         deviceList.innerHTML = '';

//         devices.forEach(device => {
//             // Tworzenie nowego elementu dla urządzenia
//             const deviceDiv = document.createElement('div');
//             deviceDiv.classList.add('device');

//             // Tworzenie przycisku urządzenia
//             const buttonDevice = document.createElement('button');
//             buttonDevice.classList.add('button-device');
//             const imgDevice = document.createElement('img');
//             imgDevice.src = device.image; // zakładamy, że JSON zawiera `image`
//             const serialNumber = document.createElement('p');
//             serialNumber.textContent = device.serialNumber;

//             buttonDevice.appendChild(imgDevice);
//             buttonDevice.appendChild(serialNumber);

//             // Tworzenie przycisku edytuj
//             const buttonEdit = document.createElement('button');
//             buttonEdit.classList.add('button-edit');
//             const imgEdit = document.createElement('img');
//             imgEdit.src = 'images/icons/edit.png';
//             imgEdit.alt = 'edit icon';
//             buttonEdit.textContent = 'Edit';
//             buttonEdit.insertBefore(imgEdit, buttonEdit.firstChild);

//             // Tworzenie przycisku usuń
//             const buttonRemove = document.createElement('button');
//             buttonRemove.classList.add('button-remove');
//             const imgRemove = document.createElement('img');
//             imgRemove.src = 'images/icons/remove.png';
//             imgRemove.alt = 'remove icon';
//             buttonRemove.textContent = 'delete';
//             buttonRemove.insertBefore(imgRemove, buttonRemove.firstChild);

//             // Dodawanie elementów do kontenera urządzenia
//             deviceDiv.appendChild(buttonDevice);
//             deviceDiv.appendChild(buttonEdit);
//             deviceDiv.appendChild(buttonRemove);

//             // Dodawanie urządzenia do listy
//             deviceList.appendChild(deviceDiv);
//         });
//     }
//     // Delegacja zdarzeń dla dynamicznie dodawanych przycisków
//     deviceList.addEventListener('click', function(event) {
//         if (event.target && event.target.matches('.button-remove')) {
//             const button = event.target;
//             const deviceButton = button.closest('.device').querySelector('.button-device');
//             const deviceId = deviceButton.querySelector('p').textContent.trim();

//             console.log(deviceId);
//             window.location.href = `/deleteDevice?device=${deviceId}`;
//         }
//     });
// });


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

// check which delete button was cliked and delete this device
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.button-remove');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const deviceButton = this.closest('.device').querySelector('.button-device');
            const deviceId = deviceButton.textContent.trim();
            console.log(deviceId);
            window.location.href = `/deleteDevice?device=${deviceId}`;
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

    
    const buttonEdit = document.createElement('button');
    buttonEdit.classList.add('button-edit');
    const editIcon = document.createElement('img');
    editIcon.src = 'images/icons/edit.png';
    editIcon.alt = 'edit icon';
    buttonEdit.textContent = 'Edit';
    buttonEdit.insertBefore(editIcon, buttonEdit.firstChild);
    
    
    buttonEdit.addEventListener('click', function() {
        console.log(`Editing device with serial number: ${device.serial_number}`);
        window.location.href = `/editDevice?device=${device.serial_number}`;
    });

    
    const buttonRemove = document.createElement('button');
    buttonRemove.classList.add('button-remove');
    const removeIcon = document.createElement('img');
    removeIcon.src = 'images/icons/remove.png';
    removeIcon.alt = 'remove icon';
    buttonRemove.textContent = 'Delete';
    buttonRemove.insertBefore(removeIcon, buttonRemove.firstChild);
    
    
    buttonRemove.addEventListener('click', function() {
        console.log(`Removing device with serial number: ${device.serial_number}`);
        window.location.href = `/deleteDevice?device=${device.serial_number}`;
    });

    
    deviceDiv.appendChild(buttonDevice);
    deviceDiv.appendChild(buttonEdit);
    deviceDiv.appendChild(buttonRemove);

    
    devicesContainer.appendChild(deviceDiv);
}

// function deviceNotFound() {
//     const template = document.querySelector("#nowaNazwa");

//     const clone = template.content.cloneNode(true);

//     const buttons = clone.querySelectorAll('button');
//         buttons.forEach(button => {
//             button.remove();
//         });

//     const description = clone.querySelector("p");
//     description.innerHTML = "Device not found !";

//     devicesContainer.appendChild(clone);
// }
