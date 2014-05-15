<?php
require_once 'MDB2.php';
$dsn = 'mysql://user:d8YAEwatyCB7JNB2@lib/library';
$mdb2 = MDB2::connect($dsn);
if (PEAR::isError($mdb2))
{
    die($mdb2->getMessage());
}
$mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
?>