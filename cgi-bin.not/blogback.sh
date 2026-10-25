#!/bin/bash

echo "Content-type: text/html"
echo ""
echo "<html><head><title>Blog Backup Log</title></head><body>"
echo "<pre>"
cat /usr/local/www/billstclair.com/cron.log
echo "</pre>"
echo "</body></html>"

