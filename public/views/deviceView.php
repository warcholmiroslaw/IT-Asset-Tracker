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
        <?php if(isset($title)){echo $title;}?>
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
                <?php if(isset($title)){echo $title;}?>
            </h1>
        </div>

        <?php if (isset($device) && !empty($device)): ?>
            <div class = "device">
                <div class = "equipment-title">
                    <h1><?php echo $device->getType() ?></h1>
                </div>
                <div class = equipment>
                    <div class = equipment-head>
                        <div class = "equipment-image">
                            <img src="images/devices/<?php echo $device->getType();?>.jpg" alt="Laptop/Desktop image">
                        </div>

                        <div class = "default-information">
                            <?php if (isset($dates) && !empty($dates)): ?>
                            <h1>Days to replacement date</h1>
                            <h3><?php echo $dates['endOfAmortization']; ?></h3>
                            <h2><?php echo $dates['timeToReplacement']; ?></h2>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class = "specification">
                        <div class = "specification-info">
                            <h1>
                                Specification
                            </h1>

                            <table>
                                <?php $attributes = $device->getColumnMapping() ?>
                                <?php foreach ($attributes as $attribute => $label): ?>
                                    <tr>
                                        <td><?php echo $label;?></td>
                                        <td><?php echo $device->$attribute;?></td>
                                    </tr>
                                <?php endforeach ?>
                            </table>
                        </div>
                        <div class = 'productive-use'>
                            <h1>Productive Use: </h1>
                            <?php if (isset($usagePercentage)): ?>
                                <h1><?php echo $usagePercentage;?>%</h1>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
    <?php else: ?>
        <p class = "data-error">Can't load data</p>
    <?php endif; ?>
</body>
</html>