<?php
namespace SrCalculator\Math;

class Math implements MathInterface
{
    /**
     * Prevent division by extremely small numbers
     * @var unknown
     */
    const EPSILON = 1E-10;
    
    public static function add($a, $b) {
        if (!is_numeric($a) || !is_numeric($b)) {
            throw new \Exception('Invalid values');
        }
        return $a + $b;
    }
    
    public static function subtract($a, $b) {
        if (!is_numeric($a) || !is_numeric($b)) {
            throw new \Exception('Invalid values');
        }
        return $a - $b;
    }
    
    public static function multiply($a, $b) {
        if (!is_numeric($a) || !is_numeric($b)) {
            throw new \Exception('Invalid values');
        }
        return $a * $b;
    }
    
    public static function divide($a, $b) {
        if (!is_numeric($a) || !is_numeric($b)) {
            throw new \Exception('Invalid values');
        }
    
        if (floatval($b) == 0 || (abs(floatval($b)) < self::EPSILON)) {
            throw new \Exception('Division by zero');
        }
    
        return $a / $b;
    }
}