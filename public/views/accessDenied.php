<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="public/css/background.css"> 
    <link rel="stylesheet" type="text/css" href="public/css/menu.css"> 
    <script src="public/scripts/logout.js" defer></script>

    <title>Access denied</title>

    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f1f1f1;
        }

        h1 {
            font-size: 48px;
            color: red;
        }


    </style>

</head>
<body>

    <div class = "menu">    
            <h1>
                Hi, <?php if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {echo $_SESSION['user']['username'];} ?> !
            </h1>
            <button class = "logout">Logout</button>
    </div>

    <h1>Access Denied !</h1> 
</body>
</html>