<?php

namespace G4\ValueObject;

use G4\ValueObject\Exception\MissingTimestampValueException;
use G4\ValueObject\Exception\InvalidTimestampValueException;

class TimestampValueMilliseconds implements StringInterface, NumberInterface
{
    const TIMESTAMP_MILLISECONDS_LENGTH = 13;

    /**
     * @var int
     */
    private $value;

    /**
     * @param $value
     * @throws MissingTimestampValueException
     * @throws InvalidTimestampValueException
     */
    public function __construct($value)
    {
        if (empty($value)) {
            throw new MissingTimestampValueException();
        }

        if (!self::isValid($value)) {
            throw new InvalidTimestampValueException($value);
        }

        $this->value = (int) $value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->value;
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return int
     */
    public function getSeconds()
    {
        return (int) ($this->value / 1000);
    }

    /**
     * @param string $format
     * @return string
     */
    public function getFormatted($format = 'Y-m-d')
    {
        return date($format, $this->getSeconds());
    }

    /**
     * @return self
     * @throws InvalidTimestampValueException
     * @throws MissingTimestampValueException
     */
    public static function now()
    {
        return new self((int) (microtime(true) * 1000));
    }

    public static function isValid($timestamp)
    {
        if (strlen((string) $timestamp) !== self::TIMESTAMP_MILLISECONDS_LENGTH) {
            return false;
        }

        $check = (is_int($timestamp) || is_float($timestamp))
            ? $timestamp
            : (string) (int) $timestamp;

        return $check === $timestamp;
    }
}
