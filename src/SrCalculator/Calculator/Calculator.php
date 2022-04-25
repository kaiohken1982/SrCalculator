<?php
namespace SrCalculator\Calculator; 

use \SrCalculator\Math\Math;

/**
 *
 * @author Sergio Rinaudo
 */
class Calculator 
    implements CalculatorInterface
{  
    /**
     * @var string
     */
    protected $equation;
    
    /**
     * All valid tokens. If the equation contains something that is not numeric and not in this array 
     * an exception will be raised
     * @var array
     */
    protected $validTokens = array('+','-','*','/');
    
    // array of valid operators for equations, odule and power can be added in the future
    protected static $operators = array(
        '+' => array('assoc' => 'left', 'pre' => 1, 'function' => 'add'),
        '-' => array('assoc' => 'left', 'pre' => 1, 'function' => 'subtract'),
        '*' => array('assoc' => 'left', 'pre' => 2, 'function' => 'multiply'),
        '/' => array('assoc' => 'left', 'pre' => 2, 'function' => 'divide'),
    );
    
    public function validateAndFilterEquation($equation = '') 
    {
        $equation = str_replace(' ', '', $equation);
        
        if (strlen($equation) < 1) {
            throw new \Exception('Equation is empty');
        }
    
        return $equation;
    }
    
    public function getToken(string $equation, &$i) 
    {
        $length = strlen($equation);
		$token = $equation[$i];	
		$nextToken = isset($equation[$i+1]) ? $equation[$i+1] : '';
		
        if (is_numeric($token) || $token == '.') {
		    // Numbers can be longer than 1 char
		    while ($i < $length && (is_numeric($nextToken) || $nextToken == '.')) {
		        $token .= $nextToken;
		        $i++;
		        $nextToken = ($i + 1) < $length ? $equation[$i+1] : '';
		    }
		}
		
		if(!is_numeric($token) && !in_array($token, $this->validTokens)) {
		    throw new \Exception('Invalid token in your equation. Valid tokens are ' . (implode(", ", $this->validTokens)));
		}
		
		return $token;
    }
    
    public function calculate(string $equation) 
    {
        $equation = $this->validateAndFilterEquation($equation);
        $parsedEquation = $this->parseEquation($equation);
        $intermediateCalculationContainer = [];	
        
        /**
         * At this point the queue, for this example equation
         * 2 + 4 * 3 + 5 + 1 
         * contains the follow
         * 
         * 2
         * 4
         * 3
         * mul
         * add
         * 5
         * add
         * 1
         * add
         */
        while (count($parsedEquation) > 0) {
            // The first element we added to the queue
            $token = array_shift($parsedEquation);
            	
            if (is_numeric($token)) {
                $intermediateCalculationContainer[] = $token;
            } else {
                if (count($intermediateCalculationContainer) >= 2) {
                    $firstNumber = array_pop($intermediateCalculationContainer);
                    $secondNumber = array_pop($intermediateCalculationContainer);
                } else {
                    throw new \Exception('Not enough operands on the stack');
                }
                
                $intermediateCalculationContainer[] = call_user_func([
                    'SrCalculator\Math\Math', $token
                ], $firstNumber, $secondNumber);
            }
        }
        
        // At this point, inside the stack, we have only the final result
        return array_pop($intermediateCalculationContainer);
    }
    
    /**
     * We transform from this
     * 2 + 4 * 3 + 5 + 1 
     * 
     * to this
     * 
     * 2
     * 4
     * 3
     * mul
     * add
     * 5
     * add
     * 1
     * add
     */
    private function parseEquation(string $equation) 
    {
        $length = strlen($equation);
        $equationParts = [];
        $operandTemporaryContainer = [];
        
        for ($i = 0; $i < $length; $i++) {
            $token = $this->getToken($equation, $i);
            if(is_numeric($token)) {
                $equationParts[] = $token;
            } else {
                if(!in_array($token, $this->validTokens)) {
                    throw new \Exception('Not a valid token');
                }

                while($lastAddedOperand = $this->readLastAddedOperand($operandTemporaryContainer)) {
                    if (
                        self::$operators[$token]['assoc'] == 'left' &&
                        self::$operators[$token]['pre'] <= self::$operators[$lastAddedOperand]['pre']
                    ) {
                        $function = self::$operators[$lastAddedOperand]['function'];
                        $equationParts[] = $function;

                        /**
                         * Se lo abbiamo aggiunto, dobbiamo rimuoverlo
                         */
                        array_pop($operandTemporaryContainer);
                    } else {
                        break;
                    }
                }
                $operandTemporaryContainer[] = $token;
            }
        }
            
        while (count($operandTemporaryContainer) > 0) {
            $operand = array_pop($operandTemporaryContainer);
            $function = self::$operators[$operand]['function'];
            $equationParts[] = $function;
        }
        
        return $equationParts;
    }

    private function readLastAddedOperand(&$operandTemporaryContainer) 
    {
        return count($operandTemporaryContainer) > 0 ? 
            $operandTemporaryContainer[count($operandTemporaryContainer)-1] : null;
    }
}
