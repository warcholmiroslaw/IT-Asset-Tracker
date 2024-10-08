document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.button-edit');

    editButtons.forEach(button => {
        button.addEventListener('click', function() {

            const deviceElement = this.closest('.device');
            const serialNumber = deviceElement.querySelector('.button-device').textContent.trim();
            
            console.log(serialNumber);
            window.location.href = `/editDevice?device=${serialNumber}`;
        });
    });
});
