<?php

class Wiskunde {

    function add($a, $b) {
        return $a + $b;
    }

    function substract($a, $b) {
        return $a - $b;
    }

    function getOperator($a, $c) {
        if ($c <= $a) {
            return '-';
        }
        return '+';
    }

}

class WeegSchaal extends Wiskunde {

    private $_weightLeft;
    private $_weightRight;

    private $_availableWeights;

    function giveAvailableWeights($availableWeights) {
        $this->_availableWeights = $availableWeights;
    }

    function setWeight($left, $right) {
        $this->_weightLeft = $left;
        $this->_weightRight = $right;
    }

    function isBalanced() {
        if ($this->_weightLeft == $this->_weightRight) {
            return true;
        }
        return false;
    }

    function singleNumber() {
        $diffrence = abs($this->_weightLeft - $this->_weightRight);
        foreach ($this->_availableWeights as $weight) {
            if ($diffrence == $weight) {
                return $weight;
            }
        }
        return false;
    }

    function makeSingleArr($input, $weight, $opp) {
            $sum = $this->$opp($input, $weight);
            $operator = $this->getOperator($input, $sum);
            $single = array ('weight' => $input, 'opperator' => $operator, 'option' => $weight, 'result' => $sum);
            return $single;
    }

    function makeArray($input) {
        $array = array();
        foreach ($this->_availableWeights as $weight) {
            array_push($array, $this->makeSingleArr($input, $weight, 'add'));
        }
        foreach ($this->_availableWeights as $weight) {
            array_push($array, $this->makeSingleArr($input, $weight, 'substract'));
        }
        return $array;
    }

    function makeCombinedArray($left_arr, $right_arr) {
        $array = array ();
        for ($i=0; $i < count($left_arr); $i++) { 
            $left = $left_arr[$i];
            for ($j=0; $j < count($right_arr); $j++) { 
                $right = $right_arr[$j];
                if (($left['result'] == $right['result']) && ($left['option'] != $right['option'])) {
                    echo $left['weight'] . $left['opperator'] . $left['option'] . ' = ' . $left['result'] .
                    '   ' . $right['weight'] . $right['opperator'] . $right['option'] . ' = ' . $right['result'] . "\n";
                    array_push($array, $left);
                    array_push($array, $right);
                }
                
            }
        }
        return $array;
    }

    function combinedNumbers() {
        $left_weight_array = $this->makeArray($this->_weightLeft);
        $right_weight_array = $this->makeArray($this->_weightRight);

        $combined_num_arr = $this->makeCombinedArray($left_weight_array, $right_weight_array);

        if (count($combined_num_arr) == 0) {
            return false;
        }
        return true;
    }

    function canBalance($callback) {
        if ($callback) {
            return $callback;
        }
        return false;
    }

}

class Program {

    private $_inputHandler;
    private $_weegSchaal;

    function __construct() {
        $this->_inputHandler = new InputHandler();
        $this->_weegSchaal = new WeegSchaal();
    }

    function init() {
        $this->_inputHandler->init();
        $this->_weegSchaal->giveAvailableWeights($this->_inputHandler->get("input3"));
        $this->_weegSchaal->setWeight($this->_inputHandler->get("input1"), $this->_inputHandler->get("input2"));
    }

    function update() {

    echo "DEZE OPGAVE IS NOG NIET AF!! IK MOET ER NOG AAN WERKEN AUB NIET NAKIJKEN NOG ;)";
        // if ($this->_weegSchaal->isBalanced()) {
        //     echo 'Weegschaal balanced';
        // } else if ($this->_weegSchaal->canBalance($this->_weegSchaal->singleNumber())) {
        //     $weight = $this->_weegSchaal->canBalance($this->_weegSchaal->singleNumber());
        //     echo 'Weegschaal kan worden gebalanceerd als je er ' . $weight . ' bij of af doet' . "\n";
        // }

        // if ($this->_weegSchaal->canBalance($this->_weegSchaal->combinedNumbers())) {
        //     echo 'gelukt';
        // } else {
        //     echo 'weegschaal kan niet worde balanceert';
        // }
    }

}

class InputHandler {

    private $input1;
    private $input2;
    private $input3;

    function __construct() {
        global $argv;
        $this->input1 = $argv[1];
        $this->input2 = $argv[2];
        $this->input3 = $argv[3];
    }

    function init() {
        $this->explodeStringToArray($this->input3, ",");
    }

    function explodeStringToArray($string, $char) {
        $this->input3 = explode($char, $string);
    }

    function get($property_name) {
        return $this->$property_name;
    }

}

$program = new Program();
$program->init();
$program->update();


?>