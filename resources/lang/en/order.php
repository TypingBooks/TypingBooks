<?php 

return [
  
    'donate' => 'Donate Translation',
    'p1' => 'This page allows you to donate the money required to translate a book.',
    'p2_1' => 'We use Google Translate as our main provider for translating books. ',
    'p2_2' => 'Currently, ',
    'p2_3' => 'Google charges us $20 per million characters',
    'p2_4' => 'A normal book can have up to a 4 million characters. When creating a translation, we only charge the exact amount that it costs us to create this translation with Google. In the future, we might create translations with more providers, but at the moment, we only support Google Translate.',
    'p3' => 'To perform a translation, we first build a dictionary of items using Google translate. If we already have a dictionary translation for a word, we will use that instead. After our dictionary is built with the first run through of the book, we run a translation again using full sentences from the book. This time through, we cannot use a predefined dictionary, because machine learning translation may pick up on some of the structure found within a sentence to provide a better translation.',
    'p4' => 'So in total, translations cost:',
    'f1' => 'Dictionary (All characters within the words in this book subtracted by the amount of characters found in our dictionary)',
    'f2' => 'Sentences (All characters in the book)',
    'p5_1' => 'Translations are not perfect. ',
    'p5_2' => 'If you are not happy with the translation we obtain, we will not be able to refund the money used for a translation because it will have been spent entirely with our translation provider.',
    'book' => 'Book',
    'author' => 'Author',
    'language' => 'Language',
    'translation' => 'Translation',
    'pricing' => 'Pricing',
    'characters_in_book' => 'Characters in book',
    'characters_in_words' => 'Characters in words',
    'amount_in_dictionary' => 'Amount in dictionary',
    'pricing_information' => 'Pricing Information',
    'total' => 'Total',
    
    
];

?>