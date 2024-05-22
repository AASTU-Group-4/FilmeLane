<!DOCTYPE html>
<html lang="en">

<head>
    <title>login</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../public/css/login.css">
    <link rel="shortcut icon" href="../public/favicon.svg" type="image/svg+xml">

</head>

<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form method="POST" action=<?php echo $_SERVER["PHP_SELF"] ?> >
        <h3>Login </h3>

        <label for="identifier">Username</label>
        <input type="email" name="identifier" id="identifier" placeholder="Email" required>
        <?php if (!empty($errors["identifier"])): ?>
            <p class="error-message"><?php echo $errors["identifier"]; ?></p>
        <?php endif; ?>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Password" required><br>

        <?php if (!empty($errors["password"])): ?>
            <p class="error-message"><?php echo $errors["password"]; ?></p>
        <?php endif; ?>

        <?php if (!empty($errors["login"])): ?>
            <p class="error-message"><?php echo $errors["login"]; ?></p>
        <?php endif; ?>
        <a href="register.php">Sign Up</a>
        <input type="submit" value="Login" class="butn">


    </form>
</body>

</html>