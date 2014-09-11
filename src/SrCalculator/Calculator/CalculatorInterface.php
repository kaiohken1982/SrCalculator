<?php
namespace SrCalculator\Calculator; 

interface CalculatorInterface 
{
    /**
     * Return the result of the equation
     * 
     * @return number
     */
    function calculate();
}