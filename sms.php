<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = $_POST['msisdn'];

    $apiUrl = 'https://webloginda.grameenphone.com/backend/api/v1/otp';

    // Initialize cURL session
    $ch = curl_init($apiUrl);

    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['msisdn' => $phone]));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json, text/plain, */*',
        'Accept-Encoding: gzip, deflate, br, zstd',
        'Accept-Language: en-US,en;q=0.9,bn;q=0.8',
        'Content-Type: application/x-www-form-urlencoded',
        'Origin: https://www.grameenphone.com',
        'Referer: https://www.grameenphone.com/',
        'Sec-CH-UA: "Not)A;Brand";v="99", "Google Chrome";v="127", "Chromium";v="127"',
        'Sec-CH-UA-Mobile: ?0',
        'Sec-CH-UA-Platform: "Windows"',
        'Sec-Fetch-Dest: empty',
        'Sec-Fetch-Mode: cors',
        'Sec-Fetch-Site: same-site',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36'
    ]);

    // Execute cURL session and get the response
    $response = curl_exec($ch);

    // Check for errors
    if (curl_errno($ch)) {
        $response = 'Curl error: ' . curl_error($ch);
    } else {
        // Format the response for better readability
        $response = json_encode(json_decode($response), JSON_PRETTY_PRINT);
    }

    // Close cURL session
    curl_close($ch);

    // Redirect back to the HTML page with the response
    header('Location: index.html?response=' . urlencode($response));
    exit;
} else {
    // Handle invalid request method
    header('Location: index.html?response=' . urlencode('Invalid request method.'));
    exit;
}
?>
