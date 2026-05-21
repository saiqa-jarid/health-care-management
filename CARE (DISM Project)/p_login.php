<?php
session_start();
include "conn.php";

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email' AND role='patient'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);

        if(password_verify($password, $user['password'])){

            $user_id = $user['user_id'];

            $p = mysqli_query($conn, "SELECT * FROM patients WHERE user_id='$user_id'");
            $patient = mysqli_fetch_assoc($p);

            $_SESSION['user'] = $patient['name'];
            $_SESSION['user_id'] = $user_id;
            $_SESSION['role'] = 'patient';

            header("Location: patient_dashboard.php");
            exit();

        } else {
            $error = "Wrong Password!";
        }
    } else {
        $error = "Patient account not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Patient Login</title>

<!-- CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <!-- <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/tooplate-style.css"> -->
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/nav-foot.css">
</head>

<body>

    <?php include "header.php"; ?>

<div class="login-wrapper">
<div class="form-container">
<form method="POST">

<h2><i class="fa-solid fa fa-user"></i> Patient Login</h2>

<?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

<div class="input-box">
<input type="email" name="email" placeholder="Email" required>
</div>

<div class="input-box">
<input type="password" id="password" name="password" placeholder="Password" required>
<i id="eye1" class="fa fa-eye" onclick="togglePassword('password','eye1')"></i>
</div>

<button name="login">Login</button>

<p>Don't have account? <a href="p_register.php">Register</a></p>

</form>
</div>
</div>

<?php include "footer.php"; ?>

<script>
function togglePassword(id, eye){
    let field = document.getElementById(id);
    let icon = document.getElementById(eye);

    if(field.type === "password"){
        field.type = "text";
        icon.classList.replace("fa-eye","fa-eye-slash");
    } else {
        field.type = "password";
        icon.classList.replace("fa-eye-slash","fa-eye");
    }
}
</script>

</body>
</html>