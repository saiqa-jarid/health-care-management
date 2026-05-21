<?php
include "conn.php";

if(isset($_POST['register'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Insert into users table
    $sql1 = "INSERT INTO users (username, email, password, role)
             VALUES ('$name','$email','$password','patient')";

    if(mysqli_query($conn,$sql1)){

        $user_id = mysqli_insert_id($conn);

        // Insert into patients table
        $sql2 = "INSERT INTO patients (user_id, name, email, phone, address, age, gender)
                 VALUES ('$user_id','$name','$email','$phone','$address','$age','$gender')";

        if(mysqli_query($conn,$sql2)){
            echo "<script>
                    alert('Registered Successfully');
                    window.location.href = 'p_login.php';
                  </script>";
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }

    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Hospital Register</title>

<!-- CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <!-- <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/tooplate-style.css"> -->
    <link rel="stylesheet" href="css/p_register.css">
    <link rel="stylesheet" href="css/nav-foot.css">
    
</head>

<body>

    <?php include "header.php"; ?>

<div class="register-wrapper">

<div class="card shadow-lg p-4">

<h3 class="text-center mb-3">🏥 Patient Registration</h3>

<form method="POST" onsubmit="return checkPassword()">

<label>Full Name</label>
<input class="form-control" type="text" name="name" placeholder="Enter your Full Name" required>

<label>Email</label>
<input class="form-control" type="email" name="email" placeholder="Enter your Email" required>

<label>Phone</label>
<input class="form-control" type="text" name="phone" placeholder="Enter your Phone" required>

<label>Address</label>
<textarea class="form-control" name="address" placeholder="Enter your Address" required></textarea>

<div class="row">
<div class="col">
<label>Age</label>
<input class="form-control" type="number" name="age" required>
</div>

<div class="col">
<label>Gender</label>
<select class="form-select" name="gender" required>
<option>Male</option>
<option>Female</option>
<option>Other</option>
</select>
</div>
</div>

<br>

<!-- PASSWORD -->
<label>Password</label>
<div class="position-relative">
    <input class="form-control" type="password" id="password" name="password" required>
    <span class="eye" onclick="togglePassword('password','eye1')">
        <i id="eye1" class="fa fa-eye"></i>
    </span>
</div>

<br>

<!-- CONFIRM PASSWORD -->
<label>Confirm Password</label>
<div class="position-relative">
    <input class="form-control" type="password" id="confirm_password" required>
    <span class="eye" onclick="togglePassword('confirm_password','eye2')">
        <i id="eye2" class="fa fa-eye"></i>
    </span>
</div>

<p id="error" style="color:red; display:none;">Passwords do not match</p>

<button class="btn btn-primary w-100 mt-3" name="register">Register</button>

</form>

</div>
</div>


<?php include "footer.php"; ?>

<script>
// show/hide password
function togglePassword(fieldId, iconId){
    var field = document.getElementById(fieldId);
    var icon = document.getElementById(iconId);

    if(field.type === "password"){
        field.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        field.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}

// password match check
function checkPassword(){
    var p1 = document.getElementById("password").value;
    var p2 = document.getElementById("confirm_password").value;
    var error = document.getElementById("error");

    if(p1 !== p2){
        error.style.display = "block";
        return false;
    }
    return true;
}
</script>

</body>
</html>