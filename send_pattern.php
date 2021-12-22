<?php
$token='سلمان';
$receptor='09388985617';
$template='dastan';
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.kavenegar.com/v1/4F4130624C764757556A6A755A7043516851416D36466D5573506948676C6434454A6B71696E61447048343D/verify/lookup.json',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => array('token' => $token,'receptor' => $receptor,'template' => $template),
));
$response = curl_exec($curl);

curl_close($curl);
echo $response;
