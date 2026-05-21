<?php
session_start();
include "conn.php";

// Auth check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'doctor') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get doctor
$dq = mysqli_query($conn, "SELECT * FROM doctors WHERE user_id='$user_id'");
$doctor = mysqli_fetch_assoc($dq);
$doctor_id = $doctor['doctor_id'];

// ADD AVAILABILITY
if (isset($_POST['add'])) {
    $day = $_POST['day'];
    $start = $_POST['start_time'];
    $end = $_POST['end_time'];

    $insert = "INSERT INTO doctor_availability (doctor_id, day, start_time, end_time)
               VALUES ('$doctor_id', '$day', '$start', '$end')";
    mysqli_query($conn, $insert);

    header("Location: set_availability.php");
    exit();
}

// DELETE
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM doctor_availability WHERE id='$id'");
    header("Location: set_availability.php");
    exit();
}

// FETCH DATA
$result = mysqli_query($conn, "SELECT * FROM doctor_availability WHERE doctor_id='$doctor_id'");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Availability</title>

    <link rel="stylesheet" href="css/doctor_layout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    
</head>

<body>

    <div class="layout">

        <?php include "doctor_sidebar.php"; ?>

        <div class="main-content">

            <!-- <div class="header">
                <h3>Page Title</h3>
            </div> -->
            <?php include "doctor_header.php"; ?>

            <div class="dashboard">

                <h2>Set Availability</h2>
                <p>Manage your available days and time slots</p>

                <!-- CARDS -->
                <div class="cards">

                    <div class="card pastel-blue">
                        <i class="fa fa-calendar"></i>
                        <p>Add available days</p>
                    </div>

                    <div class="card pastel-green">
                        <i class="fa fa-clock"></i>
                        <p>Set time slots</p>
                    </div>

                    <div class="card pastel-purple">
                        <i class="fa fa-user-doctor"></i>
                        <p>Control appointments</p>
                    </div>

                </div>

                <!-- ADD FORM -->
                <div class="form-box">

                    <form method="POST">
                        <select name="day" required>
                            <option value="">Select Day</option>
                            <option>Monday</option>
                            <option>Tuesday</option>
                            <option>Wednesday</option>
                            <option>Thursday</option>
                            <option>Friday</option>
                            <option>Saturday</option>
                            <option>Sunday</option>
                        </select>

                        <label>Start Time</label>
                        <input type="time" name="start_time" required>

                        <label>End Time</label>
                        <input type="time" name="end_time" required>

                        <button type="submit" name="add" class="add-btn">
                            <i class="fa fa-plus"></i> Add Availability
                        </button>
                    </form>

                </div>

                <!-- TABLE -->
                <div class="table-container">

                    <h3>Your Availability</h3>

                    <table>
                        <tr>
                            <th>Day</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Action</th>
                        </tr>

                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?= $row['day'] ?></td>
                                <td><?= $row['start_time'] ?></td>
                                <td><?= $row['end_time'] ?></td>
                                <td>
                                    <a class="delete-btn" href="?delete=<?= $row['id'] ?>">
                                        <i class="fa fa-trash fa-2x"></i>
                                    </a>
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