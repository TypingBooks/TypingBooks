<?php

return [
    
    // order_7-1-20
    
    //'p2_4' => 'A normal book can have up to a 4 million characters. When creating a translation, we only
    //           charge the exact amount that it costs us to create this translation with Google. In the 
    //          future, we might create translations with more providers, but at the moment, we 
    //          only support Google Translate.',
    //
    'p2_4_replacement' => 'A normal book can have over a million characters. When creating a translation, we charge ' .
                           'the amount that it costs us to create this translation with Google. In addition to charging ' .
                           // The service fee should really be passed into here, and not hard coded..
                           // Though, I think google translate might be able to provide a better translation with it included
                           'that amount, we also charge a $5 (USD) service fee to cover transaction fees, and to help pay ' . 
                           'server fees.',
    'f3' => 'Service fee ($5 USD)',
    //'p5_2' => 'If you are not happy with the translation we obtain, we will not be able to refund the money 
    //           used for a translation because it will have been spent entirely with our translation provider.',
    'p5_2_replacement' => 'If you are not happy with the translation we obtain, we will not be able to refund the money ' .
                          'used for the translation because it will have been spent almost entirely with our translation ' .
                          'provider.',
    'service_fee' => 'Service Fee',
 
    
];

?>