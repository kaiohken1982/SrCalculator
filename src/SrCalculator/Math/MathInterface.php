<?php
namespace SrCalculator\Math;

interface MathInterface 
{
    /**
     * Return the sum between $a and $b 
     * 
     * @param number $a
     * @param number $b
     * @throws \Exception
     * @return number
     */
    static function add($a, $b);
    
    /**
     * Return the difference between $a and $b 
     * 
     * @param number $a
     * @param number $b
     * @throws \Exception
     * @return number
     */
    static function subtract($a, $b);
    
    /**
     * Return the product between $a and $b 
     * 
     * @param unknown $a
     * @param unknown $b
     * @throws \Exception
     * @return number
     */
    static function multiply($a, $b);
    
    /**
     * Return the quotient between $a and $b 
     * 
     * @param unknown $a
     * @param unknown $b
     * @throws \Exception
     * @return number
     */
    static function divide($a, $b);
}