<?php
namespace SrCalculatorTest\Math; 

use SrCalculator\Math\Math;

class MathTest 
    extends \PHPUnit_Framework_TestCase 
{  
    /**
     * @covers \SrCalculator\Math\Math::add()
     */
    public function testAdd() 
    {
        $this->assertEquals(Math::add(2,2), 4);
    }
    
    /**
     * @covers \SrCalculator\Math\Math::add()
     * @expectedException Exception
     * @expectedExceptionMessage Invalid values
     */
    public function testAddException() 
    {
        Math::add('test',2);
    }
    
    /**
     * @covers \SrCalculator\Math\Math::subtract()
     */
    public function testSubtract() 
    {
        $this->assertEquals(Math::subtract(2,2), 0);
    }
    
    /**
     * @covers \SrCalculator\Math\Math::subtract()
     * @expectedException Exception
     * @expectedExceptionMessage Invalid values
     */
    public function testSubtractException() 
    {
        Math::subtract('test',2);
    }
    
    /**
     * @covers \SrCalculator\Math\Math::multiply()
     */
    public function testMultiply() 
    {
        $this->assertEquals(Math::multiply(2,5), 10);
    }
    
    /**
     * @covers \SrCalculator\Math\Math::multiply()
     * @expectedException Exception
     * @expectedExceptionMessage Invalid values
     */
    public function testMultiplyException() 
    {
        Math::multiply('test',2);
    }
    
    /**
     * @covers \SrCalculator\Math\Math::divide()
     */
    public function testDivide() 
    {
        $this->assertEquals(Math::divide(2,5), 0.4);
    }
    
    /**
     * @covers \SrCalculator\Math\Math::divide()
     * @expectedException Exception
     * @expectedExceptionMessage Invalid values
     */
    public function testDivideException() 
    {
        Math::divide('test',2);
    }
    
    /**
     * @covers \SrCalculator\Math\Math::divide()
     * @expectedException Exception
     * @expectedExceptionMessage Division by zero
     */
    public function testDivideDivisionByZeroException() 
    {
        Math::divide(2,0);
    }
}