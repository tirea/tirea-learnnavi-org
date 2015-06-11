<?php require('_login.php'); ?>
<html>
	<!-- you just lost the game. -->
	<head>
		<title>New Post - Tirea Aean</title>

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

		<script type="text/javascript">
		<!--
			function showPreview(){
			var s=document.getElementById('postcontent').value;
			//if(s.length<1){
			//	alert("Code length must be over 10 characters."); 
			//	return false;
			//}
			//Add your filter code or validation rule here.
			document.getElementById('preview').innerHTML=s;
			}
			function insertTextAtCursor(el, text) {
				var val = el.value, endIndex, range;
				if (typeof el.selectionStart != "undefined" && typeof el.selectionEnd != "undefined") {
					endIndex = el.selectionEnd;
					el.value = val.slice(0, el.selectionStart) + text + val.slice(endIndex);
					el.selectionStart = el.selectionEnd = endIndex + text.length;
				} else if (typeof document.selection != "undefined" && typeof document.selection.createRange != "undefined") {
					el.focus();
					range = document.selection.createRange();
					range.collapse(false);
					range.text = text;
					range.select();
				}
			}
// Surrounds the selected text with text1 and text2.
function surroundText(text1, text2, textarea)
{
	// Can a text range be created?
	if (typeof(textarea.caretPos) != "undefined" && textarea.createTextRange)
	{
		var caretPos = textarea.caretPos, temp_length = caretPos.text.length;

		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? text1 + caretPos.text + text2 + ' ' : text1 + caretPos.text + text2;

		if (temp_length == 0)
		{
			caretPos.moveStart("character", -text2.length);
			caretPos.moveEnd("character", -text2.length);
			caretPos.select();
		}
		else
			textarea.focus(caretPos);
	}
	// Mozilla text range wrap.
	else if (typeof(textarea.selectionStart) != "undefined")
	{
		var begin = textarea.value.substr(0, textarea.selectionStart);
		var selection = textarea.value.substr(textarea.selectionStart, textarea.selectionEnd - textarea.selectionStart);
		var end = textarea.value.substr(textarea.selectionEnd);
		var newCursorPos = textarea.selectionStart;
		var scrollPos = textarea.scrollTop;

		textarea.value = begin + text1 + selection + text2 + end;

		if (textarea.setSelectionRange)
		{
			if (selection.length == 0)
				textarea.setSelectionRange(newCursorPos + text1.length, newCursorPos + text1.length);
			else
				textarea.setSelectionRange(newCursorPos, newCursorPos + text1.length + selection.length + text2.length);
			textarea.focus();
		}
		textarea.scrollTop = scrollPos;
	}
	// Just put them on the end, then.
	else
	{
		textarea.value += text1 + text2;
		textarea.focus(textarea.value.length - 1);
	}
}

		-->
		</script>
		<script src="/login/tinymce/js/tinymce/tinymce.min.js"></script>
		<script>
			/*tinymce.init({
				selector: "textarea",
				resize: "both",
				plugins: [
					"advlist autolink lists link image charmap print preview anchor",
					"searchreplace visualblocks code fullscreen",
					"insertdatetime media table contextmenu paste"
				],
				toolbar: "insertfile undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent blockquote | link image",
				style_formats: [
					{title: "Na'vi", inline: 'span', styles: {color: 'RoyalBlue', fontWeight: 'bold', fontFamily: 'Papyrus,fantasy'}},
					{title: 'Red text', inline: 'span', styles: {color: '#ff0000'}}
				],
				content_css: '/styles.css'
			});*/
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
				<h1 id="posttitle" class="posttitle">New Post</h1>
				<h4>Edit - Save - Publish</h4>
				<small class="posttimestamp"><?php system("date"); ?></small>
			</div>

			<div id="preview"></div>

			<hr>

			<div class="postpreview"></div>

			<br>
			Smileys: 
			{{:)}} <img src="/res/smiley.gif"> 
			{{;)}} <img src="/res/wink.gif"> 
			{{:D}} <img src="/res/cheesy.gif"> 
			{{;D}} <img src="/res/grin.gif">|
			<button id="boldbutton" onclick="surroundText('<strong>','</strong>',document.getElementById('postcontent'));">[b]</button>
			<button id="italicbutton" onclick="surroundText('<em>','</em>',document.getElementById('postcontent'));">[i]</button>
			<button id="underlinebutton" onclick="surroundText('<u>','</u>',document.getElementById('postcontent'));">[u]</button>
			<button id="quotebutton" onclick="surroundText('<blockquote>','</blockquote>',document.getElementById('postcontent'));">[quote]</button>
			<!-- <button id="cssbutton" onclick="insertTextAtCursor(document.getElementById('postcontent'),'<style>\n.navi{color:RoyalBlue;font-weight:bold;font-family:Papyrus,fantasy;}\n.red{color:red;}\n.orange{color:orange;}\n.yellow{color:yellow;}\n.green{color:green;}\n.blue{color:blue;}\n.purple{color:purple;}\n</style>\n');">[css]</button> -->
			<button id="navibutton" onclick="surroundText('<span class=&quot;navi&quot;>','</span>',document.getElementById('postcontent'));">[navi]</button>
			<button id="spanbutton" onclick="surroundText('<span class=>','</span>',document.getElementById('postcontent'));">[span]</button>
			<button id="tablebutton" onclick="surroundText('<table><tr><td>','</td></tr></table>',document.getElementById('postcontent'));">[table]</button>
			<br>

			<?php
				$files = array();
				$dir = realpath("/home/tirea/tirea.learnnavi.org/_posts");
 				if ($dh = opendir($dir)) {
					while (($file = readdir($dh)) !== false) {
     						if (is_file($dir . "/" . $file) && preg_match("/\.post\$/", $file))
							array_push($files, $file);
					}
					closedir($dh);
				}
				sort($files);
			?>

			<form name="edit" method="post" action="new.php">
				<table>
					<tr>
						<td>Loadpost:</td>
						<td>
							<select name="s" size="1">
           							<option value="blank.txt" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
           							<?php foreach ($files as $file) echo "<option value=\"$file\">$file</option>"; ?>
          						</select>
          						<button type="submit">Edit</button>
        					</td>
					</tr>
				</table>
			</form>

			<?php
				if (isset($_POST["s"])) {
					$filename = $_POST["s"];
					// XXXX: validate path to check that it is within dir
					$path = realpath($dir . "/" . $filename);
					$c = preg_split('/\r?\n/', file_get_contents($path), 2);
					$postname = $c[0];
					$content = $c[1];
				} else {
    					$filename = "";
    					$postname = "";
    					$content = "";
				}
			?>

			<form name="newpost" method="post" action="newpost.php" accept-charset="UTF-8">
				<table>
					<tr>
        					<td>Filename:</td>
						<td><input name="filename" type="text" value="<?php echo basename($filename, ".post"); ?>"/></td>
					</tr>
					<tr>
						<td>Post Name:</td>
						<td><input name="name" type="text" value="<?php echo $postname; ?>"/></td>
					</tr>
					<tr>
        					<td>Content:</td>
						<td><textarea name="postcontent" id="postcontent" rows="24" cols="100"><?php echo $content; ?></textarea></td>
					</tr>
				</table>
				<br>
				<input type="submit" value="Save" />
				<button type="button" onclick="javascript:showPreview();location.href='#posttitle'">Preview</button>
				<input type="button" value="Publish" onclick="window.location='publish.php';"></button>
			</form>

			<footer>
				<p>
					<sup>powered by sitegen</sup>
				</p>
			</footer>
		</div>
	</body>
</html>
