<?php
session_start();
include "conn.php";

// 🔒 RESTRICT ACCESS (ONLY PATIENT)
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'patient') {
    header("Location: p_login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// GET PATIENT DATA
$query = mysqli_query($conn, "
    SELECT p.*, u.username 
    FROM patients p
    JOIN users u ON p.user_id = u.user_id
    WHERE p.user_id = '$user_id'
");

$patient = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/patient_layout.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

<!-- HEADER -->
<div class="header">
    <h1>Patient Panel</h1>
    <div class="user-info">
        Welcome, <?php echo $patient['name']; ?>
        <a href="logout.php" class="logout">Logout</a>
    </div>
</div>

<!-- Dashboard Cards -->
<div class="dashboard">

    <a href="doctor_display.php" class="card card-green">
        <i class="fa-solid fa-user-doctor"></i>
        <h3>Search Doctor</h3>
        <p>Find doctors by city & specialization</p>
    </a>

    <a href="appointment_booking.php" class="card card-blue">
        <i class="fa-solid fa-calendar-check"></i>
        <h3>Book Appointment</h3>
        <p>Schedule your visit</p>
    </a>

    <a href="my_appointments.php" class="card card-purple">
        <i class="fa-solid fa-list"></i>
        <h3>My Appointments</h3>
        <p>View your bookings</p>
    </a>

    <a href="patient_profile.php" class="card card-teal">
        <i class="fa-solid fa-user"></i>
        <h3>My Profile</h3>
        <p>Update your details</p>
    </a>

</div>

<!-- PROFILE SECTION -->
<div class="profile-container">

    <div class="profile-card">

        <!-- ICON -->
        <div class="profile-icon">
            <i class="fa fa-user"></i>
        </div>

        <h2 class="profile-name"><?php echo $patient['name']; ?></h2>
        <p class="profile-role">Patient</p>

        <!-- DETAILS -->
        <div class="profile-details">

            <div class="detail">
                <span>Email:</span>
                <p><?php echo $patient['email']; ?></p>
            </div>

            <div class="detail">
                <span>Phone:</span>
                <p><?php echo $patient['phone']; ?></p>
            </div>

            <div class="detail">
                <span>Age:</span>
                <p><?php echo $patient['age']; ?></p>
            </div>

            <div class="detail">
                <span>Gender:</span>
                <p><?php echo $patient['gender']; ?></p>
            </div>

            <div class="detail">
                <span>Address:</span>
                <p><?php echo $patient['address']; ?></p>
            </div>

        </div>

        <!-- EDIT BUTTON -->
        <a href="edit_patient_profile.php" class="btn-edit">
            <i class="fa fa-edit"></i> Edit Profile
        </a>

    </div>

</div>

<div class="footer">
    <p>© 2026 Health CARE Services | Patient Panel</p>
</div>

</body>
</html>