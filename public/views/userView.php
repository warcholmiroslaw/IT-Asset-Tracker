<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="public/css/userView.css">  
    <link rel="stylesheet" type="text/css" href="public/css/menu.css">
    <link rel="stylesheet" type="text/css" href="public/css/background.css">
    <script src="public/scripts/logout.js" defer></script>

    <title>
        <?php echo $title; ?>
    </title>
</head>
<body>

        <div class = "menu">    
            <h1>
                Hi, <?php if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {echo $_SESSION['user']['username'];} ?> !
            </h1>
            <button class = "logout">Logout</button>
        </div>

        <div class = "equipment-title-main">
            <h1>
                <?php echo $title; ?>
            </h1>
        </div>

        <?php if (isset($devices) && !empty($devices)): ?>
        <?php foreach($devices as $device): ?>

            <div class = "device">
                <div class = "equipment-title">
                    <h1><?php echo $device["type"] ?></h1>
                </div>
                <div class = equipment>
                    <div class = equipment-head>
                        <div class = "equipment-image">
                            <img src="images/devices/<?php echo $device['type'] ?>.jpg" alt="Laptop/Desktop image">
                        </div>

                        <div class = "default-information">
                            <h1>Days to replacement date</h1>
                            <h2><?php echo $device['time_to_replacement']; ?></h2>
                        </div>
                    </div>
                    <div class = "specification">
                        <h1>
                            Specification
                        </h1>

                        <table>
                                <tr>
                                    <td>brand:</td>
                                    <td><?php echo $device['brand']; ?></td>
                                </tr>
                                <tr>
                                    <td>model: </td>
                                    <td><?php echo $device['model']; ?></td>
                                </tr>
                                <tr>
                                    <td>Serial number: </td>
                                    <td><?php echo $device['serial_number']; ?></td>
                                </tr>
                                <tr>
                                    <td>purchase date: </td>
                                    <td><?php echo $device['date_of_purchase']; ?></td>
                                </tr>
                                <tr>
                                    <td>you use it since: </td>
                                    <td><?php echo $device['assigned_at']; ?></td>
                                </tr>
                                <tr>
                                    <td>replacement date: </td>
                                    <td><?php echo $device['replacement_date']; ?></td>
                                </tr>
                            </table>
                    </div>
                </div>
            </div>
    <?php endforeach; ?>
    <?php else: ?>
        <p>Brak dostępnych elementów.</p>
    <?php endif; ?>
</body>
</html>