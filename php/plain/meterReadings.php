<?php
/*Objective
To start with our intelligent measuring systems we have to to parse our measurements into iterable objects. Let's translate the given csv.
Lost your progress or you want to start from scratch? You can find the initial state of the source file here: Initial State

Scenario 1: Implement validation for the parser
Before we start to parse the csv file, we should have a more detail look into the relevant data and implement a data validation in the static method isValid.

Given is the static method isValid which is called with different $meterReadings.
Each meter entry has the following fields:
ID	Number for identification
clientId	The id of the client
createdAt	CreationDate (m/d/yyyy) of the meter reading entry
readAt	Date of the reading (m/d/yyyy)
deletedAt	Date of the deletion (m/d/yyyy)
type	Type of of the meter (electricity,gas,water)
source	Source of the meter
value	Value of the meter reading
valid	valid (true/false)
When the isValid method is called with a meter reading $meterReading
Then it should validate the following rules:
clientId	Should not be empty
deletedAt	Should be empty
type	Should not be empty
value	Should be a numeric value
valid	should be set to true
When the rules are not fulfilled, isValid should return false
When the rules are fulfilled, isValid should return true
This should work with other $meterReadings as well.

Scenario 2: Implement our first parser
Now that we know about the data and have implemented a validation, let us implement our first iterator class which inherit from the abstract class BaseCsvIterator (implements the base functionalities of an iterator). It should use the fgetcsv method to read the csv file.
Given is an abstract class BaseCsvIterator which implements the \Iterator and \Countable Interface.
There is also given a csv (comma separated) file with some entries.
The columns of the csv are the following:
ID	Is also the number of the line
clientId	The id of the client
createdAt	CreationDate (m/d/yyyy) of the meter reading entry
readAt	Date of the reading (m/d/yyyy)
deletedAt	Date of the deletion (m/d/yyyy)
type	Type of of the meter (electricity,gas,water)
source	Source of the meter
value	Value of the meter reading
valid	valid (true/false)
If we instantiate a PhpCsvIterator Object
The __construct should read in the file with the given $csvFilePath with the method fgetcsv and transfer the csv columns (ID, clientId ...) into the $data array e.g.:
    [0] => Array
    (
        [id] => 20
        [clientId] => 3
        [createdAt] => 8/18/2019
        [readAt] => 9/1/2018
        [deletedAt] =>
        [type] => gas
        [source] => call
        [value] => 13037.12
        [valid] => true
    )
    ...
Hint: Use the column names as keys.
Of course the performance of your parser is also important. It should parse the result faster than 100 ms!
This should work with other csv files as well.
Attention: Please copy your solution. You will need your code in the next Stage :-) */

declare(strict_types=1);

namespace EntwicklerHeld;

use Exception;

class CustomCsvParser extends BaseCsvIterator
{
    public $data = [];

    public static function isValid(array $row): bool
    {
        return !empty($row['clientId'])
            && !empty($row['type'])
            && !empty($row['value'])
            && empty($row['deletedAt'])
            && is_numeric($row['value']);
    }

    public static function toBool(string $val){
        return ($val === 'true');
    }

    public function getCSVRow(array $rowData, array $header){
        $data = [];
        foreach($rowData as $key => $value){
            if($header[$key] === 'valid') $value = self::toBool($value);
            $data[$header[$key]] = $value;
        }
        return $data; 
    }

    public static function getCSVDataFromLine(string $line){
        $line = str_replace(PHP_EOL, null, $line);
        return explode(',', $line);
    }

    public function __construct(string $csvFilePath)
    {
        $csvFile = \fopen($csvFilePath, 'r');
        $header = self::getCSVDataFromLine(fgets($csvFile));
        if($csvFile)
            while($rowData = fgets($csvFile)){
                $rowData = self::getCSVDataFromLine($rowData);
                $this->data[] = $this->getCSVRow($rowData, $header);
            }
    }
}