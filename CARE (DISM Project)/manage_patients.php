<?php
session_start();
include "conn.php";

// Restrict access
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: a_login.php");
    exit();
}

// DELETE PATIENT
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $res = mysqli_query($conn, "SELECT user_id FROM patients WHERE patient_id='$id'");
    $row = mysqli_fetch_assoc($res);
    $user_id = $row['user_id'];

    mysqli_query($conn, "DELETE FROM patients WHERE patient_id='$id'");
    mysqli_query($conn, "DELETE FROM users WHERE user_id='$user_id'");

    header("Location: manage_patients.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Patients</title>

    <!-- SAME CSS STRUCTURE AS manage_cities -->
    <!-- <link rel="stylesheet" href="css/manage_cities.css"> -->
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
                    <h2><i class="fa-solid fa-user-injured"></i> Patient Management</h2>
                    <p>Manage all registered patients</p>
                </div>

                <!-- TABLE -->
                <div class="card table-card">
                    <h2> All Patients </h2>

                    <div class="table-responsive">
                        <table border="1">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Gender</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $result = mysqli_query($conn, "
                    SELECT patients.*, users.email 
                    FROM patients
                    JOIN users ON patients.user_id = users.user_id
                ");

                                while ($row = mysqli_fetch_assoc($result)) {
                                ?>

                                    <tr>
                                        <td data-label="ID"><?= $row['patient_id']; ?></td>
                                        <td data-label="Name"><?= htmlspecialchars($row['name']); ?></td>
                                        <td data-label="Email"><?= htmlspecialchars($row['email']); ?></td>
                                        <td data-label="Phone"><?= $row['phone']; ?></td>
                                        <td data-label="Gender"><?= $row['gender']; ?></td>
                                        <td data-label="Address"><?= htmlspecialchars($row['address']); ?></td>

                                        <td data-label="Action">
                                            <a href="?delete=<?= $row['patient_id']; ?>"
                                                class="btn delete"
                                                onclick="return confirm('Delete this patient?')" class="btn delete">
                                                <i class="fa fa-trash fa-2x"></i>
                                            </a>
                                        </td>
                                    </tr>

                                <?php } ?>
                            </tbody>

                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php include "admin_footer.php"; ?>

    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("active");
        }
    </script>

</body>

</html>