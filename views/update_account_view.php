<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../public/favicon.svg" type="image/svg+xml">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/account.css">

</head>

<body>
    <main>
        <div class="container-xl px-4 mt-4" s>
            <!-- Account page navigation-->
            <nav class="nav nav-borders">
                <a class="nav-link active ms-0" href="/pages/update_account.php" target="__blank">Profile</a>
                <a class="nav-link" href="/pages/home.php" target="__blank">Home</a>
                <a class="nav-link" href="/pages/history.php" target="__blank">History</a>
                <a class="nav-link" href="/pages/watchlist.php" target="__blank">My List</a>
                <a class="nav-link" href="/pages/logout.php">Logout</a>
            </nav>
            <hr class="mt-0 mb-4">
            <form action=<?php echo $_SERVER["PHP_SELF"] ?> method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-xl-4">
                        <!-- Profile picture card-->
                        <div class="card mb-4 mb-xl-0">
                            <div class="card-header">Profile Picture</div>
                            <div class="card-body text-center">
                                <!-- Profile picture image-->
                                <img class="img-account-profile rounded-circle mb-2"
                                    src="<?php echo "/public/storage/" . $user['profile_pic'] ?>" alt="">
                                <!-- Profile picture help block-->
                                <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                                <div class="input-box">

                                    <input type="file" name="photo" accept="image/*">
                                    <?php if (!empty($errors["photo"])): ?>
                                        <p class="text-danger"><?php echo $errors["photo"]; ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <!-- Account details card-->
                        <div class="card mb-4">
                            <div class="card-header">Account Details
                                <?php if (!empty($errors["update"])): ?>
                                    <span class="text-danger"><?php echo $errors["update"]; ?></>
                                <?php endif; ?>
                            </div>
                            <div class="card-body">
                                <!-- Form Group (username)-->
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputUsername">Username</label>
                                    <input class="form-control" id="inputUsername" type="text" name="username"
                                        value="<?php echo $user['username'] ?>">
                                    <?php if (!empty($errors["username"])): ?>
                                        <p class="text-danger"><?php echo $errors["username"]; ?></p>
                                    <?php endif; ?>

                                </div>
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputEmailAddress">Email address</label>
                                    <input class="form-control" id="inputEmailAddress" type="email" name="email"
                                        value="<?php echo $user['email'] ?>">
                                    <?php if (!empty($errors["email"])): ?>
                                        <p class="text-danger"><?php echo $errors["email"]; ?></p>
                                    <?php endif; ?>
                                </div>

                                <div class="row gx-3 mb-3">
                                    <!-- Form Group (full name)-->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputFullName">Full name</label>
                                        <input class="form-control" id="inputFullName" type="text" name="fullName"
                                            value="<?php echo $user['full_name']; ?>">
                                        <?php if (!empty($errors["fullName"])): ?>
                                            <p class="text-danger"><?php echo $errors["fullName"]; ?></p>
                                        <?php endif; ?>
                                    </div>
                                    <!-- Form Group (gender)-->
                                    <div class="col-md-6">
                                        <label class="small mb-1 d-block">Gender</label>
                                        <div class="d-flex"
                                            style="margin-top: 10px; display: flex;justify-content: space-around;">
                                            <div class="form-check me-3">
                                                <input class="form-check-input" type="radio" required name="gender"
                                                    id="genderMale" value="male" <?php if ($user['gender'] == "male")
                                                        echo "checked"; ?>>
                                                <label class="form-check-label" for="genderMale">Male</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" required name="gender"
                                                    id="genderFemale" value="female" <?php if ($user['gender'] == "female")
                                                        echo "checked"; ?>>
                                                <label class="form-check-label" for="genderFemale">Female</label>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if (!empty($errors["gender"])): ?>
                                        <p class="text-danger"><?php echo $errors["gender"]; ?></p>
                                    <?php endif; ?>
                                </div>




                                <!-- Form Row        -->
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group (organization name)-->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputOrgName">Old Password</label>
                                        <input class="form-control" id="inputOrgName" type="password"
                                            name="Oldpassword">
                                        <?php if (!empty($errors["Oldpassword"])): ?>
                                            <p class="text-danger"><?php echo $errors["Oldpassword"]; ?></p>
                                        <?php endif; ?>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputBirthday">Created At</label>
                                        <input class="form-control" id="inputBirthday" type="text" name="created_at"
                                            value="<?php echo $user['created_at'] ?>" disabled>
                                    </div>
                                </div>

                                <!-- Form Row-->
                                <div class="row gx-3 mb-3">

                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputPhone">New Password</label>
                                        <input class="form-control" id="inputPhone" type="password" name="Newpassword">
                                        <?php if (!empty($errors["Newpassword"])): ?>
                                            <p class="text-danger"><?php echo $errors["Newpassword"]; ?></p>
                                        <?php endif; ?>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputBirthday">Last Update</label>
                                        <input class="form-control" id="inputBirthday" type="text" name="updated_at"
                                            value="<?php echo $user['updated_at'] ?>" disabled>
                                    </div>
                                </div>
                                <!-- Save changes button-->
                                <button class="btn btn-primary" type="submit">Save changes</button>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.0.0-beta2/js/bootstrap.bundle.min.js"></script>

</body>

</html>