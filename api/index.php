<?php
$_POST = json_decode(file_get_contents('php://input'), true);

if (isset($_POST) && isset($_POST['g-token'])) {
    $secretKey = '6LcY97onAAAAAA_Vrq6fGJ9L8HcH_2idyOklIOAe';
    $token = $_POST['g-token'];
    $ip = $_SERVER['REMOTE_ADDR'];

    $url = "https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$token."&remoteip=".$ip;
    $request = file_get_contents($url);
    $response = json_decode($request); 

    header("Access-Control-Allow-Origin: https://web1-21880277.vercel.app");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    
    if ($response->success && $response->action == 'submit' && $response->score >= 0.5) {
        header('HTTP/1.1 200 OK');
    } else {
        header('HTTP/1.1 401 Unauthorized');
    }
    
    echo json_encode($response);
    exit();
} 
?>