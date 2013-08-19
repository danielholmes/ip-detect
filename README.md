Simple IP Address Detection
===========================

Reads in the Geolite database (CSV Format not binary) and detects if a given IP Address is within it.

For more information on the Geolite database see:

[Home Page](http://dev.maxmind.com/geoip/legacy/geolite/)
[Direct download link](http://geolite.maxmind.com/download/geoip/database/GeoIPCountryCSV.zip)

Usage
-----
For an example usage, see example.php. The general idea is that you would save a subset of the full
CSV database to ranges.csv and then use that. For example if I wanted to redirect all Australian
users to a different url I would do the following (where `GeoIPCountryWhois.csv` is the full 
database):

 1. `grep "Australia" GeoIPCountryWhois.csv >> ranges.csv`
 2. Copy `ranges.csv` and `ip-detect.php` to your website
 3. Use the following code at the top of your website files (or within your source code as needed):
 ```php
<?php

require_once(dirname(__FILE__) . '/ip-detect.php');

// Redirect the visitor if they're in ranges.csv - i.e. the Australian IP Address ranges
if (isInIpRanges($_SERVER['REMOTE_ADDR']))
{
    header('Location: http://www.example.org/australian-site');
}

// Rest of website code```

Running Tests
-------------
`php tests.php`
