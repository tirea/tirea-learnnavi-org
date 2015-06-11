#!/usr/bin/perl
use POSIX qw(strftime);
my $tz = strftime("%z", localtime(time()));
my $gentime = strftime("%Y-%m-%dT%H:%M:%S", localtime(time())) . $tz;
my $date = strftime("%Y-%m-%d %H:%M:%S", localtime(time()));
print "tz = " . $tz . "\n";
print "gentime = " . $gentime . "\n"; 
print "date = " . $date . "\n";
my $gentime2 = strftime("%a, %d %b %Y %H:%M:%S %z", localtime(time())); 
print "gentime2 = " . $gentime2;
