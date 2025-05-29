<?php

namespace unit\src;

use G4\ValueObject\Exception\MissingTimestampValueException;
use G4\ValueObject\Exception\InvalidTimestampValueException;
use G4\ValueObject\TimestampValueMilliseconds;
use PHPUnit\Framework\TestCase;

class TimestampValueMillisecondsTest extends TestCase
{
    /**
     * @return void
     */
    public function testMissingValueException()
    {
        $this->expectException(MissingTimestampValueException::class);
        new TimestampValueMilliseconds('');
    }

    /**
     * @return void
     */
    public function testInvalidValueFloatException()
    {
        $this->expectException(InvalidTimestampValueException::class);
        new TimestampValueMilliseconds('1.0');
    }

    /**
     * @return void
     */
    public function testInvalidValueHexaNumberException()
    {
        $this->expectException(InvalidTimestampValueException::class);
        new TimestampValueMilliseconds('0xFF');
    }

    /**
     * @return void
     */
    public function testValidValues()
    {
        $now = (int) (microtime(true) * 1000);
        $timestampInt = new TimestampValueMilliseconds($now);
        $this->assertEquals($now, $timestampInt->getValue());

        $timestampString = new TimestampValueMilliseconds('1748436857881');
        $this->assertEquals('1748436857881', (string) $timestampString);
    }

    /**
     * @return void
     */
    public function testGetFormatted()
    {
        $timestamp = new TimestampValueMilliseconds('1748436857881');
        $this->assertEquals('2025-05-28', $timestamp->getFormatted());
        $this->assertEquals('May 28 / 2:54', $timestamp->getFormatted('F j / g:i'));
    }

    /**
     * @return void
     */
    public function testGetSeconds()
    {
        $timestamp = new TimestampValueMilliseconds(1748436857881);
        $this->assertEquals(1748436857, $timestamp->getSeconds());
    }

    /**
     * @return void
     */
    public function testNow()
    {
        $time = time();
        $date = date('Y-m-d');
        $timestamp = TimestampValueMilliseconds::now();
        $this->assertEquals($date, $timestamp->getFormatted());
        $this->assertEquals($time, $timestamp->getSeconds());
    }

    /**
     * @return void
     */
    public function testInvalidValueLength()
    {
        $this->expectException(InvalidTimestampValueException::class);
        new TimestampValueMilliseconds(1748436857);
    }
}
