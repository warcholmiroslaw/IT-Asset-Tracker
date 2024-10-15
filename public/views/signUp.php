<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="public/css/addDevice.css">
    <link rel="stylesheet" type="text/css" href="public/css/background.css">

    <script src="public/scripts/addUserForm.js" defer></script>
    <script src="public/scripts/validateUser.js" defer></script>
    <title><?php if(isset($title)){echo $title;}?></title>
</head>
<body>
<?php if (isset($user) && !empty($user)): ?>
    <?php $attributes = $user->getColumnMapping(); ?>

    <form action = '/signUp' method="POST" class = 'device-properties'>

        <?php foreach ($attributes as $attribute => $label): ?>

            <?php if ($attribute != "account_type" && $attribute != "id" && $attribute != "created_at"): ?>

                <div class = 'set <?php echo $attribute ?>'>
                        <span>
                            <?php echo $label ?>
                        </span>
                        <?php if ($attribute == "confirm_password" || $attribute == "password"): ?>

                            <input required type="password" name="<?php echo $attribute ?>"placeholder="click to enter">
                        <? else: ?>
                            <input required type="text" name="<?php echo $attribute ?>"placeholder="click to enter">
                        <?php endif;?>
                </div>
                    <span class='errorMessage' name = '<?php echo $attribute?>'>
                <?php if (isset($errors[$attribute])): ?>
                    <?php echo htmlspecialchars($errors[$attribute]); ?>
                <?php endif; ?>
                    </span>
            <?php endif; ?>

        <?php endforeach ?>

        <button  class = 'submitForm' type="submit">Create account</button>
    </form>

<?php endif; ?>

</body>
</html>
