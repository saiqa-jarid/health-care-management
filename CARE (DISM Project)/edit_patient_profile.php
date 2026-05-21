<?php
session_start();
include "conn.php";

// 🔒 RESTRICT ACCESS
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'patient') {
    header("Location: p_login.php");
    exit();
}

$user_id = intval($_SESSION['user_id']);

// GET PATIENT DATA
$query = mysqli_query($conn, "
    SELECT * FROM patients WHERE user_id = '$user_id'
");
$patient = mysqli_fetch_assoc($query);

// UPDATE LOGIC
if (isset($_POST['update'])) {

    $name    = mysqli_real_escape_string($conn, $_POST['name']);
    $email   = mysqli_real_escape_string($conn, $_POST['email']);
    $phone   = mysqli_real_escape_string($conn, $_POST['phone']);
    $age     = intval($_POST['age']);
    $gender  = mysqli_real_escape_string($conn, $_POST['gender']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // ✅ CHECK DUPLICATE EMAIL
    $check = mysqli_query($conn, "
        SELECT * FROM users 
        WHERE email='$email' AND user_id!='$user_id'
    ");

    if (mysqli_num_rows($check) > 0) {

        echo "<script>alert('Email already exists');</script>";

    } else {

        // ✅ RUN UPDATE ONLY IF EMAIL IS UNIQUE
        mysqli_query($conn, "
            UPDATE patients 
            SET name='$name', email='$email', phone='$phone', age='$age', gender='$gender', address='$address'
            WHERE user_id='$user_id'
        ");

        mysqli_query($conn, "
            UPDATE users 
            SET email='$email'
            WHERE user_id='$user_id'
        ");

        header("Location: edit_patient_profile.php?updated=1");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/patient_layout.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
</head>

<body>

<div class="header">
    <h1>Edit Profile</h1>
    <div class="user-info">
        <a href="patient_profile.php" class="logout">Back</a>
    </div>
</div>

<div class="profile-container">

    <form method="POST" class="profile-card" onsubmit="return validateForm()">

        <h2 class="profile-name">Update Profile</h2>

        <!-- NAME -->
        <input type="text" id="name" name="name" value="<?php echo $patient['name']; ?>" placeholder="Name">
        <span class="error" id="nameError"></span>

        <!-- EMAIL -->
        <input type="text" id="email" name="email" value="<?php echo $patient['email']; ?>" placeholder="Email">
        <span class="error" id="emailError"></span>

        <!-- PHONE -->
        <input type="text" id="phone" name="phone" value="<?php echo $patient['phone']; ?>" placeholder="Phone">
        <span class="error" id="phoneError"></span>

        <!-- AGE -->
        <input type="number" id="age" name="age" value="<?php echo $patient['age']; ?>" placeholder="Age">

        <!-- GENDER -->
        <select name="gender" id="gender">
            <option value="">Select Gender</option>
            <option value="Male" <?php if($patient['gender']=="Male") echo "selected"; ?>>Male</option>
            <option value="Female" <?php if($patient['gender']=="Female") echo "selected"; ?>>Female</option>
        </select>

        <!-- ADDRESS -->
        <textarea name="address" id="address" placeholder="Address"><?php echo $patient['address']; ?></textarea>

        <!-- BUTTON -->
        <button type="submit" name="update" class="btn-edit">Update Profile</button>

    </form>

</div>

<div id="toast" class="toast"></div>



<script>
function validateForm(){

    let valid = true;

    let name = document.getElementById("name").value.trim();
    let email = document.getElementById("email").value.trim();
    let phone = document.getElementById("phone").value.trim();

    // ✅ EMPTY CHECK (ADD HERE)
    if(name === "" || email === "" || phone === ""){
        alert("All fields are required");
        return false;
    }

    let nameRegex = /^[A-Za-z ]{3,}$/;
    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    let phoneRegex = /^03[0-9]{9}$/;

    // CLEAR ERRORS
    document.getElementById("nameError").innerHTML = "";
    document.getElementById("emailError").innerHTML = "";
    document.getElementById("phoneError").innerHTML = "";

    if (!nameRegex.test(name)) {
        document.getElementById("nameError").innerHTML = "Enter valid name (min 3 letters)";
        valid = false;
    }

    if (!emailRegex.test(email)) {
        document.getElementById("emailError").innerHTML = "Enter valid email";
        valid = false;
    }

    if (!phoneRegex.test(phone)) {
        document.getElementById("phoneError").innerHTML = "Enter valid phone (03XXXXXXXXX)";
        valid = false;
    }

    return valid;
}
</script>
<script>
function showToast(message) {
    let toast = document.getElementById("toast");
    toast.innerHTML = message;
    toast.classList.add("show");

    // 🔁 REDIRECT AFTER 2 SECONDS
    setTimeout(() => {
        window.location.href = "patient_profile.php";
    }, 2000);
}

// CHECK URL PARAM
window.onload = function() {
    const params = new URLSearchParams(window.location.search);
    if (params.get("updated") === "1") {
        showToast("Profile updated successfully!");
    }
}
</script>

</body>
</html>