<?php
     	$filename = $_REQUEST['filename'] ;
        $name = $_REQUEST['name'] ;
        $content = $_REQUEST['postcontent'] ;
		$content = "\n" . $content;
		$FILE = "/home/tirea/tirea.learnnavi.org/_posts/" . $filename . ".post";

        //Add checks here for any variables that need to be set
        if($filename == ""){
                echo "<h4>Invalid filename</h4>";
                echo "<a href='javascript:history.back(1);'>Back</a>";
        } else if($name == ""){
                echo "<h4>Invalid post name</h4>";
                echo "<a href='javascript:history.back(1);'>Back</a>";
        } else if($content == ""){
                echo "<h4>Empty content</h4>";
                echo "<a href='javascript:history.back(1);'>Back</a>";
        } else {

		touch($FILE);	
	        chmod($FILE, 0664);
		$fh = fopen($FILE, 'w') or die("can't open file");
		fwrite($fh, $name);
		fwrite($fh, $content);
		fclose($fh);
    
		header("Location: http://".$_SERVER["HTTP_HOST"]."/login/new.php");
	}
?>
