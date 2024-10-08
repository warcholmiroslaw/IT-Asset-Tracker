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

    <?php if (isset($items) && !empty($items)): ?>
        <?php $device = $items[0]; ?>

            <div class = 'images-container'>
                <div class="image-box <?php echo $device->getType();?> show">
                </div>
            </div>


        <form action="/updateDevice" method="POST" class = 'device-properties'>

        <?php $attributes = $device->getColumnMapping() ?>

        <?php foreach ($attributes as $attribute => $value): ?>

            <?$method = "get".$value; ?>
            
                <div class = 'set <?php echo $attribute?>'>

                        <span>
                            <?php echo $attribute ?>
                        </span>
                        
                        <?php if($attribute === 'id' || $attribute === 'type'):?>
                            <input required type="text" name="<?php echo $attribute ?>" placeholder="enter data" value = "<?php echo $device->$method();?>"readonly>
                        <?php else: ?>
                            <input required type="text" name="<?php echo $attribute ?>" placeholder="enter data" value = "<?php echo $device->$method();?>">
                        <?endif;?>
                </div>

                <text class = 'errorMessage' name = '<?php echo $attribute?>'>
                    <?php if (isset($errors[$attribute])): ?>
                    <?php echo htmlspecialchars($errors[$attribute]); ?>
                    <?php endif; ?>
                </text>

            <?php endforeach ?>

            <button  class = 'formButton submit' type="submit">Submit</button>
            <button type="button" class="formButton cancel active" onclick="window.location.href='/devicelist';">Cancel changes</button>
        </form>

    <?php else: ?>
        <p class = "data-error">Blad ladowania danych</p>
    <?php endif; ?>


</body>
</html>