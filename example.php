<?php

require_once(dirname(__FILE__) . '/ip-detect.php');

// Redirect the visitor if they're in the ip ranges in ranges.csv
if (isInIpRanges($_SERVER['REMOTE_ADDR']))
{
    header('Location: http://www.example.org/other-site');
}

// Rest of website code