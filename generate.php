<!doctype html>
<html>
  <!-- you just lost the game. -->
  <head>
    <title>Legitimate Na'vi Name Generator! - Tirea Aean</title>
    <!-- Favicon; RSS; -->
    <link rel="icon" type="image/png" href="/images/favicon.ico">
    <link rel="alternate" type="application/rss+xml" title="Tirea Aean RSS" href="http://tirea.learnnavi.org/posts.rss">
    <link rel="stylesheet" href="/res/style.css" id="styles">
    <script type="text/javascript">
      var _gaq = _gaq || [];
       _gaq.push(['_setAccount', 'UA-41643966-1']);
       _gaq.push(['_trackPageview']);
      (function() {
        var ga = document.createElement('script');
        ga.type = 'text/javascript';
        ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(ga, s);
      })();
    </script>		
  </head>

  <body>
    <div id="header">
      <span id="brand">Tirea Na'vi</span><br style="line-height:0px">
      <span id="tagline">Na'vi Lessons for Non-linguists by Tirea Aean</span>
    </div>

    <div id="navbar">
      <ul>
        <li><a href="/">Home</a></li>
        <li><a href="/sounds">Sounds</a></li>
        <li><a href="/grammar">Grammar</a></li>
        <li><a href="/links">Links</a></li>
      </ul>
    </div>

    <div id="main">
      <h1 class="posttitle">Legitimate Na'vi Name Generator</h1>

<div id="body">
<h2>Random Na'vi Name: </h2>
<h1 style="color:RoyalBlue;font-family:PapyrusTR;">
<?php
function getInitial () {
	$type;
	$result;
	
	if (rand(0,100) <= 70){
		$type="single";
	}else {
		$type="cluster";
	}
	
	//single letter initial
	if ($type == "single"){ 
		$rn = rand(0, 100);
		if ($rn <= 4){
			$result = "px";
		}else if ($rn <= 8){
			$result = "tx";
		}else if ($rn <= 12){
			$result = "kx";
		}else if ($rn <= 17){
			$result = "p";
		}else if ($rn <= (22)){
			$result = "t";
		}else if ($rn <= (27)){
			$result = "k";
		}else if ($rn <= (32)){
			$result = "ts";
		}else if ($rn <= (37)){
			$result = "f";
		}else if ($rn <= (42)){
			$result = "s";
		}else if ($rn <= (47)){
			$result = "h";
		}else if ($rn <= (52)){
			$result = "v";
		}else if ($rn <= (57)){
			$result = "z";
		}else if ($rn <= (62)){
			$result = "m";
		}else if ($rn <= (67)){
			$result = "n";
		}else if ($rn <= (72)){
			$result = "ng";
		}else if ($rn <= (77)){
			$result = "r";
		}else if ($rn <= (82)){
			$result = "l";
		}else if ($rn <= (87)){
			$result = "w";
		}else if ($rn <= (92)){
			$result = "n";
		}else {
			$result = "'";
		}
	}else {
		$ro = rand(1, 3);
		//start with f
		if ($ro == 1){ 
			$rp = rand(1, 100);
			if ($rp <= 5){
				$result = "fpx";
			}else if ($rp <= 11){
				$result = "fkx";
			}else if ($rp <= 16){
				$result = "ftx";
			}else if ($rp <= 25){
				$result = "ft";
			}else if ($rp <= 33){
				$result = "fp";
			}else if ($rp <= 42){
				$result = "fk";
			}else if ($rp <= 50){
				$result = "fm";
			}else if ($rp <= 57){
				$result = "fn";
			}else if ($rp <= 63){
				$result = "fng";
			}else if ($rp <= 70){
				$result = "fr";
			}else if ($rp <= 78){
				$result = "fl";
			}else if ($rp <= 86){
				$result = "fw";
			}else if ($rp <= 94){
				$result = "fy";
			}else {
				$result = "fr";
			}
		}else if ($ro == 2){ //start with s
			$rp = rand(1, 100);
			if ($rp <= 5){
				$result = "spx";
			}else if ($rp <= 11){
				$result = "skx";
			}else if ($rp <= 16){
				$result = "stx";
			}else if ($rp <= 25){
				$result = "st";
			}else if ($rp <= 33){
				$result = "sp";
			}else if ($rp <= 42){
				$result = "sk";
			}else if ($rp <= 50){
				$result = "sm";
			}else if ($rp <= 57){
				$result = "sn";
			}else if ($rp <= 63){
				$result = "sng";
			}else if ($rp <= 70){
				$result = "sr";
			}else if ($rp <= 78){
				$result = "sl";
			}else if ($rp <= 86){
				$result = "sw";
			}else if ($rp <= 94){
				$result = "sy";
			}else {
				$result = "sr";
			}
		}else if ($ro == 3){ //start with ts
			$rp = rand(1, 100);
			if ($rp <= 5){
				$result = "tspx";
			}else if ($rp <= 11){
				$result = "tskx";
			}else if ($rp <= 16){
				$result = "tstx";
			}else if ($rp <= 25){
				$result = "tst";
			}else if ($rp <= 33){
				$result = "tsp";
			}else if ($rp <= 42){
				$result = "tsk";
			}else if ($rp <= 50){
				$result = "tsm";
			}else if ($rp <= 57){
				$result = "tsn";
			}else if ($rp <= 63){
				$result = "tsng";
			}else if ($rp <= 70){
				$result = "tsr";
			}else if ($rp <= 78){
				$result = "tsl";
			}else if ($rp <= 86){
				$result = "tsw";
			}else if ($rp <= 94){
				$result = "tsy";
			}else {$result = "tsr";}
		}
	}
	return $result;
}

function getNucleus () {
	
	$isDiphthong;
	$result;
	
	if (rand(0,100) > 20){
		$isDiphthong="kehe";
	}else {
		$isDiphthong="srane";
	}

	if ($isDiphthong == "srane"){ //diphthong
		$rx = rand(0, 100);
		if ($rx <= 25){
			$result = "aw";
		}else if ($rx <= 50){
			$result = "ay";
		}else if ($rx <= 75){
			$result = "ey";
		}else if ($rx <= 100){
			$result = "ew";
		}
	}else {
		$ry = rand(1, 100);
		if ($ry <= 25){
			$result = "a";
		}else if ($ry <= 40){
			$result = "e";
		}else if ($ry <= 55){
			$result = "o";
		}else if ($ry <= 70){
			$result = "u";
		}else if ($ry <= 80){
			$result = "ì";
		}else if ($ry <= 85){
			$result = "ä";
		}else {$result = "a";}
	}
	return $result;
}

function getCoda () {
	
	$result;
	$rz = rand(0, 320);
	
	if ($rz <= 4){
		$result = "px";
	}else if ($rz <= 8){
		$result = "tx";
	}else if ($rz <= 12){
		$result = "kx";
	}else if ($rz <= 20){
		$result = "p";
	}else if ($rz <= 28){
		$result = "t";
	}else if ($rz <= 44){
		$result = "k";
	}else if ($rz <= 49){
		$result = "k";
	}else if ($rz <= 58){
		$result = "m";
	}else if ($rz <= 70){
		$result = "n";
	}else if ($rz <= 76){
		$result = "ng";
	}else if ($rz <= 80){
		$result = "r";
	}else if ($rz <= 85){
		$result = "l";
	}else{
		$result="";
	}
	return $result;
}

$k;
while ($k <= $_REQUEST["k"] -5){
	$i;
	echo ucfirst(getInitial().getNucleus());
	while ($i <= $_REQUEST["a"] - 2){
		echo getInitial().getNucleus();
		$i++;
	}
	echo getCoda();$i=0;
	echo " te ";
	echo ucfirst(getInitial().getNucleus());
	while ($i <= $_REQUEST["b"] - 2){
		echo getInitial().getNucleus();
		$i++;
	}
	echo getCoda();
	$i=0;
	echo " ";
	echo ucfirst(getInitial().getNucleus());
	while ($i <= $_REQUEST["c"] - 2){
		echo getInitial().getNucleus();
		$i++;
	}
	echo getCoda();
	$i=0;
	echo "'it";
	if (rand(0,1)==0){
		echo "an";
	}else{
		echo "e";
	}
	$k++;
	echo "<br/>";	
}
?>
</h1>
<br/>

<h2>How to Use:</h2><br/>

<p>* Refresh the Page to generate more names. Names ending in 'itan are male, those ending in 'ite are female.</p>

<p>* To change how long each part of the name is, click one of the links below and then change the numbers in the address bar.</p>

<p>* The number following a= is the number of syllables for the given name, b is the number of syllables for the family name (following te), and c is the number of syllables for the patronymic/matronymic name.</p>

<p>a=3, b=2, and c=3 usually works best - try generating with this link: <a href="http://<?php echo $_SERVER["HTTP_HOST"]; ?>/generate.php?a=3&b=2&c=3">http://<?php echo $_SERVER["HTTP_HOST"]; ?>/generate.php?a=3&b=2&c=3</a></p>

<p>There is no limit for a, b, and c. You can even try <a href="http://<?php echo $_SERVER["HTTP_HOST"]; ?>/generate.php?a=10&b=10&c=15">http://<?php echo $_SERVER["HTTP_HOST"]; ?>/generate.php?a=10&b=10&c=15</a>!</p>

<p>For reference, Neytiri's name is of the form <a href="http://<?php echo $_SERVER["HTTP_HOST"]; ?>/generate.php?a=3&b=2&c=2">a=3&b=2&c=2</a> and Tsu'tey's name is of the form <a href="http://<?php echo $_SERVER["HTTP_HOST"]; ?>/generate.php?a=2&b=3&c=3">a=2&b=3&c=3</a></p>
<br>
<p><a href="http://forum.learnnavi.org/projects/web-based-navi-name-generator!/msg566249/#msg566249">Web-based Na'vi Name Generator!</a> by Uniltìrantokx te Skxawng</p>
</div>
    </div>
  </body>
</html>
