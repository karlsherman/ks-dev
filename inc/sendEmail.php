<?php

	$siteOwnersEmail = 'ksherman@gmail.com';

	require 'vendor/autoload.php';
	use \Mailjet\Resources;
	$mj = new \Mailjet\Client('7963d652cf4f90d4357c65055cd443a3','f5ff553dafabc60ca201846f94ab97d0',true,['version' => 'v3.1']);

if($_POST) {

	$name = trim(stripslashes($_POST['form-name']));
	$email = trim(stripslashes($_POST['form-email']));
	$subject = "Contact Form Response";
	$contact_message = trim(stripslashes($_POST['form-text-field']));
  $captcha=$_POST['g-recaptcha-response'];
  $secretKey = "6LfBjAAVAAAAABaU9q9WKj1HNi1KiP4PsKASXO3a";
  $ip = $_SERVER['REMOTE_ADDR'];
  // post request to server
  $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
  $responseCaptcha = file_get_contents($url);
  $responseKeys = json_decode($responseCaptcha,true);
  $body = [
    'Messages' => [
      [
        'From' => [
          'Email' => "ks@karlsherman.com",
          'Name' => "Karl Sherman"
        ],
        'To' => [
          [
            'Email' => "ks@karlsherman.com",
            'Name' => "Karl Sherman"
          ]
        ],
        'Subject' => "Subject",
        'TextPart' => "Ths is where the text will go",
        'HTMLPart' => "<b>Name: </b>$name<br>
					  <b>Email: </b>$email<br>
					  <b>Subject: </b>$subject<br>
					  <b>Message:</b><br>$contact_message<br>",
        'CustomID' => "AppGettingStartedTest"
      ]
    ]
  ];
  if($responseKeys["success"]) {
    $response = $mj->post(Resources::$Email, ['body' => $body]);
    //$response->success() && var_dump($response->getData());
    header('Location: ../index.html');
} else {
    echo '<h2>Please mark wether you are a bot or not!</h2>';
}
header('Refresh: 3; URL=../index.html#contact');
}

?>