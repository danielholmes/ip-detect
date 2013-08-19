<?php

require_once(dirname(__FILE__) . '/ip-detect.php');

$testRangesFilepath = dirname(__FILE__) . '/test-ranges.csv';

assertTrue(isValidIpAddress('127.0.0.1'));
assertFalse(isValidIpAddress('0.0.0.256'));
assertFalse(isInIpRanges('Invalid IP', $testRangesFilepath));
assertFalse(isInIpRanges(123455566, $testRangesFilepath));
assertTrue(isInIpRanges('1.0.127.254', $testRangesFilepath));
assertTrue(isInIpRanges('1.0.127.255', $testRangesFilepath));
assertFalse(isInIpRanges('1.0.128.255', $testRangesFilepath));
echo "\n" . 'Done' . "\n";

function assertTrue($condition, $message = null)
{
    if ($condition === true)
    {
        echo '.';
        return;
    }

    testFail($message);
}

function assertFalse($condition, $message = null)
{
    if ($condition === false)
    {
        echo '.';
        return;
    }

    testFail($message);
}

function testFail($message)
{
    throw new RuntimeException(sprintf('Test failure: %s', $message));
}