<?php
$apiKey = '';
$phoneNumber = preg_replace('/\s+/', '', $_POST['phoneNumber']);
$message = 'To verify that this is you,';
$senderName = 'PUPGSREO';

$ch = curl_init();
$parameters = array(
    'apikey' => $apiKey,
    'number' => $phoneNumber,
    'message' => $message,
    'sendername' => $senderName
);
curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/otp');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($ch);
curl_close($ch);
// Parse the JSON response
$data = json_decode($output, true);

if (isset($data[0]['code'])) {
    $codeValue = $data[0]['code'];
    echo $codeValue;
} else {
     echo json_encode(['error' => 'Unable to retrieve OTP code from response: ' . curl_error($ch)]);
}
?>
