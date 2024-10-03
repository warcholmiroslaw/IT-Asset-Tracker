
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="public/css/deviceList.css">  
    <link rel="stylesheet" type="text/css" href="public/css/menu.css">
    <link rel="stylesheet" type="text/css" href="public/css/background.css">


    
    <script src="public/scripts/scroller.js" defer></script>
    <script src="public/scripts/search.js" defer></script>
    <script src="public/scripts/addDevice.js" defer></script>
    <script src="public/scripts/editDevice.js" defer></script>
    <script src="public/scripts/deleteDevice.js" defer></script>
    <script src="public/scripts/logout.js" defer></script>
    <title>All devices</title>
</head>
<body>
    <div class = "menu">    
        <h1>Hi, <?php if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {echo $_SESSION['user']['username'];} ?> !<h1>
        <button class = "logout">Logout</button>
    </div>
    <div class = "search-options">

        <h1>Device list</h1>

            <div class = "dropDown-btn">
                <span id = "selected-item">View by</span>
                <span>
                    <img src="images/icons/dropDownArrow.png" alt = "Dropdown icon">
                </span>
            </div>

            <div class = "dropDown-list">
                <div class = "item active">All devices</div>
                <div class = "item">laptop</div>
                <div class = "item">desktop</div>
                <div class = "item">phone</div>
            </div>


        <div class = "search-box">
            <img src="images/icons/search.png" alt="Search icon">
            <input id="search" type="text" name="search" placeholder="Search by serial number">
        </div>

        <div class="add-device">
            <img src="images/icons/add.png" alt="Add icon">
            Add device
        </div>

        <div id = "message">
            <?php if (isset($message) && !empty($message)) {echo $message;} ?>
        </div>
    </div>

    <div class = "device-list">
        <?php if (isset($items) && !empty($items)): ?>
        <?php foreach($items as $device): ?>
            <div class = "device">
                <button class = "button-device">
                    <img src="<?php echo $device->getImage(); ?>" alt="device type icon">
                    <?= $device->getSerialNumber(); ?>
                </button>
                <div class = "func-buttons">
                    <button class = "button-edit">
                        <img src="images/icons/edit.png" alt="edit icon">
                        Edit
                    </button>

                    <button class = "button-remove">
                        <img src="images/icons/remove.png" alt="remove icon">
                        delete
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
        <?php else: ?>
            <p>Brak dostępnych elementów.</p>
        <?php endif; ?>
    </div>

</body>
</html>