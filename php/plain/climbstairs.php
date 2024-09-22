<?php 
/*Objective
A staircase with n steps is to be climbed to the top by one person. The person may take either one or two steps at a time. How many different ways are there to get to the top? There are multiple ways to implement this. Perhaps you will find a particularly efficient method?
Discuss this challenge in our subreddit
Lost your progress or you want to start from scratch? You can find the initial state of the source file here: Initial State

Scenario 1: Look at the core of the problem
At first you should be aware that both a negative number of stairs and none stairs result in 0 ways.
Let's move on and look at a small number of stairs. Given is $numberOfStairs = 1.
You just can take the one stair, so the result of your function should be 1.
Now given is $numberOfStairs = 2.
Either you go both steps at once or one at a time. So your function should return 2.

Scenario 2: More stairs!
Given is $numberOfStairs = 3.
As you can see on the image, there are 3 different ways to reach the top. So your function should return 3.
This should work with other numbers as well.*/

declare(strict_types=1);

function climbingStairs(int $numberOfStairs) {
    $stairSteps = [0,1];
    if($numberOfStairs < 1) return 0;
    return stairSteps($numberOfStairs, $stairSteps);
}

function stairSteps(int $numberOfStairs, array $stairSteps){
    if(array_key_last($stairSteps) == $numberOfStairs + 1){
        return end($stairSteps);
    }
    $stairSteps[] = end($stairSteps) + array_slice($stairSteps, -2, 1)[0];
    return stairSteps($numberOfStairs, $stairSteps);
}
?>
