<?php
session_start();
include "conn.php";

// Auth check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'doctor') {
    header("Location: d_login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get doctor
$dq = mysqli_query($conn, "SELECT * FROM doctors WHERE user_id='$user_id'");
$doctor = mysqli_fetch_assoc($dq);
$doctor_id = $doctor['doctor_id'];

// Handle actions FIRST
if (isset($_GET['approve'])) {
    $id = $_GET['approve'];
    mysqli_query($conn, "UPDATE appointments SET status='approved' WHERE appointment_id='$id'");
    header("Location: view_appointments.php");
    exit();
}

if (isset($_GET['cancel'])) {
    $id = $_GET['cancel'];
    mysqli_query($conn, "UPDATE appointments SET status='cancelled' WHERE appointment_id='$id'");
    header("Location: view_appointments.php");
    exit();
}

// Fetch appointments
$query = "SELECT a.*, p.name as patient_name 
FROM appointments a
JOIN patients p ON a.patient_id = p.patient_id
WHERE a.doctor_id = '$doctor_id'";

$result = mysqli_query($conn, $query);

// Count stats
$total = mysqli_num_rows($result);

mysqli_data_seek($result, 0); // reset pointer
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments</title>

    <link rel="stylesheet" href="css/doctor_layout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* TABLE DESIGN */
        .table-container {
            margin-top: 20px;
            background: #fff;
            padding: 20px;
            border-radius: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            background: #e0e7ff;
            padding: 10px;
            text-align: left;
        }

        table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        /* STATUS COLORS */
        .status {
            padding: 5px 10px;
            border-radius: 8px;
            font-size: 12px;
        }

        .approved {
            background: #d1fae5;
        }

        .pending {
            background: #fef3c7;
        }

        .cancelled {
            background: #fee2e2;
        }

        /* BUTTONS */
        .action-btn {
            padding: 5px 10px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 12px;
            margin-right: 5px;
        }

        .approve-btn {
            background: #10b981;
            color: white;
        }

        .cancel-btn {
            background: #ef4444;
            color: white;
        }
    </style>
</head>

<body>

    <div class="layout">

        <?php include "doctor_sidebar.php"; ?>

        <div class="main-content">

            <!-- <div class="header">
                <h3>Doctor Panel</h3>
            </div> -->
            <?php include "doctor_header.php"; ?>

            <div class="dashboard">

                <h2>Appointments</h2>
                <p>Manage your patient bookings</p>

                <!-- CARDS -->
                <div class="cards">

                    <div class="card pastel-blue">
                        <i class="fa fa-calendar"></i>
                        <h3><?php echo $total; ?></h3>
                        <p>Total Appointments</p>
                    </div>

                    <div class="card pastel-green">
                        <i class="fa fa-check"></i>
                        <p>Approve or manage requests</p>
                    </div>

                    <div class="card pastel-purple">
                        <i class="fa fa-clock"></i>
                        <p>Track your schedule</p>
                    </div>

                </div>

                <!-- TABLE -->
                <div class="table-container">

                    <table>
                        <tr>
                            <th>Patient</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>

                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?= $row['patient_name'] ?></td>
                                <td><?= $row['appointment_date'] ?></td>
                                <td><?= $row['appointment_time'] ?></td>

                                <td>
                                    <span class="status <?= $row['status'] ?>">
                                        <?= ucfirst($row['status']) ?>
                                    </span>
                                </td>

                                <td>
                                    <div class="action-buttons">
                                        <a class="action-btn approve-btn" href="?approve=<?= $row['appointment_id'] ?>">Approve</a>
                                        <a class="action-btn cancel-btn" href="?cancel=<?= $row['appointment_id'] ?>">Cancel</a>
                                    </div>
                                </td>

                            </tr>
                        <?php } ?>

                    </table>

                </div>

            </div>

            <?php include "doctor_footer.php"; ?>

        </div>
    </div>

    <!-- Hamburger Toggle JS -->
    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("active");
        }
    </script>

</body>

</html>