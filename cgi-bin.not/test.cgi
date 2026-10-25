#'/usr/bin/perl -w

use CGI;
#use frobulate;

my($cgiquery) = new CGI;

print $cgiquery->header;
print "Hello<br>\n";
exit;
