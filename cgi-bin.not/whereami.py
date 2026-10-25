#! /usr/local/bin/python

# Get the user's TCP address

import sys
sys.path.insert(0, "/usr/lib/python2.4/")
import traceback
import cgi
import os

print "Content-type: text/html"
print ""

sys.stderr = sys.stdout

# My code goes here
def doit():
  tcpaddr = os.environ["REMOTE_ADDR"]
  print "Your address: " + cgi.escape(tcpaddr)

# Run the code, printing errors
try:
  doit()
except:
  print "\n\n<PRE>"
  traceback.print_exc()
