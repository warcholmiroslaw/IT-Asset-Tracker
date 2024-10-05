<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="public/css/addDevice.css">
    <link rel="stylesheet" type="text/css" href="public/css/background.css">

    <script defer src="public/scripts/addDeviceForm.js" defer></script>
    <script defer src="public/scripts/validateDevice.js" defer></script>
    <title>Add device</title>
</head>
<body>
    <div class = 'title'>
        <h1>Add Device</h1>
    </div>

    <div class = 'device-type'>

        <h3>Select device type</h3>

        <div class = 'images-container'>
            <div class="image-box desktop show"></div>
            <div class="image-box laptop"> </div>
            <div class="image-box phone"> </div>
        </div>
    </div>

    <form action="/saveDevice" method="POST" class = 'device-properties'>

        <input type="hidden" id="type" name="type" value = 'desktop'>
            <text class = 'errorMessage' name = type></text>
        <div class = 'set brand'>
            <input required type="text" name="brand" placeholder="brand">
        </div>
        <text class = 'errorMessage' name = 'brand'></text>

        <div class = 'set model'>
            <input required type="text" name="model" placeholder="model">
        </div>
        <text class = 'errorMessage' name = 'model'></text>

        <div class = 'set serial_number'>
            <input required type="text" name="serial_number" placeholder="serial number">
        </div>
        <text class = 'errorMessage' name = 'serial_number'></text>

        <div class = 'set date_of_purchase'>
            <input  required type="date" name="date_of_purchase" placeholder="purchase date MM/DD/YYYY">
        </div>
        <text class = 'errorMessage' name = 'date_of_purchase'></text>

        <div class = 'set primary_user'>
            <input required type="text" name="primary_user" placeholder="primary user">
        </div>
        <text class = 'errorMessage' name = 'primary_user'></text>

        <button  class = 'submitForm' type="submit">Add device</button>
    </form>


</body>
</html>