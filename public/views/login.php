<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="public/css/login.css">
    <link rel="stylesheet" type="text/css" href="public/css/background.css">
    <title>
        <?php if(isset($title)){echo $title;}?>
    </title>
</head>
<body>
    <div class = 'logo'>
        <img src="images/logo.jpg">
    </div>
    <div class = "login">
        
        <h1 id="title">IT Asset Tracker</h1>

        <form action="/login" method="POST" id = "loginForm">
            <input required type = "email" name = 'email' placeholder="email">
            <input required type = "password" name = 'password' placeholder="password">
            <div id = "message">
            <?php if (isset($message) && !empty($message)) {echo $message;} ?>
            </div>
            <button type="submit">log in</button>
        </form>
        <button class = "sign-up" type="submit" onclick="window.location.href='/signUp'">Sign up</button>
    </div>
</body>
</html>