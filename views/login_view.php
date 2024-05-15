<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
    background-color: black;
    color: white;
    font-family: Arial, sans-serif;
}

.container {
    width: 300px;
    margin: 0 auto;
    padding: 20px;
    background-color: rgba(0, 0, 0, 0.8);
    border-radius: 5px;
    margin-top: 100px;
}

.container h2 {
    text-align: center;
}

.container label {
    display: block;
    margin-bottom: 10px;
}

.container input[type="text"],
.container input[type="password"] {
    width: 100%;
    padding: 5px;
    margin-bottom: 10px;
}

.container input[type="submit"] {
    width: 100%;
    padding: 10px;
    background-color: #cead1d;
    color: white;
    border: none;
    cursor: pointer;
   
}

.container input[type="submit"]:hover {
    background-color: #45a049;
}

.error-message {
    color: #ff0000;
    margin-bottom: 10px;
}
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form method="POST" action="/pages/login.php">
            <label for="identifier">Email or Username:</label>
            <input type="text" name="identifier" id="identifier" required><br>
            <?php if (!empty($errors["identifier"])): ?>
                <p class="error-message"><?php echo $errors["identifier"]; ?></p>
            <?php endif; ?>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required><br>
            <?php if (!empty($errors["password"])): ?>
                <p class="error-message"><?php echo $errors["password"]; ?></p>
            <?php endif; ?>

            <?php if (!empty($errors["login"])): ?>
                <p class="error-message"><?php echo $errors["login"]; ?></p>
            <?php endif; ?>

            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>