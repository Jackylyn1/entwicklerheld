<?php

/*Objective
Personal data are stored in an app. These data should not be displayed in plain text. It should just be shown as much of the data that the user who knows the data can recognise them, but strangers can't identify them.

If the user has activated some kind of strong authentication, then the personal data does not need to be masked at all.

Your task is to implement this endpoint for the app.
After running the tests for each scenario, the app will be visually simulated. This allows you to check whether your implementation works as expected.
With the incognito button, you can switch the strong authentication on and off manually.

Lost your progress or you want to start from scratch? You can find the initial state of the source file here: Initial State

 Discuss this challenge in our subreddit

Scenario 1: Masking Personal Data
The endpoint consists of the function get_personal_data(string $user_id).
The personal data of a user can be fetched with the function get_user_by_id(string $user_id).
The personal data are returned as an associative array. The output of the function to be implemented shall also be an associative array containing all keys.
The following example shows the keys:
          
[
    "name" => "Max Mustermann",
    "street" => "Musterstrasse",
    "street number" => "101",
    "zip" => "12345",
    "city" => "Musterstadt",
    "email" => "meinemail@muster.de",
    "phone" => "0123 12345678",
    "reference account" => [
        "owner" => "Max Mustermann",
        "iban" => "DE1000123456789",
        "bic" => "ABC1DEF",
        "institution" => "Musterbank",
    ],
    "bank account" => "DE88500105175535615757",
]          
            

For reasons of safety, the personal data should not be entirely provided in plain text by the endpoint.
The data must be masked like this.

name - plain text
street - from char 3
Example: Mus**********
street number - plain text
zip - from char 3
Example: 123**
city - from start to last 3 chars
Example: ********adt
email - from start to @
Example: *********@muster.de
phone - from start to last 3 chars
Example: **********678
bank account - from char 2 to last 3 chars
Example: DE**********789
The data for the reference account should also be masked.

owner - plain text
iban - from char 3 to last 3 chars
Example: DE1*********789
bic - from start to last 3 chars
Example: ****DEF
institution - from char 3 to last 3 chars
Example: Mus****ank
Your implementation should also work on other user ids.

Scenario 2: Strong Authetication
Once the masking of the personal data is working, we consider the case where the user has configured a strong authentication. For this challenge, it is only important to consider this information. Whether a user has configured strong authentication can be retrieved using the function has_strong_authetication(string $user_id). The returned value of this function is a boolean value.
If a user has strong authentication enabled, all personal data shall be returned unmasked.

Scenario 3: Final Result
When your implementation has passed all tests, you will see the final result dislayed here. */

declare(strict_types=1);
include("user_data.php");

function get_personal_data(string $user_id): array {
    $user = get_user_by_id($user_id);
    if(has_strong_authetication($user_id)) return $user;
    $mask_from_to_collection = ['email' => [0,strpos($user['email'], '@')],'street' => [3], 'zip' => [3], 'city' => [0,-3], 'phone' => [0,-3], 'bic' => [0,-3],'bank account' => [2,-3],'iban' => [3,-3], 'institution' => [3,-3]];
    $data = mask_userdata($user, $mask_from_to_collection);
    return $data;
}

function mask_userdata(array $data, array $mask_from_to_collection):array{
    foreach($data as $key=>$value){
        if(gettype($data[$key]) == 'array'){
            $data[$key] = mask_userdata($data[$key], $mask_from_to_collection);
        } 
        else if(array_key_exists($key, $mask_from_to_collection)){
                $data[$key] = mask_string_from_to($data[$key], $mask_from_to_collection[$key]);
        }
    }
    return $data;
}

function mask_string_from_to(string $value, array $mask_from_to_positions):string{
        $masking_data = $mask_from_to_positions;
        array_unshift($masking_data, $value);
        $retval = substr($value, 0, $mask_from_to_positions[0]) . preg_replace('/./', '*', call_user_func_array('substr', $masking_data)) . (!empty($mask_from_to_positions[1])?substr($value, $mask_from_to_positions[1]):'');
        return $retval;
}

?>