<?php
session_start();
include "conn.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: a_login.php");
    exit();
}

$query = "SELECT a.*, 
d.name as doctor_name, 
p.name as patient_name 
FROM appointments a
JOIN doctors d ON a.doctor_id = d.doctor_id
JOIN patients p ON a.patient_id = p.patient_id";

$result = mysqli_query($conn, $query);




if (isset($_GET['approve'])) {
    mysqli_query($conn, "UPDATE appointments SET status='approved' WHERE appointment_id=" . $_GET['approve']);
    header("Location: manage_appointments.php");
}

if (isset($_GET['cancel'])) {
    mysqli_query($conn, "UPDATE appointments SET status='cancelled' WHERE appointment_id=" . $_GET['cancel']);
    header("Location: manage_appointments.php");
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Stylesheet -->
    <link rel="stylesheet" href="css/admin_layout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>

    <div class="admin-container">
        <?php include "admin_sidebar.php"; ?>
        <div class="main-content">

            <div class="content-area">

                <!-- HEADER -->
                <div class="header">
                    <h2><i class="fa-solid fa-calendar-check"></i> Appointment Management</h2>
                    <p>Manage all appointments</p>
                </div>

                <div class="card">


                    <h2>All Appointments (Admin)</h2>

                    <div class="table-responsive">

                        <table border="1">
                            <tr>
                                <th>Doctor</th>
                                <th>Patient</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>

                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?= $row['doctor_name'] ?></td>
                                    <td><?= $row['patient_name'] ?></td>
                                    <td><?= $row['appointment_date'] ?></td>
                                    <td><?= $row['appointment_time'] ?></td>
                                    <td><?= $row['status'] ?></td>

                                    <td>
                                        <a href="?approve=<?= $row['appointment_id'] ?>" class="action-btn approve-btn">Approve</a> |
                                        <a href="?cancel=<?= $row['appointment_id'] ?>" class="action-btn cancel-btn">Cancel</a>

                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("active");
        }
    </script>

    <?php include "admin_footer.php"; ?>



</body>

</html>