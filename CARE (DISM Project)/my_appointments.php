<?php
include "conn.php";
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'patient') {
    header("Location: p_login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$pq = mysqli_query($conn, "SELECT * FROM patients WHERE user_id='$user_id'");
$patient = mysqli_fetch_assoc($pq);
$patient_id = $patient['patient_id'];

$query = "SELECT a.*, d.name as doctor_name 
FROM appointments a
JOIN doctors d ON a.doctor_id = d.doctor_id
WHERE a.patient_id = '$patient_id'";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/patient_layout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

</body>

</html>


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


<!-- Appointments -->


<div class="table-container">
    <h2 class="appointment-title">My Appointments</h2>
    <table class="custom-table" border="1">


        <tr>
            <th>Doctor</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td data-label="Doctor"><?= $row['doctor_name'] ?></td>
                <td data-label="Date"><?= $row['appointment_date'] ?></td>
                <td data-label="Time"><?= $row['appointment_time'] ?></td>
                <td data-label="Status"><?= $row['status'] ?></td>

                <td data-label="Action">
                    <a href="?cancel=<?= $row['appointment_id'] ?>">Cancel</a>
                </td>
            </tr>
        <?php } ?>
    </table>

</div>

<?php
if (isset($_GET['cancel'])) {
    $id = $_GET['cancel'];
    mysqli_query($conn, "UPDATE appointments SET status='cancelled' WHERE appointment_id='$id'");
    header("Location: my_appointments.php");
}
?>