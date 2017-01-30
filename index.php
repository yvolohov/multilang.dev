<?php

require_once 'Tokenizer.php';

//$sentenceEn = 'Sherlock Holmes took his bottle from the corner of the mantel-piece and ' .
//    'his hypodermic syringe from its neat morocco case.';

$sentenceEn = 'The men outside shouted and applauded, while Beauty Smith, in an ecstasy ' .
    'of delight, gloated over the ripping and mangling performed by White Fang.';

$wordsEn = Tokenizer::toString($sentenceEn);
$arrayEn = explode('|', $wordsEn);

echo print_r($arrayEn, True) . PHP_EOL;