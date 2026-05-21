<?php
session_start();
include "conn.php";

// Restrict access
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: a_login.php");
    exit();
}

// ADD DISEASE
if (isset($_POST['add'])) {

    $name = $_POST['name'];
    $symptoms = $_POST['symptoms'];
    $prevention = $_POST['prevention'];
    $cure = $_POST['cure'];

    // IMAGE UPLOAD
    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    $imageName = time() . "_" . $image;
    move_uploaded_file($tmp, "uploads/diseases/" . $imageName);

    $query = "INSERT INTO diseases (name, image, symptoms, prevention, cure)
              VALUES ('$name','$imageName','$symptoms','$prevention','$cure')";

    if (mysqli_query($conn, $query)) {
        header("Location: manage_diseases.php?success=1");
        exit();
    } else {
        echo "Insert Error: " . mysqli_error($conn);
    }
}

// DELETE
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    // delete image also
    $res = mysqli_query($conn, "SELECT image FROM diseases WHERE disease_id=$id");
    $row = mysqli_fetch_assoc($res);

    $img = "images/" . $row['image'];
    if (file_exists($img)) {
        unlink($img);
    }

    mysqli_query($conn, "DELETE FROM diseases WHERE disease_id=$id");

    header("Location: manage_diseases.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Diseases - Admin Panel</title>

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
                    <h2><i class="fa-solid fa-virus"></i> Disease Management</h2>
                    <p>Manage all diseases information</p>
                </div>

                <!-- ADD DISEASE -->
                <section>
                    <div class="card">

                        <form method="POST" enctype="multipart/form-data" class="form-box" id="add_disease">
                            <h2>Add Disease</h2>

                            <div class="form-row">
                                <div class="form-group">
                                    <!-- IMAGE -->
                                    <label for="">Image</label>
                                    <input type="file" name="image" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Disease Name </label>
                                    <input type="text" name="name" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for=""> Symptoms </label>
                                    <textarea name="symptoms" placeholder="Symptoms" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for=""> Prevention </label>
                                    <textarea name="prevention" placeholder="Prevention" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for=""> Treatment / Cure</label>
                                    <textarea name="cure" placeholder="Cure" required></textarea>
                                </div>
                            </div>



                            <button type="submit" name="add" class="btn add">
                                <i class="fa fa-plus"></i> Add Disease
                            </button>

                        </form>
                    </div>

                </section>

            </div>


            <?php
            $query = "SELECT * FROM diseases ORDER BY disease_id DESC";
            $result = mysqli_query($conn, $query);
            ?>

            <!-- VIEW DISEASES -->
            <section>
                <div class="card">

                    <div class="table-responsive">
                        <table border="1">

                            <h2>All Diseases</h2>

                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Symptoms</th>
                                <th>Prevention</th>
                                <th>Cure</th>
                                <th>Actions</th>
                            </tr>

                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>

                                <tr>
                                    <td><?php echo $row['disease_id']; ?></td>
                                    <td><?php echo $row['name']; ?></td>

                                    <td>
                                        <img src="uploads/diseases/<?php echo $row['image']; ?>" width="50">
                                    </td>

                                    <td><?php echo $row['symptoms']; ?></td>
                                    <td><?php echo $row['prevention']; ?></td>
                                    <td><?php echo $row['cure']; ?></td>

                                    <td>
                                        <!-- EDIT -->
                                        <a href="update_disease.php?id=<?php echo $row['disease_id']; ?>" class="btn edit">
                                            <i class="fa fa-edit fa-2x"></i>
                                        </a>

                                        <!-- DELETE -->
                                        <a href="manage_diseases.php?delete=<?php echo $row['disease_id']; ?>"
                                            onclick="return confirm('Delete this disease?')" class="btn delete">
                                            <i class="fa fa-trash fa-2x"></i>
                                        </a>
                                    </td>
                                </tr>

                            <?php } ?>

                        </table>

                    </div>
                </div>
            </section>

        </div>
    
    </div>

    <!-- Toast Message -->
    <div id="toast" class="toast"></div>


    <script>
        <?php if (isset($_GET['success'])) { ?>
            window.onload = function() {
                let toast = document.getElementById("toast");

                toast.innerText = "Disease added successfully ✅";
                toast.style.display = "block";

                setTimeout(() => {
                    window.location = "manage_diseases.php";
                }, 2000);
            }
        <?php } ?>
    </script>
    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("active");
        }
    </script>

    <?php include "admin_footer.php"; ?>

</body>

</html>