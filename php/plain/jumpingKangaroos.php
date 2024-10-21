<?php
/*
Objective
Let’s imagine this row of squares as an array of non-negative integers. You start at the first index of the array. Each number represents your maximum jump length at that position. Aim is to reach the last index. The number at the last index doesn’t have any effect.


Scenario 1: You only need one jump
In the first scenario you only have to decide if you can reach the last index or not by jumping once.

Given is an array numbers = [2,0,3]. From the first index you can directly jump to the last index with a jump length of 2.

The method isCompletable() should return true in this case.
Given is an array numbers = [1,0,1]. From the first index you can jump to the second. But then you are stuck because there is a 0.

Because you can't jump until the end, the method isCompletable() should return false .
This should work with other arrays as well.
Scenario 2: More jumps
In the second scenario you have to jump more than once. The possible jump length is always the number in the array where you currently are.

Given is an array numbers = [1,2,1,1]. From the first index you can jump to the second and then to the last.

The method isCompletable() should return true in this case.
Given is an array numbers = [2,0,1,0,3]. From the first index you can jump to numbers[2] but then you stuck because you would reach a 0.

The method isCompletable() should return false.
This should work with other arrays as well.
Scenario 3: Variable jumping lengths
In the third scenario you also decide whether or not it's possible to reach the last index but you can jump less than the number in the array.

Given is the array numbers = [2,2,0,1]. If you take the maximal jump length 2 and jump from the first index to numbers[2], you reach a 0. But if you jump from the first to the second index, you reach a 2 and can directly jump to the end.

In this case your method isCompletable() should return true .
Your algorithm should work with other arrays as well.
Scenario 4: Minimal number of jumps
Now your task is to calculate the minimal number of jumps you need to reach the last index.

Given is the array numbers = [3,2,0,1,2]. There are two possible ways to reach the aim. You can jump to numbers[1], then to numbers[3] until you reach the end with overall 3 jumps. Or you jump directly to numbers[3] and then to the end with just 2 jumps.

For this array your method getMinimalNumberOfJumps() should return 2 .
If there are no way to reach the end, your method should return 0.
Your algorithm should work with all other examples as well.
*/

declare(strict_types=1);

function isCompletable(array $numbers) {
    return numberOfSteps($numbers, 0, false);
}

function numberOfSteps(array $numbers, int $position, bool $returnNumbers = true){
    if(!isset($numbers[$position])) return true;
    $possibleSteps = $numbers[$position];
    if($possibleSteps == 0) return false;
    $result = false;
    while($possibleSteps > 0){
        $nextPosition = $position + $possibleSteps;
        if(numberOfSteps($numbers, $nextPosition) && $returnNumbers == false) return numberOfSteps($numbers, $nextPosition);
        if($returnNumbers == true){
            $additionalSteps = numberOfSteps($numbers, $nextPosition);
            if($additionalSteps != false && ($additionalSteps < $result || $result == false)) $result = $additionalSteps;
        }
        $possibleSteps--;
    }
    return $result;
}

function getMinimalNumberOfJumps(array $numbers){
    return numberOfSteps($numbers, 0);
}