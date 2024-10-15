<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="public/css/addDevice.css">
    <link rel="stylesheet" type="text/css" href="public/css/background.css">

    <script  src="public/scripts/addDeviceForm.js" defer></script>
    <script  src="public/scripts/validateDevice.js" defer></script>
    <title><?php if(isset($title)){echo $title;}?></title>
</head>
<body>
    <div class = 'title'>
        <?php if(isset($title)){echo $title;}?>
    </div>

    <div class = 'device-type'>

        <h3>Select device type</h3>

        <div class = 'images-container'>
            <div class="image-box desktop show"></div>
            <div class="image-box laptop"> </div>
            <div class="image-box phone"> </div>
        </div>
    </div>
    <?php if (isset($device) && !empty($device)): ?>
        <?php $attributes = $device->getColumnMapping(); ?>

        <form action="/addDevice" method="POST" class = 'device-properties'>

            <input type="hidden" id="type" name="type">
                <text class = 'errorMessage' name = type></text>

            <?php foreach ($attributes as $attribute => $label): ?>

                <?php if ($attribute != "type" && $attribute != "id"): ?>

                    <div class = 'set <?php echo $attribute ?>'>
                        <span>
                            <?php echo $label ?>
                        </span>

                        <?php if ($attribute !== "purchase_date"): ?>
                            <input required type="text" name="<?php echo $attribute ?>"
                               value = "<?php if (isset($_POST[$attribute])) { echo htmlspecialchars($_POST[$attribute]); } ?>"
                               placeholder="click to enter">
                        <?php else: ?>
                            <input required type="date" name="<?php echo $attribute ?>"
                               value = "<?php if (isset($_POST[$attribute])) { echo htmlspecialchars($_POST[$attribute]); } ?>"
                               placeholder="click to enter">

                        <?php endif; ?>

                    </div>
                    <text class = 'errorMessage' name = '<?php echo $attribute ?>'>
                        <?php if (isset($errors[$attribute])): ?>
                            <?php echo htmlspecialchars($errors[$attribute]); ?>
                        <?php endif; ?>
                    </text>

                <?php endif; ?>

            <?php endforeach ?>

            <button  class = 'submitForm' type="submit">Add device</button>
        </form>

    <?php endif; ?>

</body>
</html>