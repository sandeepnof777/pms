<?php

// Live Config
// if (strstr($_SERVER['HTTP_HOST'], 'pms.pavementlayers.com')) {
//     return[
//         'authorizationRequestUrl' => 'https://appcenter.intuit.com/connect/oauth2',
//         'tokenEndPointUrl' => 'https://oauth.platform.intuit.com/oauth2/v1/tokens/bearer',
//         'client_id' => 'Q0I5cQBFtvPHiSXIdQnoItEPN5yZzWusyufLGdG9YdZlrxHxoZ',
//         'client_secret' => 'LQWdGYWHyirTrcTORWn836XwY8qOLD9ciZkLCS3G',
//         'oauth_scope' => 'com.intuit.quickbooks.accounting',
//         'openID_scope' => 'pavement.layer@gmail.com',
//         'oauth_redirect_uri' => 'https://pms.pavementlayers.com/OAuth_2/OAuth2PHPExample.php',
//         'openID_redirect_uri' => 'https://pms.pavementlayers.com/OAuth_2/OAuthOpenIDExample.php',
//         'mainPage' => 'https://pms.pavementlayers.com/account/qbsettings',
//         'refreshTokenPage' => 'https://pms.pavementlayers.com/OAuth_2/RefreshToken.php',
//         'baseUrl' => 'Production',
//         'loginPath' => 'https://pms.pavementlayers.com/account/qbsettings/qblogin',
//     ];
// }
// else {
//     return[ // Dev config
//         'authorizationRequestUrl' => 'https://appcenter.intuit.com/connect/oauth2',
//         'tokenEndPointUrl' => 'https://oauth.platform.intuit.com/oauth2/v1/tokens/bearer',
//         //'client_id' => 'L0C4EoRwlIIpDxX4jJHONwGIJmcdtRBltGSbg3F8KPoYkXvskh',
//         //'client_secret' => 'BrJ3E29aqtd69m9S9UGDVhmaHZ1Mda1LpDZL516q',
//         'client_id' => 'Q0I5cQBFtvPHiSXIdQnoItEPN5yZzWusyufLGdG9YdZlrxHxoZ',
//         'client_secret' => 'LQWdGYWHyirTrcTORWn836XwY8qOLD9ciZkLCS3G',

//         'oauth_scope' => 'com.intuit.quickbooks.accounting',
//         'openID_scope' => 'pavement.layer@gmail.com',
//         'oauth_redirect_uri' => 'https://staging.pavementlayers.com/OAuth_2/OAuth2PHPExample.php',
//         'openID_redirect_uri' => 'https://staging.pavementlayers.com/OAuth_2/OAuthOpenIDExample.php',
//         'mainPage' => 'https://staging.pavementlayers.com/account/qbsettings',
//         'refreshTokenPage' => 'https://staging.pavementlayers.com/OAuth_2/RefreshToken.php',
//         //'baseUrl' => 'development',
//         'baseUrl' => 'Production',
//         'loginPath' => 'https://staging.pavementlayers.com/account/qbsettings/qblogin',
//     ];
// }


if (strstr($_SERVER['HTTP_HOST'], 'pms.pavementlayers.com')) {
    return[
        'authorizationRequestUrl' => 'https://appcenter.intuit.com/connect/oauth2',
        'tokenEndPointUrl' => 'https://oauth.platform.intuit.com/oauth2/v1/tokens/bearer',
        'client_id' => 'ABNPRDBoN3yuoj0zhQzNJkTncvWyBkay0Kqa8mz1iXEiaz5Ltm3',
        'client_secret' => 'HlOvQL3Dmp9EUMEJwNeEfIWC19U57VYpTFizK1P9',
        'oauth_scope' => 'com.intuit.quickbooks.accounting',
        'openID_scope' => 'sandysvimmca@gmail.com',
        'oauth_redirect_uri' => 'https://local.pms.pavementlayers.com/OAuth_2/OAuth2PHPExample.php',
        'openID_redirect_uri' => 'https://local.pms.pavementlayers.com/OAuth_2/OAuthOpenIDExample.php',
        'mainPage' => 'https://local.pms.pavementlayers.com/account/qbsettings',
        'refreshTokenPage' => 'https://local.pms.pavementlayers.com/OAuth_2/RefreshToken.php',
        'baseUrl' => 'development',
        'loginPath' => 'https://local.pms.pavementlayers.com/account/qbsettings/qblogin',
    ];
}
else {
    return[ // Dev config
        'authorizationRequestUrl' => 'https://appcenter.intuit.com/connect/oauth2',
        'tokenEndPointUrl' => 'https://oauth.platform.intuit.com/oauth2/v1/tokens/bearer',
        'client_id' => 'ABNPRDBoN3yuoj0zhQzNJkTncvWyBkay0Kqa8mz1iXEiaz5Ltm3',
        'client_secret' => 'HlOvQL3Dmp9EUMEJwNeEfIWC19U57VYpTFizK1P9',
        'oauth_scope' => 'com.intuit.quickbooks.accounting',
        'openID_scope' => 'sandysvimmca@gmail.com',
        'oauth_redirect_uri' => 'https://local.pms.pavementlayers.com/OAuth_2/OAuth2PHPExample.php',
        'openID_redirect_uri' => 'https://local.pms.pavementlayers.com/OAuth_2/OAuthOpenIDExample.php',
        'mainPage' => 'https://local.pms.pavementlayers.com/account/qbsettings',
        'refreshTokenPage' => 'https://local.pms.pavementlayers.com/OAuth_2/RefreshToken.php',
        'baseUrl' => 'development',
        'loginPath' => 'https://local.pms.pavementlayers.com/account/qbsettings/qblogin',
    ];
}