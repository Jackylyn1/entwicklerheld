<?php

/*
Objective
A chatbot is something that replies to your messages. So you can chat with him. That's what we gonna do now. Excited?

Discuss this challenge in our subreddit
Lost your progress or you want to start from scratch? You can find the initial state of the source file here: Initial State

Scenario 1: Answer a message
Our Chatbot now has only one purpouse: To answer the message of the user. If a user sends a message to the chatbot, the function chat(string $message) of the Chatbot class gets called.
Hint: To see the content of the message you can use echo $message and you will see the message in the console at the bottom of the page.
Given is the $message Hi
To get to the name of your chatpartner and get more in contact, your answer to this message should be Hi :-) Who are you?. The answer is the return value of your function.

Scenario 2: Know the name of your chatpartner
After asking for the name of our chatpartner, he replies with his name.
Every chatpartner gets his own Chatbot instance, so if a chatpartner replies with a name, this name will never change and there will be no other names that you have to recognice in the conversation.
The reply looks like this: I'm Amanda. And who are you?.
To keep the conversation alive, you have to be polite and replies with: I'm happy to text you, Amanda. I am Chriss.. You can give your chatbot any name you want. But keep in mind that you choose a nice name.
This should work with other chatpartner names as well.

Scenario 3: Know what he/she likes
In order to know you chatpartner better, you want to recognize if she/he likes a thing or not.
Because you send the last message your chatpartner will ask you like this or that. He maybe only asks two things, but there is no limit in how many Do you like ... questions he could ask.
Your chatparnter sends you messages about things he likes and asks if you like them too: Hey, I like mango. Do you like mango too?.
How do you response? If the liked thing begins with a vowel, than you like the thing too. If it not begins with a vowel, you don't like it. Thats the basic rule.
For mango the reply looks like this: Sorry Amanda, I don't like mango.. The name should be the name from the message your partner introduced himself.
For the message Hey, I like apples. Do you like apples too? your reply should be You like apples? I really like apples too.
To improve your answers futher, and not only say yes or no, you should keep track, what things your partner likes. Maybe you store that into a list. The order of these things is also important, als we will see now.
When saying you don't like something, you may append an additional sentence about one of the last thing you liked.
The condition is, that the thing you liked in the past starts with the vowel that first appears in the thing that you are currently asked about.
For example your partner first asks you Hey, I like apples. Do you like apples too?. You like apples, you respond. Now he asks: Hey, I like mango. Do you like mango too?. You don't like mangos, but liked apples(which is starting with a, the first vowel occuring in mango) in the past, so you reply with: Sorry Amanda, I don't like mango. and add But I heard, you like apples.
If you don't find a thing in the list of things you get asked about in the past, that starts with the vowel first occuring in the current thing, you should not add an additional sentence.
If you find more than one thing, starting with the fist vowel occurence, you should take the "youngest" one.
So for the message Hey, I like cake. Do you like cake too? you should reply (you know, that she/he likes apples) Sorry Amanda, I don't like cake. But I heard, you like apples..
This should work with other names and things as well.
*/

declare(strict_types=1);

class Chatbot
{
    private $likedThings;
    private $name;
    private $vowels = ['a','e','i','o','u'];
    function chat(string $message): string
    {
        $messageParts = explode(' ', $message);
        return $this->handleMessages($messageParts);
    }

    function storeName(string $name):string {
        $this->name = $name;
        return 'I\'m happy to text you, ' . $this->name . '. I am Chriss.';
    }

    function getFirstVowel(string $string) {
        $pos = false;
        $bestVovel = false;
        foreach($this->vowels as $vowel){
            $vovelPos = strpos($string,$vowel);
            if(!empty($vovelPos) && ($vovelPos < $pos || $pos == false)){
                $pos = $vovelPos;
                $bestVovel = $vowel; 
            }
        }
        return $bestVovel;
    }

    function handleLike(string $likedObject){
        $firstLetter = substr($likedObject, 0, 1);
        if(in_array($firstLetter,$this->vowels)){
            $this->likedThings[$firstLetter][] = $likedObject;
            return 'You like ' . $likedObject . '? I really like ' . $likedObject . ' too.';
        }
        $string = 'Sorry ' . $this->name . ', I don\'t like ' . $likedObject . '.'; 
        $lastLikedArray = $this->likedThings[$this->getFirstVowel($likedObject)];
        if(!empty($lastLikedArray)){
            $lastLiked = end($lastLikedArray);
            if($lastLiked){
                return $string . ' But I heard, you like ' . $lastLiked . '.'; 
            }
        }
        return $string;
    }

    function handleMessages($messageParts){
        foreach($messageParts as $part){
            if(strcmp($part,'Hi') == 0) { return 'Hi :-) Who are you?'; }
            $nextPart = rtrim(next($messageParts), '.');
            if(strcmp($part, 'like') == 0){ return $this->handleLike($nextPart);}
            if(strcmp($part, "I'm") == 0){ return $this->storeName($nextPart);}
        }
    }
}

?>