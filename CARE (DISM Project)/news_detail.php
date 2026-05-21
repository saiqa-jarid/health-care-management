<?php 
include 'conn.php'; 
// include 'header.php';
 

if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = "SELECT * FROM news WHERE news_id = '$id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
}

if(!$row) {
    echo "<div style='padding:100px; text-align:center;'><h1>News Not Found!</h1><a href='newsdisplay.php'>Back to News</a></div>";
    exit;
}
?>

<div style="padding: 50px 10%; font-family: 'Segoe UI', sans-serif; background: #fff; min-height: 80vh;">
    <a href="newsdisplay.php" style="color: #3ab5a4; text-decoration: none; font-weight: bold; display: flex; align-items: center; gap: 8px;">
        <i class="fa fa-arrow-left"></i> Back to All News
    </a>

    <div style="margin-top: 30px;">
        <h1 style="color: #333; font-size: 42px; margin-bottom: 15px;"><?php echo $row['title']; ?></h1>
        
        <div style="color: #888; font-size: 15px; margin-bottom: 30px; display: flex; gap: 20px;">
            <span><i class="fa fa-user"></i> By <?php echo $row['author']; ?></span>
            <span><i class="fa fa-calendar"></i> <?php echo date('F d, Y', strtotime($row['publish_date'])); ?></span>
        </div>
        
        <img src="uploads/news/<?php echo $row['images']; ?>" 
             style="width: 100%; max-height: 500px; object-fit: cover; border-radius: 20px; margin-bottom: 40px; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">

        <div style="line-height: 1.9; color: #444; font-size: 20px; max-width: 900px; margin: 0 auto;">
            <p><?php echo nl2br($row['content']); ?></p>
        </div>
    </div>
</div>

</body>
</html>