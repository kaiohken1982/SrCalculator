<?php
namespace SrCalculatorTest\Calculator; 

use SrCalculator\Calculator\Calculator;

class CalculatorTest 
    extends \PHPUnit_Framework_TestCase 
{  
    protected $obj;
    
    protected function setUp() 
    {
        $this->obj = new Calculator('2 + 4    *  3+  5+1');
    }  

    /** 
     * Assert that the equation is without whitespaces 
     * 
     * @covers \SrCalculator\Calculator\Calculator::__construct() 
     * @covers \SrCalculator\Calculator\Calculator::setEquation() 
     * @covers \SrCalculator\Calculator\Calculator::getEquation() 
     */
    public function testGetSetEquation() 
    {
        $this->assertEquals($this->obj->getEquation(), '2+4*3+5+1');
    }
    
    /**
     * Test empty equation exception
     * 
     * @covers \SrCalculator\Calculator\Calculator::setEquation() 
     * @expectedException Exception
     * @expectedExceptionMessage Equation is empty
     */
    public function testEmptyEquationException() 
    {
        $this->obj->setEquation();
    }
    
    /**
     * @covers \SrCalculator\Calculator\Calculator::getToken() 
     * @covers \SrCalculator\Calculator\Calculator::parseEquation() 
     * @covers \SrCalculator\Calculator\Calculator::calculate() 
     */
    public function testCalculate() 
    {
        $result = $this->obj->calculate();
        $this->assertEquals($result, 20);
    }
    
    /**
     * @covers \SrCalculator\Calculator\Calculator::calculate() 
     * @expectedException Exception
     * @expectedExceptionMessage Not enough operands on the stack
     */
    public function testNotEnoughOperand() 
    {
        $this->obj->setEquation('2 +++ 2');
        $result = $this->obj->calculate();
    }
    
    /**
     * @covers \SrCalculator\Calculator\Calculator::getToken() 
     * @expectedException Exception
     */
    public function testSomethingWrongWithToken() 
    {
        $this->obj->setEquation('2 + hello');
        $result = $this->obj->calculate();
    }
}