#!/usr/bin/perl -w

use strict;
use CGI;
use CGI::Carp qw(fatalsToBrowser);
use Template;

my($cgiquery) = new CGI;

print $cgiquery->header;

my($headertemplate) = Template->new();
my($input) = "cgicommentsheader.html";
my($html) = "";
$headertemplate->process($input, {}, \$html);
print $html;

exit;
