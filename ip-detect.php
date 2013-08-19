<?php

function isInIpRanges($ipAddress, $databaseFilepath = null)
{
    if (!isValidIpAddress($ipAddress))
    {
        return false;
    }

    if ($databaseFilepath === null)
    {
        $databaseFilepath = dirname(__FILE__) . '/ranges.csv';
    }
    $handle = fopen($databaseFilepath, 'r');
    if ($handle === false)
    {
        throw new RuntimeException(sprintf(
            'Couldn\'t open required file: "%s"',
            $csvFilepath
        ));
    }

    while (($rowData = fgetcsv($handle, 1000, ',')) !== false)
    {
        $range = new IpAddressRange($rowData[0], $rowData[1]);
        if ($range->contains($ipAddress))
        {
        	fclose($handle);
        	return true;
        }
    }

    fclose($handle);
    return false;
}

function isValidIpAddress($ipAddress)
{
    return (boolean) filter_var($ipAddress, FILTER_VALIDATE_IP);
}

class IpAddressRange
{
    private $from;
    private $to;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function contains($ipAddress)
    {
        return ip2long($this->from) <= ip2long($ipAddress) &&
            ip2long($ipAddress) <= ip2long($this->to);
    }
}