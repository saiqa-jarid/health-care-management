<?php
include 'conn.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Stylesheets -->
     <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
     <link rel="stylesheet" href="css/nav-foot.css">
     <link rel="stylesheet" href="css/newsdisplay.css">
    
</head>

<body>

    <?php
    include "header.php";
    ?>


    <div class="news-section">
        <h1 style="color: #333;">Latest Healthcare Updates</h1>
        <div style="width: 60px; height: 3px; background: #3ab5a4; margin: 10px auto 30px;"></div>

        <div class="news-grid">
            <?php
            $result = mysqli_query($conn, "SELECT * FROM news ORDER BY publish_date DESC");

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $short_text = substr(strip_tags($row['content']), 0, 100) . "...";
            ?>
                    <div class="news-card">
                        <img src="uploads/news/<?php echo $row['images']; ?>" alt="News">

                        <div class="news-body">
                            <div class="meta">
                                <i class="fa fa-calendar"></i> <?php echo date('M d, Y', strtotime($row['publish_date'])); ?>
                                | <i class="fa fa-user"></i> <?php echo $row['author']; ?>
                            </div>
                            <h3><?php echo $row['title']; ?></h3>
                            <p><?php echo $short_text; ?></p>
                        </div>

                        <div class="news-footer">
                            <a href="news_detail.php?id=<?php echo $row['news_id']; ?>" class="read-more-btn">
                                Read Full Article <i class="fa fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>

    <?php
    include "footer.php";
    ?>

</body>

</html>