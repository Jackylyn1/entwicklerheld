<?php

/*Objective
You are supposed to implement the "FizzBuzz" problem which is typically used for employment tests.
Lost your progress or you want to start from scratch? You can find the initial state of the source file here: Initial State

Scenario 1: Fizzbuzz function returns a number.
Given is a number which is not divisible by 3 or 5.
When the function is called with this number it should return the invoked number.

Scenario 2: Fizzbuzz function returns "fizz".
Given is a number which is divisible by 3.
When the function is called with this number it should return "fizz".

Scenario 3: Fizzbuzz function returns "buzz".
Given is a number which is divisible by 5.
When the function is called with this number it should return "buzz".

Scenario 4: Fizzbuzz function returns "fizzbuzz".
Given is a number which is divisible by 3 and 5.
When the function is called with this number it should return "fizzbuzz".
*/

declare(strict_types=1);

function fizzbuzz(int $number) {
    $returnvalue;
    if($number%3 === 0){
        $returnvalue = 'fizz';
    }
    if($number%5 === 0){
        return $returnvalue . 'buzz';
    }
    return ($returnvalue !== null)?$returnvalue:$number;
}