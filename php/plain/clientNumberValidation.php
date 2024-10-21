<?php
/*Objective
A bank want to implement a method to validate their client numbers. Implement a ParityBitPhp class with a validateClientNumber($clientNumber) method to validate 10 digit client numbers that contain an even parity bit.
Lost your progress or you want to start from scratch? You can find the initial state of the source file here: Initial State

Scenario 1: Implement parity bit client number validation
Implement the validateClientNumber($clientNumber) function to validate 10 digit client numbers that contain an even parity bit.
A bank want to implement a method to validate their client numbers. A valid 10 digit client number must satisfy the following:
Contain only digits 0-9
Have a length of 10 digits
The last bit of the client number in binary form (parity bit) should make the total number of "1" in the entire number even
Given is the valid client number 8456894318. The binary form of the client number is 111111000000100011111011101101110. The total number of "1" is even (20).
When the validateClientNumber($clientNumber) function is called with 8456894318 it should return true.
Given is the invalid client number 3456848879. The binary form of the client number is 11001110000010110101001111101111. The total number of "1" is odd (19).
When the validateClientNumber($clientNumber) function is called with 3456848879 it should return false.
The validateClientNumber($clientNumber) should work for other client numbers as well.
The code should handle invalid input strings gracefully without throwing exceptions. Return false for any non digit characters or wrong length strings.
*/
namespace EntwicklerHeld;

class ParityBitPhp {
    static function validateClientNumber($clientNumber) {
        if(ctype_digit($clientNumber) && ((substr_count(decbin($clientNumber),1) % 2) == 0) && strlen($clientNumber) == 10) return true;
        return false;
    }
}