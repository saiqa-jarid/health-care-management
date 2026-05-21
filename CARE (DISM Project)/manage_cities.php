<?php
session_start();
include "conn.php";

// Restrict access
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: a_login.php");
    exit();
}


/* ADD CITY */
if (isset($_POST['add_city'])) {
    $city = trim(mysqli_real_escape_string($conn, $_POST['city_name']));

    if ($city != "") {
        mysqli_query($conn, "INSERT INTO cities(city_name) VALUES('$city')");
        // header("Location: manage_cities.php");
        header("Location: manage_cities.php?success=1");
        exit();
    }
}

/* DELETE CITY */
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $check = mysqli_query($conn, "SELECT city_id FROM doctors WHERE city_id='$id'");

    if (mysqli_num_rows($check) > 0) {
        echo "<script>
            alert('Cannot delete: City is assigned to doctors');
            window.location='manage_cities.php';
        </script>";
        exit();
    }

    mysqli_query($conn, "DELETE FROM cities WHERE city_id='$id'");
    header("Location: manage_cities.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM cities ORDER BY city_id DESC");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Manage Cities - Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
                    <h2><i class="fa-solid fa-city"></i> City Management</h2>
                    <p>Manage all system cities</p>
                </div>

                <!-- ADD CITY -->
                <div class="card">
                    <form method="POST" class="form-box">
                        <h2> Add City </h2> <br><br>
                        <div class="form-row">
                            <div class="form-group">
                                <label for=""> City Name </label>
                                <input type="text" name="city_name" required>
                            </div>
                        </div>

                        <button type="submit" name="add_city" class="btn add">
                            <i class="fa fa-plus"></i> Add
                        </button>
                    </form>
                </div>

                <!-- TABLE -->
                <div class="card table-card">
                    <h2> All Cities </h2>

                    <div class="table-responsive">
                        <table border="1">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>City</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td data-label="ID"><?= $row['city_id'] ?></td>
                                        <td data-label="City"><?= htmlspecialchars($row['city_name']) ?></td>
                                        <td data-label="Action">

                                            <a href="?delete=<?= $row['city_id'] ?>"
                                                class="btn delete"
                                                onclick="return confirm('Delete this city?')">

                                                <!-- <i class="fa fa-trash"></i> -->
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

    <!-- Toast Message -->
    <div id="toast" class="toast"></div>

    <?php include "admin_footer.php"; ?>


    <!-- Toast JS -->
    <script>
        <?php if (isset($_GET['success'])) { ?>
            window.onload = function() {
                let toast = document.getElementById("toast");

                toast.innerText = "City added successfully ✅";
                toast.style.display = "block";

                setTimeout(() => {
                    window.location = "manage_cities.php";
                }, 2000);
            }
        <?php } ?>
    </script>
    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("active");
        }
    </script>

</body>

</html>