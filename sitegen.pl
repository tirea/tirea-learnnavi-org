#!/usr/bin/env perl
# Oel ngati kameie.
# This is sitegen.pl from sitegen, written by akiwiguy
# See https://github.com/akiwiguy/sitegen/ for details.
# Released under the Simplified BSD Licence, see LICENCE for details.

#use strict;
use File::Spec::Functions qw(rel2abs);
use File::Path;
use File::Basename;
use File::Copy::Recursive qw(rcopy);
use File::stat;
use Switch;
use Config::IniFiles;
use Fcntl qw(:flock :seek);
use POSIX qw(strftime);

my $version = "0.6"; # script version
my $scriptloc = dirname(rel2abs($0)); # directory script is in

switch ($ARGV[0]) {
	case "init" { &checkinit; }
	case "forceinit" { &init; }
	case "process" { &genpages; &genposts; &genpostlist; &genpostrss; &copytemplatefiles; }
	case "clean" { &cleanoutput; }
	case "distclean" { &distclean };
	case "default-template" { &defaulttemplate; }
	case "help" { &printhelp; }
	else { &printhelp; }
}

sub printhelp {
	print("sitegen $version - https://github.com/akiwiguy/sitegen\n");
	print("Valid commands:\n");
	print("init			Sets up new site\n");
	print("process			Process files\n");
	print("clean			Clean output directory\n");
	print("distclean		Remove all sitegen files\n");
	print("default-template	Restores the default template\n");
	print("help			Display this help message\n");
}

sub checkinit {
	if (-f "$scriptloc/_config/config") {
		print("A config file already exists. Run sitegen.pl forceinit if you're sure you want to re-init.\n");
	} else { &init; }
}

sub init {
	print("Creating base layout...");
	mkdir("$scriptloc/_template");
	mkdir("$scriptloc/_posts");
	mkdir("$scriptloc/_posts/res");
	mkdir("$scriptloc/_pages");
	mkdir("$scriptloc/_pages/res");
	mkdir("$scriptloc/_config");
	mkdir("$scriptloc/_output");
	mkdir("$scriptloc/_output/res");
	mkdir("$scriptloc/_output/posts");
	mkdir("$scriptloc/_output/posts/res");
	open(STYLESCSS, '>_template/styles.css');
	print STYLESCSS "body { background-color: lightgrey; color: black; }\n#header { width: 100%; height: 2em; line-height: 2em; }\n#header h1 { font: 1.5em georgia; margin-left: 10px; }\n h1 sub { font: 0.8em georgia; color:grey; }\n#header nav { position: absolute; top: 10px; right: 10px; }\n#header nav a:link, #header nav a:visited, #header nav a:active { color: black; text-decoration: underline; }\n#header nav a:hover { text-decoration: overline; }\n#header nav a.current { color: darkred; text-decoration: none; }\n#content { width: 100%; text-align: center; }\n#content h2 { font: 1.25em georgia; margin: 0; }\n#footer { font-size: 0.8em; color: gray; margin-top: 20px; text-align: center;}";
	close(STYLESCSS);
	open(LAYOUT, '>_template/layout.page');
	print LAYOUT "<!doctype html>\n<html>\n<head>\n<meta charset=\"UTF-8\" />\n<title>{{post.title}} - {{site.name}}</title>\n<link href=\"styles.css\" rel=\"stylesheet\" type=\"text/css\" />\n</head>\n<body>\n<div id=\"header\">\n<h1>{{site.name}}<sub>{{site.tagline}}</sub></h1>\n<nav><a href=\"index.html\">home</a> <a href=\"posts/\">blog</a><a href=\"posts.rss\"><img src=\"http://i.imgur.com/kPioJ.png\" style=\"border: 0;\"/></a></nav>\n</div>\n<div id=\"content\">\n<h2>{{post.title}}</h2><br />\n{{post.content}}\n</div>\n<div id=\"footer\">(c) {{site.name}} - powered by <a href=\"https://github.com/akiwiguy/sitegen\">sitegen</a></div>\n</body>\n</html>";
	close(LAYOUT);
	open(LAYOUT, '>_template/layout.post');
	print LAYOUT "<!doctype html>\n<html>\n<head>\n<meta charset=\"UTF-8\" />\n<title>{{post.title}} - {{site.name}}</title>\n<link href=\"../styles.css\" rel=\"stylesheet\" type=\"text/css\" />\n</head>\n<body>\n<div id=\"header\">\n<h1>{{site.name}}<sub>{{site.tagline}}</sub></h1>\n<nav><a href=\"../index.html\">home</a> <a href=\"../posts/\">blog</a><a href=\"../posts.rss\"><img src=\"http://i.imgur.com/kPioJ.png\" style=\"border: 0;\"/></a></nav>\n</div>\n<div id=\"content\">\n<h2>{{post.title}}</h2>\n<b>{{post.timestamp}}</b><br />\n{{post.content}}\n</div>\n<div id=\"footer\">(c) {{site.name}} - powered by <a href=\"https://github.com/akiwiguy/sitegen\">sitegen</a></div>\n</body>\n</html>";
	close(LAYOUT);
	open(CONFIG, '>_config/config');
	print CONFIG "[site]\nname=sitegen site\ntagline=A random sitegen site\nurl=http://akiwiguy.net\n\n[webmaster]\nemail=blah\@blah.com\n\n[comments]\nenabled=no\nshortname=example\n";
	close(CONFIG);
	print(" done.\n");
}	

sub genpostlist {
	my $configfile = Config::IniFiles->new( -file => "$scriptloc/_config/config" );
	my $sitename = $configfile->val("site","name");
	my $sitetagline = $configfile->val("site","tagline");
	my $longpostlist = $configfile->val("site","post_list_preview");
	print("Generating post list: ");
	my $template;
	open (TEMPLATE, "<", "$scriptloc/_template/layout.post");
	while(<TEMPLATE>) { $template = $template . $_; }
	close(TEMPLATE);	
	my $postlist;
	chdir("$scriptloc/_posts");
	opendir(DIR, ".");
        my @files = readdir(DIR);
	my @files = sort { $b cmp $a } @files;
	if($longpostlist eq "yes") {
		my $shortie = 0;
		foreach (@files) {
			if ($_ =~ /.post$/) {
				my $postfname = $_;
				$postfname =~ s/.post//;
				open(POST, "<", "$scriptloc/_posts/$postfname.post");
				my $postname = <POST>;
				chomp($postname);
				my $postcontent;
				while(<POST>) { 
					if (($_ =~ m/endpostpreview/)){
						$shortie = 1;
						last;
					}else{
						$postcontent = $postcontent . $_; 
					}
				}
				close(POST);
				my $st = stat("$scriptloc/_posts/$postfname.post");
				my $date = strftime("%a, %d %b %Y %H:%M:%S %z", localtime( $st->ctime ));
				$postlist = $postlist . "<a class=\"posttitle\" href=\"$postfname.html\">$postname</a><br /><span class=\"posttimestamp\">$date | <a href=\"$postfname.html#disqus_thread\">Comments</a></span><br /><div class=\"postpreview\">$postcontent</div>";
				if($shortie){
					$postlist = $postlist . "[...]<br><a href=\"$postfname.html\">Continue reading</a><br><br>";
				}
				$shortie = 0;
			}
		}
	} else {
		#$postlist = "<ul>";
		$postlist = "";
		foreach (@files) {
        	        if ($_ =~ /.post$/) {
				my $postfname = $_;
				$postfname =~ s/.post//;
				open(POST, "<", "$scriptloc/_posts/$postfname.post");
				my $postname = <POST>;
				chomp($postname);
				close(POST);
				my $st = stat("$scriptloc/_posts/$postfname.post");
				my $date = strftime("%a, %d %b %Y %H:%M:%S %z", localtime( $st->ctime ));
				#$postlist = $postlist . "<li><a href=\"$postfname.html\">$postname</a> <span style=\"font-size: 0.9em; \">($date)</span></li>";
				$postlist = $postlist . "<a href=\"$postfname.html\"><h3>$postname</h3></a><h4>$date<h4><hr>"
			}
		}
		#$postlist = $postlist . "</ul>";
	}
	my $output;
	$output = $template;
	$output =~ s/{{site.name}}/$sitename/g;
	$output =~ s/{{site.tagline}}/$sitetagline/g;
	$output =~ s/{{post.title}}/Na'vi Grammar Made Simple/g;
	$output =~ s/{{post.content}}/$postlist/g;
	$output =~ s/{{post.timestamp}}//g;
	$output =~ s/{{:\)}}/<img class=\"smiley\" src=\"\/res\/smiley.gif\">/g;
	$output =~ s/{{;\)}}/<img class=\"wink\" src=\"\/res\/wink.gif\">/g;
	$output =~ s/{{:D}}/<img class=\"cheesy\" src=\"\/res\/cheesy.gif\">/g;
	$output =~ s/{{;D}}/<img class=\"grin\" src=\"\/res\/grin.gif\">/g;
	open(POSTLIST, ">", "$scriptloc/_output/posts/index.html");
	flock(POSTLIST, LOCK_EX);
	seek(POSTLIST, 0, SEEK_SET);
	print POSTLIST $output;
	close(POSTLIST);
	print("done.\n");
}

sub genposts {
	my $configfile = Config::IniFiles->new( -file => "$scriptloc/_config/config" );
	my $sitename = $configfile->val("site","name");
	my $commentsenabled = $configfile->val("comments","enabled");
	print("Generating posts: ");
	my $template;
	open (TEMPLATE, "<", "$scriptloc/_template/layout.post");
	while(<TEMPLATE>) { $template = $template . $_; }
	close(TEMPLATE);	
	
	chdir("$scriptloc/_posts");
	opendir(DIR, ".");
	my @files = readdir(DIR);
	foreach (@files) {
		if ($_ =~ /.post$/) {
			my $postfname = $_;
			$postfname =~ s/.post//;
			open(POSTSRC, "$scriptloc/_posts/$postfname.post");
			unless(-d "$scriptloc/_output/posts"){
				print("_output/posts does not exist, creating...\n");
				mkdir "$scriptloc/_output/grammar";
			}
			open(POSTOUT, ">", "$scriptloc/_output/grammar/$postfname.html");
			my $content;
			my $postout = $template;
			my $postname = <POSTSRC>;
			chomp($postname);
			my $st = stat("$scriptloc/_posts/$postfname.post");
			my $date = strftime("%a, %d %b %Y %H:%M:%S %z", localtime( $st->ctime ));
			while(<POSTSRC>) { $content = $content . $_; }
			if ($commentsenabled eq "yes") {
				my $disqusshortname = $configfile->val("comments","shortname");
				$content = $content . "<div id=\"disqus_thread\"></div><script type=\"text/javascript\">var disqus_shortname = '$disqusshortname';";
				$content = $content . "(function() {\nvar dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;\n dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';\n (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);\n })();\n</script>\n<noscript>Please enable JavaScript to view the <a href=\"http://disqus.com/?ref_noscript\">comments powered by Disqus.</a></noscript>";
			}
			$postout =~ s/{{site.name}}/$sitename/g;
			my $sitetagline = $configfile->val("site","tagline");
			$postout =~ s/{{site.tagline}}/$sitetagline/g;
			$postout =~ s/{{post.title}}/$postname/g;
			$postout =~ s/{{post.timestamp}}/$date/g;
			$postout =~ s/{{post.content}}/$content/g;
		        $postout =~ s/{{:\)}}/<img class=\"smiley\" src=\"\/res\/smiley.gif\">/g;
		        $postout =~ s/{{;\)}}/<img class=\"wink\" src=\"\/res\/wink.gif">/g;
		        $postout =~ s/{{:D}}/<img class=\"cheesy\" src=\"\/res\/cheesy.gif\">/g;
		        $postout =~ s/{{;D}}/<img class=\"grin\" src=\"\/res\/grin.gif\">/g;
			flock(POSTOUT, LOCK_EX);
			seek(POSTOUT, 0, SEEK_SET);
			print POSTOUT $postout;
			close(POSTOUT);
			print("$postfname.post ($postname), ");
		}
	}
	print("copying resources... ");
	if (! -e "$scriptloc/_posts/res") { mkdir("$scriptloc/_posts/res"); }
	if (! -e "$scriptloc/_output/posts/res") { mkdir("$scriptloc/_output/posts/res"); }
	rcopy("$scriptloc/_posts/res/*", "$scriptloc/_output/posts/res/");
	print("done.\n");
}

sub genpages {
	my $configfile = Config::IniFiles->new( -file => "$scriptloc/_config/config" );
	my $sitename = $configfile->val("site","name");
	print("Generating pages: ");
	my $template;
	open (TEMPLATE, "<", "$scriptloc/_template/layout.page");
	while(<TEMPLATE>) { $template = $template . $_; }
	close(TEMPLATE);	

	chdir("$scriptloc/_pages");
	opendir(DIR, ".");
	my @files = readdir(DIR);
	foreach (@files) {
		if ($_ =~ /.page$/) {
			my $postfname = $_;
			$postfname =~ s/.page//;
			open(POSTSRC, "$scriptloc/_pages/$postfname.page");
			open(POSTOUT, ">", "$scriptloc/_output/$postfname.html");
			my $content;
			my $postout = $template;
			my $postname = <POSTSRC>;
			chomp($postname);
			while(<POSTSRC>) { $content = $content . $_; }
			$postout =~ s/{{site.name}}/$sitename/g;
			my $sitetagline = $configfile->val("site","tagline");
			$postout =~ s/{{site.tagline}}/$sitetagline/g;
			$postout =~ s/{{post.title}}/$postname/g;
			$postout =~ s/{{post.content}}/$content/g;
			flock(POSTOUT, LOCK_EX);
			seek(POSTOUT, 0, SEEK_SET);
			print POSTOUT $postout;
			close(POSTOUT);
			print("$postfname.page ($postname), ");
		}
	}
	print("copying resources... ");
	if (! -e "$scriptloc/_pages/res") { mkdir("$scriptloc/_pages/res"); }
	if (! -e "$scriptloc/_output/res") { mkdir("$scriptloc/_output/res"); }
	rcopy("$scriptloc/_pages/res/*", "$scriptloc/_output/res/");
	print("done.\n");
}

sub copytemplatefiles {
	chdir("$scriptloc");
	print("Copying template: ");
	rcopy("./_template/*", "./_output");
	chdir("$scriptloc/_output");
	unlink("layout.post");
	unlink("layout.page");
	print("done.\n");
}

sub cleanoutput {
	chdir("$scriptloc/_output");
	opendir(DIR, ".");
	closedir(DIR);
	chdir("$scriptloc/_output/posts");
	opendir(DIR, ".");
	my @files = readdir(DIR);
	foreach (@files) { unlink $_; }
	closedir(DIR);
	print("Output directory cleaned.\n");
}

sub distclean {
	chdir("$scriptloc");
	rmtree("_output");
	rmtree("_template");
	rmtree("_posts");
	rmtree("_pages");
	rmtree("_config");
	print("Removed all sitegen files. Run sitegen.pl init to generate defaults.\n");
}

sub genpostrss {
	print("Generating RSS feed...");
	my $configfile = Config::IniFiles->new( -file => "$scriptloc/_config/config" );
	my $sitename = $configfile->val("site","name");
	my $sitetagline = $configfile->val("site","tagline");
	my $siteurl = $configfile->val("site","url");
	my $siteemail = $configfile->val("webmaster","email");
	my $now = time();
	my $gentime = strftime("%a, %d %b %Y %H:%M:%S %z", localtime($now));
	my $longpostlist = $configfile->val("site","post_list_preview");
	my $rss = "<rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\"><channel><atom:link href=\"$siteurl" . "posts.rss\" rel=\"self\" type=\"application/rss+xml\" /><title>$sitename</title><description>$sitetagline</description><link>$siteurl</link><generator>sitegen $version</generator><webMaster>$siteemail</webMaster><lastBuildDate>$gentime</lastBuildDate>\n";
	
	chdir("$scriptloc/_posts");
        opendir(DIR, ".");
        my @files = readdir(DIR);
	my @files = sort { $b cmp $a } @files;
	
	if ($longpostlist eq "yes"){
		my $shortie;
		foreach (@files) {
		        if ($_ =~ /.post$/) {
		                my $postfname = $_;
		                $postfname =~ s/.post//;
		                open(POSTSRC, "$scriptloc/_posts/$postfname.post");
		                my $postname = <POSTSRC>;
				chomp($postname);
			
				####Add Post preview to RSS####
				my $postcontent;
				while(<POSTSRC>) { 
					if (($_ =~ m/endpostpreview/)){
						$shortie = 1;
						last;
					}else{
						$postcontent = $postcontent . $_; 
					}
				
				}
				close(POSTSRC);
				####
			
			
				my $st = stat("$scriptloc/_posts/$postfname.post");
		                my $date = strftime("%a, %d %b %Y %H:%M:%S %z", localtime( $st->ctime ));
		                
		                ####added <description>####
				$rss = $rss . "<item>\n\t<title>$postname</title>\n\t<pubDate>$date</pubDate>\n\t<link>$siteurl/posts/$postfname.html</link>\n\t<guid>$siteurl/posts/$postfname.html</guid>\n\t<description><![CDATA[\n\t$postcontent";
				####
				if($shortie){
					$rss = $rss . "[...]<br><a href=\"http://tirea.learnnavi.org/posts/$postfname.html\">Continue reading</a><br><br>";
				}
				$rss = $rss . "\n\t]]></description>\n</item>\n";
				$shortie = 0;
		        }
		}
	} else { ##no post preview description in RSS
		foreach (@files) {
		        if ($_ =~ /.post$/) {
		                my $postfname = $_;
		                $postfname =~ s/.post//;
		                open(POSTSRC, "$scriptloc/_posts/$postfname.post");
		                my $postname = <POSTSRC>;
				chomp($postname);
				my $st = stat("$scriptloc/_posts/$postfname.post");
		                my $date = strftime("%a, %d %b %Y %H:%M:%S %z", localtime( $st->ctime ));
		                $rss = $rss . "<item>\n\t<title>$postname</title>\n\t<pubDate>$date</pubDate>\n\t<link>$siteurl/posts/$postfname.html</link>\n</item>\n";
		        }
		}
	}
	$rss = "$rss </channel></rss>";
	$rss =~ s/{{:\)}}/<img class=\"smiley\" src=\"http:\/\/forum.learnnavi.org\/Smileys\/learnnavi-ani\/smiley.gif\">/g;
        $rss =~ s/{{;\)}}/<img class=\"wink\" src=\"http:\/\/forum.learnnavi.org\/Smileys\/learnnavi-ani\/wink.gif\">/g;
        $rss =~ s/{{:D}}/<img class=\"cheesy\" src=\"http:\/\/forum.learnnavi.org\/Smileys\/learnnavi-ani\/cheesy.gif\">/g;
        $rss =~ s/{{;D}}/<img class=\"grin\" src=\"http:\/\/forum.learnnavi.org\/Smileys\/learnnavi-ani\/grin.gif\">/g;
	open(RSS, ">", "$scriptloc/_output/posts.rss");
	print RSS $rss;
	close(RSS);
        print("done.\n");
}

sub defaulttemplate {
	open(STYLESCSS, '>_template/styles.css');
	print STYLESCSS "body { background-color: lightgrey; color: black; }\n#header { width: 100%; height: 2em; line-height: 2em; }\n#header h1 { font: 1.5em georgia; margin-left: 10px; }\n h1 sub { font: 0.8em georgia; color:grey; }\n#header nav { position: absolute; top: 10px; right: 10px; }\n#header nav a:link, #header nav a:visited, #header nav a:active { color: black; text-decoration: underline; }\n#header nav a:hover { text-decoration: overline; }\n#header nav a.current { color: darkred; text-decoration: none; }\n#content { width: 100%; text-align: center; }\n#content h2 { font: 1.25em georgia; margin: 0; }\n#footer { font-size: 0.8em; color: gray; margin-top: 20px; text-align: center;}";
	close(STYLESCSS);
	open(LAYOUT, '>_template/layout.page');
	print LAYOUT "<!doctype html>\n<html>\n<head>\n<meta charset=\"UTF-8\" />\n<title>{{post.title}} - {{site.name}}</title>\n<link href=\"styles.css\" rel=\"stylesheet\" type=\"text/css\" />\n</head>\n<body>\n<div id=\"header\">\n<h1>{{site.name}}<sub>{{site.tagline}}</sub></h1>\n<nav><a href=\"index.html\">home</a> <a href=\"posts/\">blog</a><a href=\"posts.rss\"><img src=\"http://i.imgur.com/kPioJ.png\" style=\"border: 0;\"/></a></nav>\n</div>\n<div id=\"content\">\n<h2>{{post.title}}</h2><br />\n{{post.content}}\n</div>\n<div id=\"footer\">(c) {{site.name}} - powered by <a href=\"https://github.com/akiwiguy/sitegen\">sitegen</a></div>\n</body>\n</html>";
	close(LAYOUT);
	open(LAYOUT, '>_template/layout.post');
	print LAYOUT "<!doctype html>\n<html>\n<head>\n<meta charset=\"UTF-8\" />\n<title>{{post.title}} - {{site.name}}</title>\n<link href=\"../styles.css\" rel=\"stylesheet\" type=\"text/css\" />\n</head>\n<body>\n<div id=\"header\">\n<h1>{{site.name}}<sub>{{site.tagline}}</sub></h1>\n<nav><a href=\"../index.html\">home</a> <a href=\"../posts/\">blog</a><a href=\"../posts.rss\"><img src=\"http://i.imgur.com/kPioJ.png\" style=\"border: 0;\"/></a></nav>\n</div>\n<div id=\"content\">\n<h2>{{post.title}}</h2><br />\n<b>{{post.timestamp}}</b>\n{{post.content}}\n</div>\n<div id=\"footer\">(c) {{site.name}} - powered by <a href=\"https://github.com/akiwiguy/sitegen\">sitegen</a></div>\n</body>\n</html>";
	close(LAYOUT);
}

