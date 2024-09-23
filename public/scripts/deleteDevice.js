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