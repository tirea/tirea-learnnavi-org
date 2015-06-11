<?php require('_login.php'); ?>
<html>
	<!-- you just lost the game. -->
	<head>
		<title>Logged In - Tirea Aean</title>
		
		<!-- Favicon; RSS; Stylesheet -->
		<link rel="icon" type="image/png" href="/images/favicon.png">
		<link rel="alternate" type="application/rss+xml" title="Tirea Aean RSS" href="http://tirea.learnnavi.org/posts.rss">
		<link rel="stylesheet" href="/archive/styles.css" id="styles">
		<script type="text/javascript" src="/res/jquery-1.3.2.min.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script>
			(function(){
				var $s = document.getElementById('styles');
				if (typeof(document.documentElement.clientWidth) != 'undefined'){
					if(document.documentElement.clientWidth < 520){
						$s.href = "/archive/mstyles.css";
					}else{
						$s.href = "/archive/styles.css";
					}
				}
				window.onresize = function(event) {
					if(document.documentElement.clientWidth < 520){
						$s.href = "/archive/mstyles.css";
					}else{
						$s.href = "/archive/styles.css";
					}
				}
			})();
		</script>
		<script type="text/JavaScript">
		<!--
		function redirect(num){
			var newurl="http://<?php echo $_SERVER["HTTP_HOST"]; ?>/login/delete.php?file="+num;
			window.location.href = newurl;
		}
		//-->
		</script>
	</head>
	<body>
		<div class="logo">
			<a class="brand" href="../index.html">Tirea Aean 
				<sub id="brand-sub">Spirit Blue</sub>
			</a>
		</div>
			
		<!-- Navbar at the top -->
		<div class="navbar">
			<!-- Navbar items -->
			<ul class="nav">
				<li id="home" class="navitem">
					<a href="../index.html">Home</a>
				</li>
				<li id="blog" class="navitem">
					<a href="../posts/index.html">Lessons</a>
				</li>
				<li id="links" class="navitem">
					<a href="../links.html">Links</a>
				</li>
				<li id="login" class="navitem active">
					<a href="../login/login.php">Login</a>
				</li>
				<li id="rss" class="navitem">
					<a href="../posts.rss">
						RSS&nbsp;&nbsp;&nbsp;&nbsp;<img src="/res/rss.png" alt="RSS icon" style="border: 0; "/>
					</a>
				</li>
			</ul>
		</div>
		
		<!-- main body container -->
		<div class="container">

			<div class="page-header">
				<h1 class="posttitle">Dashboard</h1>
			</div>

			<div class="postpreview">
				<h3>Welcome back <?php echo $login->username; ?></h3>
				<h4>Thank you for logging in.</h4>
				<hr>  
				<a href="new.php"><h3>Post Editor</h3></a>
				<h4><?php system("date"); ?></h4>
				<hr>
				<a href="../_posts"><h3>See Current Posts</h3></a>
				<h4>Check out all raw .post files</h4>
				<hr>
				<h3>Delete Post</h3>

				<?php
 					$files = array();
 					$dir = "/home/tirea/tirea.learnnavi.org/_posts";
					if ($dh = opendir($dir)) {
						while (($file = readdir($dh)) !== false) {
							if (is_file($dir . "/" . $file) && preg_match("/\.post\$/", $file))
								array_push($files, $file);
						}
   						closedir($dh);
 					}
					sort($files);
 					$files1 = array();
 					$dir1 = "/home/tirea/tirea.learnnavi.org/_trash";
 					if($dh1 = opendir($dir1)) {
						while (($file1 = readdir($dh1)) !== false) {
   							if (is_file($dir1."/".$file1) && preg_match("/\.post\$/",$file1))
    								array_push($files1, $file1);
						}
						closedir($dh1);
					}
					sort($files1);
				?>

				<form name="delete" method="post" action="delete.php">
					<select name="file">
						<option value="blank.txt" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
        					<?php foreach ($files as $file) echo "<option value=\"$file\">$file</option>"; ?>
					</select>
					<button type="submit">Delete</button>
				</form>
				
				<hr>

				<h3>Restore Post</h3>

				<form name="restore" method="post" action="restore.php">
					<select name="file">
						<option value="blank.txt" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
						<?php foreach ($files1 as $file1) echo "<option value=\"$file1\">$file1</option>"; ?>
					</select>
					<button type="submit">Restore</button>
				</form>
			</div>

			<footer>
				<p>
					<sup>powered by sitegen</sup>
				</p>
			</footer>
		</div>
	</body>
</html>
