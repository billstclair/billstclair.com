<?php
/*
 * This file is part of FEED ON FEEDS - http://feedonfeeds.com/
 *
 * init.php - initializes FoF, and contains functions used from other scripts
 *
 *
 * Copyright (C) 2004 Stephen Minutillo
 * steve@minutillo.com - http://minutillo.com/steve/
 *
 * Distributed under the GPL - see LICENSE
 *
 */

require_once("config.php");

define('MAGPIE_CACHE_AGE', 60*15);
define('MAGPIE_USER_AGENT', 'FeedOnFeeds/0.1.8 (+http://minutillo.com/steve/feedonfeeds/)');
define('MAGPIE_CACHE_DIR', FOF_CACHE_DIR);

define('FOF_MAX_INT', 2147483647);


// surpress magpie's warnings, we'll handle those ourselves
//error_reporting(E_ERROR);

require_once('magpierss/rss_fetch.inc');
require_once('magpierss/rss_utils.inc');

$fof_connection = mysql_connect(FOF_DB_HOST, FOF_DB_USER, FOF_DB_PASS) or die("Cannot connect to database.  Check your configuration.  Mysql says: <b>" . mysql_error());
mysql_select_db(FOF_DB_DBNAME, $fof_connection) or die("Cannot select database.  Check your configuration.  Mysql says: " . mysql_error());

if(!$installing) is_writable( FOF_CACHE_DIR ) or die("Cache directory is not writable or does not exist.  Have you run <a href=\"install.php\"><code>install.php</code></a>?");

$FOF_FEED_TABLE = FOF_FEED_TABLE;
$FOF_ITEM_TABLE = FOF_ITEM_TABLE;

$fof_rss_cache = new RSSCache( MAGPIE_CACHE_DIR );

?>
