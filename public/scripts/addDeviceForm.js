
var devices = document.querySelectorAll('.image-box');
var typeForm = document.getElementById('type');
var currentlySelected = document.querySelector('.image-box.show');

devices.forEach(function(device) {
    device.addEventListener('click', function() {
        currentlySelected.classList.remove('show')
        device.classList.add('show')
        currentlySelected = device
        typeForm.value = device.classList[1];
    });
});
