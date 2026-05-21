<?php
session_start();
include "conn.php";

// Check doctor login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'doctor') {
    header("Location: login.php");
    exit();
}

// Get doctor info
$doctor_id = $_SESSION['user_id'];

$query = "SELECT * FROM doctors WHERE user_id = '$doctor_id'";
$result = mysqli_query($conn, $query);
$doctor = mysqli_fetch_assoc($result);

// Count appointments
$app_query = "SELECT COUNT(*) as total FROM appointments WHERE doctor_id = '{$doctor['doctor_id']}'";
$app_result = mysqli_query($conn, $app_query);
$app_data = mysqli_fetch_assoc($app_result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" href="css/doctor_layout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

    <div class="layout">

        <?php include "doctor_sidebar.php"; ?>

        <div class="main-content">

            <!-- <div class="header">
                <h3><?php echo $doctor['name']; ?>'s Panel</h3>
            </div> -->
            <?php include "doctor_header.php"; ?>

            <!-- DASHBOARD CONTENT -->
            <div class="dashboard">

                <h2>Welcome, <?php echo $doctor['name']; ?> 👋</h2>
                <p>Manage your appointments and availability</p>

                <div class="cards">

                    <div class="card pastel-blue">
                        <i class="fa fa-calendar-check"></i>
                        <h3><?php echo $app_data['total']; ?></h3>
                        <p>Total Appointments</p>
                    </div>

                    <div class="card pastel-green">
                        <i class="fa fa-user"></i>
                        <h3><?php echo $doctor['experience']; ?> yrs</h3>
                        <p>Experience</p>
                    </div>

                    <div class="card pastel-purple">
                        <i class="fa fa-stethoscope"></i>
                        <p><?php echo $doctor['specialization']; ?></p>
                        <p>Specialization</p>
                    </div>

                </div>

            </div>

            <?php include "doctor_footer.php"; ?>

        </div>

    </div>

    <!-- Hamburger JS -->
    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("active");
        }
    </script>

</body>

</html>