<?php

/* Objective
The markdown exercise requires refactoring some messy code. There's a function that takes Markdown text as input and returns the equivalent HTML. Despite the code being convoluted and difficult to follow, it works fine and passes all tests. Your job is to rewrite this code to make it more readable and maintainable without breaking the existing functionality that the tests validate. The goal is improved code quality and understandability while preserving correctness.
Lost your progress or you want to start from scratch? You can find the initial state of the source file here: Initial State

Scenario 1: Refactor Markdown parser
The markdown exercise requires refactoring some messy code. There's a function that takes Markdown text as input and returns the equivalent HTML. Despite the code being convoluted and difficult to follow, it works fine and passes all tests. Your job is to rewrite this code to make it more readable and maintainable without breaking the existing functionality that the tests validate. The goal is improved code quality and understandability while preserving correctness.

The method parseMarkdown should take a markdown string and return an html string.
The code you have to refactor is in the file MarkdownParserPhpOld.php. Write your new code to MarkdownParserPhp.php.
Keep the functionality and edge cases of the old code but make it more "beautiful".
When the MarkdownParserPhp::parseMarkdown method is called with markdown:
This will be a paragraph
the result should be:
<p>This will be a paragraph</p>
When the MarkdownParserPhp::parseMarkdown method is called with markdown:
_This will be italic_
the result should be:
<p><em>This will be italic</em></p>
When the MarkdownParserPhp::parseMarkdown method is called with markdown:
__This will be bold__
the result should be:
<p><strong>This will be bold</strong></p>
When the MarkdownParserPhp::parseMarkdown method is called with markdown:
This will _be_ __mixed__
the result should be:
<p>This will <em>be</em> <strong>mixed</strong></p>
When the MarkdownParserPhp::parseMarkdown method is called with markdown:
# This will be an h1
the result should be:
<h1>This will be an h1</h1>
When the MarkdownParserPhp::parseMarkdown method is called with markdown:
## This will be an h2
the result should be:
<h2>This will be an h2</h2>
When the MarkdownParserPhp::parseMarkdown method is called with markdown:
### This will be an h3
the result should be:
<h3>This will be an h3</h3>
When the MarkdownParserPhp::parseMarkdown method is called with markdown:
#### This will be an h4
the result should be:
<h4>This will be an h4</h4>
When the MarkdownParserPhp::parseMarkdown method is called with markdown:
##### This will be an h5
the result should be:
<h5>This will be an h5</h5>
When the MarkdownParserPhp::parseMarkdown method is called with markdown:
###### This will be an h6
the result should be:
<h6>This will be an h6</h6>
When the MarkdownParserPhp::parseMarkdown method is called with markdown:
####### This will not be an h7
the result should be:
<p>####### This will not be an h7</p>
When the MarkdownParserPhp::parseMarkdown method is called with markdown:
* Item 1\n* Item 2
the result should be:
<ul><li>Item 1</li><li>Item 2</li></ul>
When the MarkdownParserPhp::parseMarkdown method is called with markdown:
# Header!\n* __Bold Item__\n* _Italic Item_
the result should be:
<h1>Header!</h1><ul><li><strong>Bold Item</strong></li><li><em>Italic Item</em></li></ul>
When the MarkdownParserPhp::parseMarkdown method is called with markdown:
# This is a header with # and * in the text
the result should be:
<h1>This is a header with # and * in the text</h1>
When the MarkdownParserPhp::parseMarkdown method is called with markdown:
* Item 1 with a # in the text\n* Item 2 with * in the text
the result should be:
<ul><li>Item 1 with a # in the text</li><li>Item 2 with * in the text</li></ul>
When the MarkdownParserPhp::parseMarkdown method is called with markdown:
# Start a list\n* Item 1\n* Item 2\nEnd a list
the result should be:
<h1>Start a list</h1><ul><li>Item 1</li><li>Item 2</li></ul><p>End a list</p>

Scenario 2: Fix nasty bug
There was a nasty bug in the code - hopefully it's easy to fix in your refactored code.

When the MarkdownParserPhp::parseMarkdown method is called with markdown:
This is a paragraph with # and * in the text
the result should be:
<p>This is a paragraph with # and * in the text</p>
*/

namespace EntwicklerHeld;

class MarkdownParserPhp {

    public static bool $lineIsInList = false;

    static function formatUnderscores($line){
        return preg_replace(['/(.*)__(.*)__(.*)/', '/(.*)_(.*)_(.*)/'], ['$1<strong>$2</strong>$3','$1<em>$2</em>$3'], $line);
    }

    static function wrapInListIfNeeded($line){
        if (!static::$lineIsInList) {
            static::$lineIsInList = true;
            return "<ul>" . $line;
        }
        return $line;
    }

    static function formatList($line){
        if (preg_match('/^\*(.*)/', $line, $matches)) {
            return static::wrapInListIfNeeded('<li>' . trim($matches[1]) . '</li>');
        }
        return $line;
    }

    static function formatHeadings($line){
        if (preg_match('/^#{1,6}(?!#)(.*)/', $line, $matches)) {
            $numHashes = substr_count($matches[0],'#') - substr_count($matches[1],'#');
            return '<h' . $numHashes . '>' . trim($matches[1]) . '</h' . $numHashes . '>';
        }
        return $line;
    }

    static function getULEndIfNeeded($line){
        if (static::$lineIsInList) {
            static::$lineIsInList = false;
            return "</ul>";
        }
        return;
    }

    static function parseMarkdown($markdown) {
        $lines = explode("\n", $markdown);

        foreach ($lines as &$line) {
            $line = static::formatHeadings($line);
            $line = static::formatUnderscores($line);
            $line = static::formatList($line);
            if (!preg_match('/<h|<ul|<p|<li/', $line)) {
                $line = static::getULEndIfNeeded($line) . "<p>$line</p>";
            }
        }
        $html = join($lines) . static::getULEndIfNeeded($line);
        return $html;
    }
}


/**
 * 
 *  The following Code was the Code BEFORE I started Refactoring!
 * 
 * 
 */

 namespace EntwicklerHeld;

 class MarkdownParserPhp {
     static function parseMarkdown($markdown) {
         $lines = explode("\n", $markdown);
 
         $isInList = false;
 
         foreach ($lines as &$line) {
             $hsubstr_count(string,substring,start,length)
             if (preg_match('/^#######(.*)/', $line, $matches)) {
                 
             } elseif (preg_match('/^######(.*)/', $line, $matches)) {
                 $line = "<h6>" . trim($matches[1]) . "</h6>";
                 continue;
             } elseif (preg_match('/^#####(.*)/', $line, $matches)) {
                 $line = "<h5>" . trim($matches[1]) . "</h5>";
                 continue;
             } elseif (preg_match('/^####(.*)/', $line, $matches)) {
                 $line = "<h4>" . trim($matches[1]) . "</h4>";
                 continue;
             } elseif (preg_match('/^###(.*)/', $line, $matches)) {
                 $line = "<h3>" . trim($matches[1]) . "</h3>";
                 continue;
             } elseif (preg_match('/^##(.*)/', $line, $matches)) {
                 $line = "<h2>" . trim($matches[1]) . "</h2>";
                 continue;
             } elseif (preg_match('/^#(.*)/', $line, $matches)) {
                 $line = "<h1>" . trim($matches[1]) . "</h1>";
                 continue;
             }
 
             if (preg_match('/\*(.*)/', $line, $matches)) {
                 if (!$isInList) {
                     $isInList = true;
                     $isBold = false;
                     $isItalic = false;
                     if (preg_match('/(.*)__(.*)__(.*)/', $matches[1], $matches2)) {
                         $matches[1] = $matches2[1] . '<strong>' . $matches2[2] . '</strong>' . $matches2[3];
                         $isBold = true;
                     }
 
                     if (preg_match('/(.*)_(.*)_(.*)/', $matches[1], $matches3)) {
                         $matches[1] = $matches3[1] . '<em>' . $matches3[2] . '</em>' . $matches3[3];
                         $isItalic = true;
                     }
 
                     $line = "<ul><li>" . trim($matches[1]) . "</li>";
                 } else {
                     $isBold = false;
                     $isItalic = false;
                     if (preg_match('/(.*)__(.*)__(.*)/', $matches[1], $matches2)) {
                         $matches[1] = $matches2[1] . '<strong>' . $matches2[2] . '</strong>' . $matches2[3];
                         $isBold = true;
                     }
 
                     if (preg_match('/(.*)_(.*)_(.*)/', $matches[1], $matches3)) {
                         $matches[1] = $matches3[1] . '<em>' . $matches3[2] . '</em>' . $matches3[3];
                         $isItalic = true;
                     }
 
                     $line = "<li>" . trim($matches[1]) . "</li>";
                 }
             }
 
             if (!preg_match('/<h|<ul|<p|<li/', $line)) {
                 if ($isInList) {
                     $line = "</ul>" . "<p>$line</p>";
                     $isInList = false;
                 }
                 else {
                     $line = "<p>$line</p>";
                 }
             }
 
             if (preg_match('/(.*)__(.*)__(.*)/', $line, $matches)) {
                 $line = $matches[1] . '<strong>' . $matches[2] . '</strong>' . $matches[3];
             }
 
             if (preg_match('/(.*)_(.*)_(.*)/', $line, $matches)) {
                 $line = $matches[1] . '<em>' . $matches[2] . '</em>' . $matches[3];
             }
         }
         $html = join($lines);
         if ($isInList) {
             $html .= '</ul>';
         }
         return $html;
     }
 }