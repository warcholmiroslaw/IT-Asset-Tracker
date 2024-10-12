<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="public/css/editDevice.css">
    <link rel="stylesheet" type="text/css" href="public/css/background.css"> 
 
    <script defer src="public/scripts/validateDevice.js" defer></script>
    <title>Device properties</title>
</head>
<body>
    <div class = 'title'>
        <h1>Edit Device</h1>
    </div>

    <?php if (isset($device)): ?>
            <div class = 'images-container'>
                <div class="image-box <?php echo $device->getType();?> show">
                </div>
            </div>


        <form action="/updateDevice" method="POST" class = 'device-properties'>

        <?php $attributes = $device->getColumnMapping() ?>

        <?php foreach ($attributes as $attribute => $label): ?>


            
                <div class = 'set <?php echo $attribute?>'>

                        <span>
                            <?php echo $label ?>
                        </span>
                        
                        <?php if($attribute === 'id' || $attribute === 'type'):?>
                            <input required type="text" name="<?php echo $attribute ?>" placeholder="enter data" value = "<?php echo $device->$attribute;?>"readonly>
                        <?php else: ?>

                            <?php if ($attribute !== "purchase_date"): ?>
                                <input required type="text" name="<?php echo $attribute ?>" placeholder="enter data" value = "<?php echo $device->$attribute;?>">
                            <?php else: ?>
                                <input required type="date" name="<?php echo $attribute ?>" placeholder="enter data" value = "<?php echo $device->$attribute;?>">
                            <?php endif; ?>
                        <?endif;?>
                </div>

                <text class = 'errorMessage' name = '<?php echo $attribute?>'>
                    <?php if (isset($errors[$attribute])): ?>
                    <?php echo htmlspecialchars($errors[$attribute]); ?>
                    <?php endif; ?>
                </text>

        <?php endforeach ?>

            <button  class = 'formButton submit' type="submit">Submit</button>
            <button type="button" class="formButton cancel active" onclick="window.location.href='/deviceList';">Cancel changes</button>
        </form>

    <?php else: ?>
        <p class = "data-error">Blad ladowania danych</p>
    <?php endif; ?>


</body>
</html>