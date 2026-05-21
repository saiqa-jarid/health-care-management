
<?php
session_start();
include "conn.php";

// 🔒 Restrict access
if(!isset($_SESSION['user']) || $_SESSION['role'] != 'patient'){
    header("Location: p_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Patient Dashboard</title>

<link rel="stylesheet" href="css/patient_layout.css">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>

<!-- Header -->
<div class="header">
    <h1>🏥 Patient Dashboard</h1>
    <div class="user-info">
        Welcome, <b><?php echo $_SESSION['user']; ?></b>
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
<div class="footer">
    <p>© 2026 Health CARE Services | Patient Panel</p>
</div>
<script>
document.querySelectorAll('.card').forEach(card => {
    card.addEventListener('click', function(e) {
        const circle = document.createElement("span");
        circle.classList.add("ripple");

        const rect = this.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);

        circle.style.width = circle.style.height = size + "px";
        circle.style.left = (e.clientX - rect.left - size / 2) + "px";
        circle.style.top = (e.clientY - rect.top - size / 2) + "px";

        this.appendChild(circle);

        setTimeout(() => circle.remove(), 600);
    });
});
</script>
</body>
</html>
