<?php // db.php

$dbhost = 'db104.perfora.net';
$db = 'db107650585';
$dbuser = 'dbo107650585';
$dbpass = '';

function dbConnect() {
    global $dbhost, $dbuser, $dbpass, $db;

    $dbcnx = @mysql_connect($dbhost, $dbuser, $dbpass)
        or die('The site database appears to be down.');

    if ($db!='' and !@mysql_select_db($db))
        die('The site database is unavailable.');

    return $dbcnx;
}
?>
