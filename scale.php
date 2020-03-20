<?php

class Wiskunde{
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

class WeegSchaal extends Wiskunde{
    public $left_weight; 
    public $right_weight; 

    public $diffrence_in_weights;
    
    public $log_message = "";

    public $other_weights; 

    function update() {

        $this->calcDiffrence();

        if ($this->isBalanced()) {
            $this->setMesssage("Weegschaal gebalanceert");
        } else {
            if ($this->canBalanceWith($this->searchWeightInArray($this->diffrence_in_weights))) {
                $this->setMesssage("WeegSchaal kan gebalanceerd worden als er $this->diffrence_in_weights bij of af komt \n");
                if ($this->canBalanceWith($this->getMultipleWeights())) {
                    $this->setMesssage("gelukt");
                }
            } else if ($this->canBalanceWith($this->getMultipleWeights())) {
                $this->setMesssage("gelukt");
            } else {
                $this->setMesssage("weegschaal kan niet gebalnceer worde");
            }
        }
    }

    function setMesssage($message) {
        $this->log_message = $this->log_message . $message;
    }

    function calcDiffrence() {
        $this->diffrence_in_weights = abs($this->substract($this->left_weight, $this->right_weight));
        return $this->diffrence_in_weights;
    }

    function giveAvailableWeights($availableWeights) {
        $this->other_weights = $availableWeights;
    }

    function setWeight($left, $right) {
        $this->left_weight = $left;
        $this->right_weight = $right;
    }

    function isBalanced() {
        if ($this->left_weight == $this->right_weight) {
            return true;
        }
        return false;
    }

    function searchWeightInArray($number) {
        foreach ($this->other_weights as $weight) {
            if ($number == $weight) {
                return $weight;
            }
        }
        return false;
    }

    function makeSingleArr($input, $weight, $opp) {
        $sum = $this->$opp($input, $weight);
        $operator = $this->getOperator($input, $sum);
        $single = array('weight' => $input, 'opperator' => $operator, 'option' => $weight, 'result' => $sum);
        return $single;
    }

    function makeArray($input) {
        $array = array();
        foreach ($this->other_weights as $weight) {
            array_push($array, $this->makeSingleArr($input, $weight, 'add'));
        }
        foreach ($this->other_weights as $weight) {
            array_push($array, $this->makeSingleArr($input, $weight, 'substract'));
        }
        return $array;
    }

    function makeCombinedArray($left_arr, $right_arr) {
        $array = array();
        for ($i = 0; $i < count($left_arr); $i++) {
            $left = $left_arr[$i];
            for ($j = 0; $j < count($right_arr); $j++) {
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

    function getMultipleWeights() {
        $left_weight_array = $this->makeArray($this->left_weight);
        $right_weight_array = $this->makeArray($this->right_weight);
        $combined_num_arr = $this->makeCombinedArray($left_weight_array, $right_weight_array);
        if (count($combined_num_arr) == 0) {
            return false;
        }
        return $combined_num_arr;
    }

    function canBalanceWith($callback) {
        if ($callback) {
            return $callback;
        }
        return false;
    }

    function draw() {
        echo $this->log_message;
    }

}

class Program{
    public $inputHandler;
    public $weegSchaal;

    function __construct() {
        $this->inputHandler = new InputHandler();
        $this->weegSchaal = new WeegSchaal();
    }

    function init() {
        $this->inputHandler->init();
        $this->weegSchaal->giveAvailableWeights($this->inputHandler->get("input3"));
        $this->weegSchaal->setWeight($this->inputHandler->get("input1"), $this->inputHandler->get("input2"));
    }

    function update() {
        $this->weegSchaal->update();
    }

    function draw() {
        $this->weegSchaal->draw();
    }
}

class InputHandler{
    public $input1;
    public $input2;
    public $input3;

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
$program->draw();
