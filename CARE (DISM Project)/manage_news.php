<?php
session_start();
include("conn.php");

/* ========================
   ADD / UPDATE NEWS
======================== */
if (isset($_POST['save_news'])) {

    $id = $_POST['id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);

    // IMAGE UPLOAD
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];

        $imageName = time() . "_" . $image;
        move_uploaded_file($tmp, "uploads/news/" . $imageName);
    }

    if ($id == 0) {
        $query = "INSERT INTO news (title, author, content, images) 
                  VALUES ('$title','$author','$content','$imageName')";
    } else {

        if (!empty($_FILES['image']['name'])) {
            $query = "UPDATE news SET 
                      title='$title',
                      author='$author',
                      content='$content',
                      images='$imageName'
                      WHERE news_id=$id";
        } else {
            $query = "UPDATE news SET 
                      title='$title',
                      author='$author',
                      content='$content'
                      WHERE news_id=$id";
        }
    }

    if (mysqli_query($conn, $query)) {
        $success = true;
    }
}

/* ========================
   DELETE
======================== */
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    // delete image
    $res = mysqli_query($conn, "SELECT images FROM news WHERE news_id=$id");
    $row = mysqli_fetch_assoc($res);

    if (!empty($row['images'])) {
        $img = "uploads/news/" . $row['images'];
        if (file_exists($img)) {
            unlink($img);
        }
    }

    mysqli_query($conn, "DELETE FROM news WHERE news_id=$id");
    header("Location: manage_news.php");
    exit();
}

/* ========================
   EDIT MODE
======================== */
$update = false;
$id = 0;
$title = "";
$author = "";
$content = "";

if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $update = true;

    $record = mysqli_query($conn, "SELECT * FROM news WHERE news_id=$id");

    if ($record && mysqli_num_rows($record) == 1) {
        $n = mysqli_fetch_assoc($record);
        $title = $n['title'];
        $author = $n['author'];
        $content = $n['content'];
    }
}

/* ========================
   FETCH ALL NEWS
======================== */
$results = mysqli_query($conn, "SELECT * FROM news ORDER BY publish_date DESC");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage News</title>

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
                    <h2><i class="fa fa-newspaper"></i> News Management</h2>
                    <p>Create and manage news articles</p>
                </div>

                <!-- FORM -->
                <div class="card">
                    <form method="POST" enctype="multipart/form-data" class="form-box">

                        <h2><?= $update ? "Edit News" : "Add News"; ?></h2>

                        <input type="hidden" name="id" value="<?= $id ?>">

                        <div class="form-row">
                            <div class="form-group">
                                <label>Headline</label>
                                <input type="text" name="title" value="<?= $title ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Author</label>
                                <input type="text" name="author" value="<?= $author ?>" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group" style="width:100%;">
                                <label>Content</label>
                                <textarea name="content" rows="4" required><?= $content ?></textarea>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group" style="width:100%;">
                                <label>Upload Image</label>
                                <input type="file" name="image">
                            </div>
                        </div>

                        <button type="submit" name="save_news" class="btn add">
                            <i class="fa fa-save"></i> <?= $update ? "Update News" : "Post News"; ?>
                        </button>

                        <?php if ($update): ?>
                            <a href="manage_news.php" class="btn delete">Cancel</a>
                        <?php endif; ?>

                    </form>
                </div>

                <!-- TABLE -->
                <div class="card">
                    <h2>All News</h2>

                    <div class="table-responsive">
                        <table border="1">
                            <tr>
                                <th>Date</th>
                                <th>Headline</th>
                                <th>Author</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>

                            <?php while ($row = mysqli_fetch_assoc($results)) { ?>
                                <tr>
                                    <td><?= $row['publish_date'] ?></td>
                                    <td><?= $row['title'] ?></td>
                                    <td><?= $row['author'] ?></td>

                                    <td>
                                        <?php if (!empty($row['images'])) { ?>
                                            <img src="uploads/news/<?= $row['images'] ?>" width="50">
                                        <?php } ?>
                                    </td>

                                    <td>
                                        <!-- <a href="manage_news.php?edit=<?= $row['news_id'] ?>" class="btn edit">
                                            <i class="fa fa-edit fa-2x"></i>
                                        </a> -->
                                        <a href="update_news.php?id=<?= $row['news_id'] ?>" class="btn edit">
                                            <i class="fa fa-edit fa-2x"></i>
                                        </a>

                                        <a href="manage_news.php?delete=<?= $row['news_id'] ?>"
                                            onclick="return confirm('Delete this news?')"
                                            class="btn delete">
                                            <i class="fa fa-trash fa-2x"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- TOAST -->
    <div id="toast" class="toast">News saved successfully ✅</div>

    <script>
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
    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("active");
        }
    </script>

    <?php include "admin_footer.php"; ?>

</body>

</html>