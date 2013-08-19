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

    $ipAddressRanges = getIpRanges($databaseFilepath);
    foreach ($ipAddressRanges as $ipAddressRange)
    {
        if ($ipAddressRange->contains($ipAddress))
        {
            return true;
        }
    }

    return false;
}

function getIpRanges($csvFilepath)
{
    $handle = fopen($csvFilepath, 'r');
    if ($handle === false)
    {
        throw new RuntimeException(sprintf(
            'Couldn\'t open required file: "%s"',
            $csvFilepath
        ));
    }

    $ranges = array();
    while (($rowData = fgetcsv($handle, 1000, ',')) !== false)
    {
        $ranges[] = new IpAddressRange($rowData[0], $rowData[1]);
    }
    fclose($handle);

    return $ranges;
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