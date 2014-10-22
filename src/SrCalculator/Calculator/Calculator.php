<?php
namespace SrCalculator\Calculator; 

use \SrCalculator\Math\Math;

class Calculator 
    implements CalculatorInterface
{  
    /**
     * @var string
     */
    protected $equation;
    
    /**
     * The parsed equation as \SplQueue object
     * @var \SplQueue
     */
    protected $parsedEquation;
    
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
    
    public function __construct($equation = '') 
    {
        $this->setEquation($equation);
    }
    
    /**
     * 
     * @param string $equation
     * @return \SrCalculator\Calculator\Calculator
     */
    public function setEquation($equation = '') 
    {
        $equation = str_replace(' ', '', $equation);
        
        if (strlen($equation) < 1) {
            throw new \Exception('Equation is empty');
        }
    
        $this->equation = $equation;
        
        return $this;
    }
    
    /**
     * 
     * @return string
     */
    public function getEquation() 
    {
        return $this->equation;
    }
    
    /**
     * 
     * @param unknown $equation
     * @param unknown $i
     * @return string
     */
    public function getToken($equation, &$i) 
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
    
    /**
     * 
     */
    public function calculate() 
    {
        $this->parseEquation();
        
        
        
        // This variable will contain the intermediate calculation of the equation
        $stack = new \SplStack();	
       
        // Working with a clone of the queue so we'll keep the original
        $equationClone = clone $this->parsedEquation;
        
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
        while ($equationClone->count() > 0) {
            // The first element we added to the queue
            $token = $equationClone->shift();
            	
            if (is_numeric($token)) {
                $stack->push($token);
            } else {
                if ($stack->count() >= 2) {
                    $op1 = $stack->pop();
                    $op2 = $stack->pop();
                } else {
                    throw new \Exception('Not enough operands on the stack');
                }
                
                $stack->push(call_user_func(array('SrCalculator\Math\Math', $token), $op2, $op1));
            }
        }
        
        // At this point, inside the stack, we have only the final result
        return $stack->pop();
    }
    
    private function parseEquation() 
    {
        $length = strlen($this->equation);
        $queue = new \SplQueue();
        $stack = new \SplStack();
        
        for ($i = 0; $i < $length; $i++) {
            $token = $this->getToken($this->equation, $i);
            if(is_numeric($token)) {
                $queue->enqueue($token);
            } else {
                // We will manage here operator precedence
                // Last operator in the stack
                $op2 = $stack->count() > 0 ? $stack->top() : '';
                while (in_array($op2, $this->validTokens)) {
                    if (
                        self::$operators[$token]['assoc'] == 'left' &&
                        self::$operators[$token]['pre'] <= self::$operators[$op2]['pre']
                    ) {
                        $queue->enqueue(self::$operators[$op2]['function']);
                    } else {
                        break;
                    }
                
                    $stack->pop();
                    $op2 = ($stack->count() > 0) ? $stack->top() : '';
                }
                
                $stack->push($token);
            }
        }
        
        // while items on the stack, push to the queue
        while ($stack->count() > 0) {
            $queue->enqueue(self::$operators[$stack->pop()]['function']);
        }
        
        $this->parsedEquation = $queue;
    }
}
