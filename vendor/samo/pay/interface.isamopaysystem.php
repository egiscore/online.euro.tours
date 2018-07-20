<?php

interface ISamoPaySystem {
    /*
    $aMinimalParams = [
        'iSamoPayId'=>, // Your product ID
        'sCurrencyId'=>, // USD;RUB;EUR;...
        'fPrice'=>, // 100500.02 = float price
        'sDescription'=>, // Empty or your description
        'sLang'=>, // RU;EN;DE;..
        'sReturnUrl'=>, // Empty or your URL
    ]
    $return = [
        'iSamoPayId'=>,
        'code'=>0, // 0 - ok; > 0 - error code
        'info'=>'Success', // Error | Success
        'status'=>'Transaction Start', // Description operation status
        'redirect'=>'https://paysys.site/?bla=bla&...', // URL for redirect to pay form on pay system site
        'paySystemData'=>[...] // Data from pay system (for check status & etc..),
        'request'=>[...], // Full request to pay system
        'responce'=>[...], // Full responces from pay system
    ]
    */
    function Pay(array $aParams);

    /*
    $aMinimalParams = [
        'paySystemData'=>[...], // Data from pay system (from Pay method)
    ]
    $return = [
        'code'=>1, // 1 - payed; 2 - wait pay; 3 - cancel; 4 - hold; 5 - error code
        'info'=>'Payed', // Error | Payed | Cancel | Wait
        'status'=>'Transaction Complete', // Description operation status
        'transaction'=>'FSD9987BANKTRANSACTID43DJLK', // Transaction ID | Bank Order Id
        'request'=>[...], // Full request to pay system
        'responce'=>[...], // Full responces from pay system
    ]
    */
    function PayStatus(array $aParams);
}
