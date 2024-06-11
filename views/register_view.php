<!DOCTYPE html>
<!-- Created By CodingLab - www.codinglabweb.com -->
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../public/css/register.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../public/favicon.svg" type="image/svg+xml">

</head>

<body>
    <div class="container">
        <div class="title">Registration</div>
        <div class="content">
            <form action=<?php echo $_SERVER["PHP_SELF"] ?> method="POST" enctype="multipart/form-data">
                <div class="user-details">
                    <div class="input-box">
                        <span class="details">Full Name</span>
                        <input type="text" placeholder="Enter your name" name="fullName" required value="<?php if (empty($errors["fullName"]) and isset($fullName)) {
                            echo $fullName;
                        } ?>">
                        <?php if (!empty($errors["fullName"])): ?>
                            <p class="error-message"><?php echo $errors["fullName"]; ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="input-box">
                        <span class="details">Username</span>
                        <input type="text" placeholder="Enter your username" name="username" required value="<?php if (empty($errors["username"]) and isset($username)) {
                            echo $username;
                        } ?>">
                        <?php if (!empty($errors["username"])): ?>
                            <p class="error-message"><?php echo $errors["username"]; ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="input-box">
                        <span class="details">Password</span>
                        <input type="password" placeholder="Enter your password" name="password" required>
                        <?php if (!empty($errors["password"])): ?>
                            <p class="error-message"><?php echo $errors["password"]; ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="input-box">
                        <span class="details">Email</span>
                        <input type="email" placeholder="Enter your email" name="email" required value="<?php if (empty($errors["email"]) and isset($email)) {
                            echo $email;
                        } ?>">
                        <?php if (!empty($errors["email"])): ?>
                            <p class="error-message"><?php echo $errors["email"]; ?></p>
                        <?php endif; ?>
                    </div>


                    <div class="input-box">
                        <span class="details">Confirm Password</span>
                        <input type="password" placeholder="Confirm your password" name="confirm_password" required>
                        <?php if (!empty($errors["confirm_password"])): ?>
                            <p class="error-message"><?php echo $errors["confirm_password"]; ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="input-box">
                    <span class="details" style=" font-size: 20px;font-weight: 500;">Profile Picture</span>
                    <input type="file" name="photo" required accept="image/*">
                    <?php if (!empty($errors["photo"])): ?>
                        <p class="error-message"><?php echo $errors["photo"]; ?></p>
                    <?php endif; ?>
                </div>
                <div class="gender-details">
                    <input type="radio" name="gender" id="dot-1" value="male" <?php if (empty($errors["gender"]) and isset($gender) and $gender == "male") {
                        echo "checked";
                    } ?>>
                    <input type="radio" name="gender" id="dot-2" value="female" <?php if (empty($errors["gender"]) and isset($gender) and $gender == "female") {
                        echo "checked";
                    } ?>>
                    <span class="gender-title">Gender</span>
                    <div class="category">
                        <label for="dot-1">
                            <span class="dot one"></span>
                            <span class="gender">Male</span>
                        </label>
                        <label for="dot-2">
                            <span class="dot two"></span>
                            <span class="gender">Female</span>
                        </label>
                    </div>
                </div>
                <?php if (!empty($errors["gender"])): ?>
                    <p class="error-message"><?php echo $errors["gender"]; ?></p>
                <?php endif; ?>
                <a href="/pages/login.php">Already have an account? Login</a>
                <div class="button">
                    <input type="submit" value="register">
                </div>
                <?php if (!empty($errors["register"])): ?>
                    <p class="error-message"><?php echo $errors["register"]; ?></p>
                <?php endif; ?>
                <a href="home.php">Home</a>
            </form>
        </div>
    </div>

</body>

</html>