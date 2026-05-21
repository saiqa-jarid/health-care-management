<?php
include "conn.php";

// GET ID
$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID missing");
}

// FETCH DATA
$query = "SELECT * FROM news WHERE news_id = $id";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("News not found");
}

// UPDATE
if (isset($_POST['update'])) {

    $title = $_POST['title'];
    $author = $_POST['author'];
    $content = $_POST['content'];

    // IMAGE UPDATE (optional)
    if (!empty($_FILES['image']['name'])) {

        $image = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];

        $imageName = time() . "_" . $image;

        // DELETE OLD IMAGE
        if (!empty($data['images'])) {
            $old = "uploads/news/" . $data['images'];
            if (file_exists($old)) {
                unlink($old);
            }
        }

        move_uploaded_file($tmp, "uploads/news/" . $imageName);

        $update = "UPDATE news SET 
            title='$title',
            author='$author',
            content='$content',
            images='$imageName'
            WHERE news_id=$id";
    } else {

        $update = "UPDATE news SET 
            title='$title',
            author='$author',
            content='$content'
            WHERE news_id=$id";
    }

    if (mysqli_query($conn, $update)) {
        $success = true;
    } else {
        echo "Update Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update News</title>

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
                    <h2>Update News</h2>
                    <p>Edit news article</p>
                </div>

                <div class="card">

                    <form method="POST" enctype="multipart/form-data" class="form-box">

                        <h2>Update News</h2>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Headline</label>
                                <input type="text" name="title" value="<?= $data['title']; ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Author</label>
                                <input type="text" name="author" value="<?= $data['author']; ?>" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group" style="width:100%;">
                                <label>Content</label>
                                <textarea name="content" rows="5" required><?= $data['content']; ?></textarea>
                            </div>
                        </div>


                        


                        <p><strong>Current Image:</strong></p>
                        <?php if (!empty($data['images'])) { ?>
                            <img id="imgPreview" src="uploads/news/<?= $data['images']; ?>" width="100">
                        <?php } else { ?>
                            <p>No image</p>
                        <?php } ?>


                            

                        <div class="form-row">
                            <div class="form-group" style="width:100%;">
                                <label>Change Image</label>
                                <input type="file" name="image" onchange="previewImage(event)">
                            </div>
                        </div>

                        <button type="submit" name="update" class="btn add">
                            <i class="fa fa-save"></i> Update News
                        </button>

                        <a href="manage_news.php" class="btn delete">Cancel</a>

                    </form>

                </div>
            </div>
        </div>
    </div>

            <?php include "admin_footer.php"; ?>

            <!-- TOAST -->
            <div id="toast" class="toast">News updated successfully ✅</div>

            <script>
                // IMAGE PREVIEW
                function previewImage(event) {
                    let reader = new FileReader();
                    reader.onload = function() {
                        document.getElementById('imgPreview').src = reader.result;
                    }
                    reader.readAsDataURL(event.target.files[0]);
                }

                // TOAST
                <?php if (isset($success)) { ?>
                    window.onload = function() {
                        let toast = document.getElementById("toast");
                        toast.style.display = "block";

                        setTimeout(() => {
                            toast.style.display = "none";
                            window.location = "manage_news.php";
                        }, 2000);
                    }
                <?php } ?>
            </script>

</body>

</html>