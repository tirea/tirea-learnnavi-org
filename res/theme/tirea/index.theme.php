<!DOCTYPE html>
<?php 
$servername = "localhost";
$username = "root";
$password = "navi";
$dbname = "sanume";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
if (!$conn->set_charset("utf8")) {
  die("Error loading charset utf8: " . $conn->error);
}
$sql0 = "SELECT * FROM info";
$result0 = $conn->query($sql0);
$row0 = $result0->fetch_assoc();
$title = $row0["sitename"];
$stag = $row0["sitetag"];
$disclaimer = $row0["disclaimer"];
$webmaster = $row0["webmaster"];
$sql1 = "SELECT * FROM pages";
$result1 = $conn->query($sql1);
$row1 = $result1->fetch_assoc();
$pagetitle = $row1["title"];
$body = $row1["body"];
?>
<html>
  <head>
    <link rel="stylesheet" href="/tirea-learnnavi-org/res/theme/tirea/tirea.css">
    <title><?php echo $title; ?></title>
    <meta charset="UTF-8">
  </head>
  <body>
    <div id="header">
      <div id="menu">
        <ul id="nav">
          <?php $sql = "SELECT * FROM navitems";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                  while($row = $result->fetch_assoc()) {
                    echo '<li class="navitem">' . $row['en_name'] . '</li>';
                  }
                } else {
                  die("Error: Failed to fetch navitems");
                }
          ?> 
        </ul>
      </div>
      <h1 id="stitle"><?php echo $title; ?></h1>
      <h3 id="stag"><?php echo $stag; ?></h3>
    </div>
    <div id="main">
      <h1 id="pagetitle"><?php echo $pagetitle; ?></h1>
      <?php echo $body; ?>
    </div>
    <div id="footer">
      <?php echo $disclaimer . '<br>'; 
            echo "Admin: Tirea Aean | " . $webmaster; 
      ?>
    </div>
  </body>
</html>
<?php $conn->close(); ?>
