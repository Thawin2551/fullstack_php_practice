    <?php 
        session_start();
        include("config.php");

        if(isset($_POST["register"])) {
            $name = $_POST["name"];
            $email = $_POST["email"];
            $raw_password = $_POST["password"];
            $password = password_hash($raw_password, PASSWORD_DEFAULT);
            $role = $_POST["role"];

            $checkEmail = $connection -> query("SELECT email FROM users WHERE email = '$email'");
            if ($checkEmail->num_rows > 0) { // check ว่ามี email ไหนที่สมัครไปแล้วบ้าง
                $_SESSION["register_error"] = "This email has been registered ! ! !";
                $_SESSSION["active_form"] = "register";
            } else {
                $connection-> query("INSERT INTO users (name, email, password, role) VALUES ('{$name}', '{$email}', '{$password}', '{$role}')");
            }
            header("location: " . $BASE_URL . "/auth-page.php");
            exit();
        }

        if(isset($_POST["login"])) {
            $email = $_POST["email"];
            $password = $_POST["password"];
            
            $result = $connection -> query("SELECT * FROM users WHERE email ='$email'");

            if($result->num_rows > 0) {
                $user = $result -> fetch_assoc();
                if(password_verify($password,  $user["password"])) {
                    $_SESSION["name"] = $user["name"];
                    $_SESSION["email"] = $user["email"];
                    $_SESSION["role"] = $user["role"];
                    
                    // Check Role 
                    if ($user['role'] === 'admin') {
                        header("location: " . $BASE_URL . "/index.php");
                    } else {
                        header("location: " . $BASE_URL . "/product-list.php");
                    }
                    exit();
                }
            }
            $_SESSION["login_error"] = "Email/Password may be Incorrect";
            $_SESSION["active_form"] = "login";
            header("location: " . $BASE_URL . "/auth-page.php");
            exit();
        }
    ?>