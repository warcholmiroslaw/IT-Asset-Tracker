document.addEventListener('DOMContentLoaded', function() {
    const deviceProperties = document.querySelectorAll('.button-device');

    deviceProperties.forEach(button => {
        button.addEventListener('click', function() {

            const serialNumber = button.textContent.trim();
            
            console.log(serialNumber);
            window.location.href = `/deviceView?device=${serialNumber}`;
        });
    });
});
