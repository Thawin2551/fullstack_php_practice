<?php 
    session_start();
    include("config.php");

    $errors = [
        'login' => $_SESSION["login_error"] ?? '',
        'register' => $_SESSION["register_error"] ?? ''
    ];

    $activeForm = $_SESSION["active_form"] ?? 'login';
    session_unset();

    function showError($error) {
        return !empty($error) ? "<p class='error-message'>$error</p>" : '';
    }

    function isActiveForm($formName, $activeForm) {
        return $formName == $activeForm ? 'active' : '' ;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <!-- Register Form -->
        <div class="form-box" id="register-form" <?= isActiveForm('login', $activeForm) ?>"> 
            <form action="login_register.php" method="post" >
                <h1 class="register-text">Register</h1>
                <?= showError($errors["register"]) ?>
                <div class="form-control">
                    <div class="input-control">
                        <input type="text" name="name" placeholder="Name" required>
                        <input type="email" name="email" placeholder="Email" required>
                        <input type="password" name="password" placeholder="Password" required>
                        <select name="role" required>
                            <option value="">Select Role</option>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                        <p>Already a member ? Go to <a href="#" onclick="showForm('login-form')">Login</a> page</p>
                        <button type="submit" name="register">Register</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Login Form -->
        <div class="form-box <?= isActiveForm('login', $activeForm) ?>" id="login-form"> 
            <form action="login_register.php" method="post" >
                <h1 class="register-text">Login</h1>
                <?= showError($errors["login"]) ?>
                <div class="form-control">
                    <div class="input-control">
                        <input type="email" name="email" placeholder="Email" required>
                        <input type="password" name="password" placeholder="Password" required>                        
                        <p>Not a member yet ? Go to <a href="#" onclick="showForm('register-form')">Register</a> page</p>
                        <button type="submit" name="login">Login</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>