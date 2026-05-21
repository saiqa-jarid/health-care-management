<?php
include "conn.php";


// VALIDATE ID
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // security

    $res = mysqli_query($conn, "SELECT * FROM diseases WHERE disease_id=$id");

    if (mysqli_num_rows($res) > 0) {
        $data = mysqli_fetch_assoc($res);
    } else {
        echo "<script>alert('Invalid Disease ID'); window.location='manage_diseases.php';</script>";
        exit();
    }
} else {
    echo "<script>window.location='manage_diseases.php';</script>";
    exit();
}

// UPDATE
if (isset($_POST['update_disease'])) {
    $name = $_POST['name'];
    $symptoms = $_POST['symptoms'];
    $prevention = $_POST['prevention'];
    $cure = $_POST['cure'];

    // CHECK IMAGE
    if (!empty($_FILES['image']['name'])) {
        $custom_name = mysqli_real_escape_string($conn, $_POST['image_name']);
        $custom_name = preg_replace("/[^a-zA-Z0-9_-]/", "_", $custom_name);

        $file_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        // final name
        $new_image = $custom_name . "_" . time() . "." . $file_ext;
        $temp = $_FILES['image']['tmp_name'];

        // DELETE OLD IMAGE SAFELY
        $oldPath = "uploads/diseases/" . $data['image'];
        if (file_exists($oldPath)) {
            unlink($oldPath);
        }

        // UPLOAD NEW IMAGE
        move_uploaded_file($temp, "uploads/diseases/" . $new_image);

        // UPDATE WITH IMAGE
        mysqli_query($conn, "UPDATE diseases 
        SET name='$name', image='$new_image', symptoms='$symptoms', prevention='$prevention', cure='$cure'
        WHERE disease_id=$id");
    } else {
        // UPDATE WITHOUT IMAGE
        mysqli_query($conn, "UPDATE diseases 
        SET name='$name', symptoms='$symptoms', prevention='$prevention', cure='$cure'
        WHERE disease_id=$id");
    }

    $success = true;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Disease</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Stylesheet -->
    <link rel="stylesheet" href="css/admin_layout.css">
</head>

<body>

    <div class="admin-container">
        <?php include "admin_sidebar.php"; ?>
        <div class="main-content">


            <div class="content-area">

                <!-- HEADER -->
                <div class="header">
                    <h2> Diseases Management </h2>
                    <p>Update disease details</p>
                </div>

                <div class="card">

                    <!-- <a href="manage_diseases.php" class="btn" style="margin-bottom:10px;">
                ← Back
            </a> -->

                    <h2 class="title">Edit Disease</h2>

                    <form method="POST" enctype="multipart/form-data" class="form-box">

                        <div class="form-row">
                            <div class="form-group">
                                <label>Disease Name</label>
                                <input type="text" name="name" value="<?= $data['name'] ?>" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group" style="width:100%;">
                                <label>Image Name</label>
                                <input type="text" id="imageName" name="image_name"
                                    value="<?= pathinfo($data['image'], PATHINFO_FILENAME); ?>" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group" style="width:100%;">
                                <label>Current Image</label><br>
                                <img id="imgPreview" src="uploads/diseases/<?= $data['image'] ?>" style="width:100px;">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group" style="width:100%;">
                                <label>Change Image</label>
                                <input type="file" name="image" onchange="previewImage(event)">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group" style="width:100%;">
                                <label>Symptoms</label>
                                <textarea name="symptoms"><?= $data['symptoms'] ?></textarea>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group" style="width:100%;">
                                <label>Prevention</label>
                                <textarea name="prevention"><?= $data['prevention'] ?></textarea>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group" style="width:100%;">
                                <label>Cure</label>
                                <textarea name="cure"><?= $data['cure'] ?></textarea>
                            </div>
                        </div>

                        <div class="form-row">
                            <button name="update_disease" class="btn add">
                                <i class="fa fa-save"></i> Update Disease
                            </button>
                        </div>

                    </form>

                </div> <!-- card -->
            </div> <!-- content-area -->
        </div>
    </div>

            <?php include "admin_footer.php"; ?>

            <!-- TOAST -->
            <div id="toast" class="toast">Disease updated successfully ✅</div>


            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="js/bootstrap.min.js"></script>
            <script>
                // IMAGE PREVIEW
                function previewImage(event) {
                    let reader = new FileReader();
                    reader.onload = function() {
                        document.getElementById('imgPreview').src = reader.result;
                    }
                    reader.readAsDataURL(event.target.files[0]);
                }

                // SHOW TOAST
                <?php if (isset($success)) { ?>
                    window.onload = function() {
                        let toast = document.getElementById("toast");
                        toast.style.display = "block";

                        setTimeout(() => {
                            toast.style.display = "none";
                            window.location = "manage_diseases.php";
                        }, 2000);
                    }
                <?php } ?>
                let imageInput = document.getElementById("imageName");
                let diseaseInput = document.querySelector("input[name='name']");

                let manualEdit = false;

                // detect manual edit
                imageInput.addEventListener("input", function() {
                    manualEdit = true;
                });

                // autofill
                diseaseInput.addEventListener("input", function() {
                    if (!manualEdit) {
                        let name = this.value.toLowerCase()
                            .replace(/\s+/g, "_")
                            .replace(/[^a-z0-9_]/g, "");

                        imageInput.value = name;
                    }
                });
            </script>
            <script>
                function toggleSidebar() {
                    document.getElementById("sidebar").classList.toggle("active");
                }
            </script>


</body>

</html>