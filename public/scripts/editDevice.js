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