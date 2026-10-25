#!/bin/bash

echo "Content-type: text/html"
echo ""
echo "<pre>"
cat /etc/issue
uname -a
echo "</pre>"

