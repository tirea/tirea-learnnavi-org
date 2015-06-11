<?php require('_login.php'); ?>
<html>
	<!-- you just lost the game. -->
	<head>
		<title>Logged In - Tirea Aean</title>

		<!-- Favicon; RSS; Stylesheet -->
		<link rel="icon" type="image/png" href="/images/favicon.png">
		<link rel="alternate" type="application/rss+xml" title="Tirea Aean RSS" href="http://tirea.learnnavi.org/posts.rss">
		<link rel="stylesheet" href="/styles.css" id="styles">
		<script type="text/javascript" src="/res/jquery-1.3.2.min.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script>
			(function(){
				var $s = document.getElementById('styles');
				if (typeof(document.documentElement.clientWidth) != 'undefined'){
					if(document.documentElement.clientWidth < 520){
						$s.href = "/mstyles.css";
					}else{
						$s.href = "/styles.css";
					}
				}
				window.onresize = function(event) {
					if(document.documentElement.clientWidth < 520){
						$s.href = "/mstyles.css";
					}else{
						$s.href = "/styles.css";
					}
				}
			})();
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
					<a href="../posts/index.html">Blog</a>
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
				<h1 class="posttitle">Delete Post</h1>
				<small class="posttimestamp">2012-30-10 18:15</small>
			</div>

			<div class="postpreview">
			
				<?php 
					$postdir = realpath("/home/tirea/tirea.learnnavi.org/_posts")."/";
					$file_to_delete = $_REQUEST["file"];  
					echo "file_to_delete: ".$file_to_delete; 
					echo "<br>";

					// Make sure that the file is in (and exists in) the post directory
					// This prevents this script being used to delete any file in a dir
					// owned by apache or group writable by the apache group.

					$path = realpath($postdir."/".$file_to_delete);

					echo "path: ".$path; 
					echo "<br>";
					echo "path from 0 to length of postdir: ".substr($path,0,strlen($postdir));
					echo "<br>";
					echo "postdir: ".$postdir;
					echo "<br>";
	
					if (substr($path, 0, strlen($postdir)) != $postdir)
						die ("Access denied"); 
					if (!file_exists($path))
						die ("File not found");

				/*
  					// STILL INSECURE!!!!
					// Do not use in any public place without authentication.
  					// Allows deletion of any file within /my/files
	  				// Usage: filename.php?file=filename 
					$cmd = "ls " . $postdir;
					echo "<h3>Files in _Posts</h3>";
					echo "<h4>deleting " . $path . "</h4>";
					system($cmd);
					echo "<hr>";
					unlink($path);
					echo "<h3>File Deleted</h3>";
					echo "<h4>" . $path . " deleted.</h4>";  
					system($cmd);
					echo "<hr>";
				*/

					$trashdir = realpath("/home/tirea/tirea.learnnavi.org/_trash")."/";
					$cmd0 = "ls " . $postdir;

					echo "<h3>Files in _posts</h3>";
					echo "<h4>deleting " . $postdir . $file_to_delete . "</h4>";
					system($cmd0);
					echo "<hr>";  
	
					// You don't need to chmod a file to delete it; if you don't have
					// permission to delete it then you won't have permission to chmod
					// it either.
					//system("chmod a+rw ".$postdir.$file_to_delete);

					if (rename($postdir.$file_to_delete, $trashdir.$file_to_delete)) {
						echo "<h3>File deleted</h3>";
						echo "<h4>" . $postdir.$file_to_delete . " deleted.</h4>";
						system($cmd0);
						echo "<hr>";
					} else {
						echo "<h3>Something went wrong. O_O</h3>";
					}
				?>

				<h3><a href="index.php">Back To Dashboard</a></h3>
				<h4><?php system("date"); ?></h4>
			</div>
			<footer>
				<p>
					<sup>powered by sitegen</sup>
				</p>
			</footer>
		</div>
	</body>
</html>
