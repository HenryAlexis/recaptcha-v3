Class CaptchaV3 {
  /*
  * Function that gets data from the form when submitted is activated. 
  * $data = data fields 
  */
  public function submit($data){
    $captchaError=false;
    $token = $_POST["g-recaptcha-response"];
    $validate = json_encode($this->validateToken($token));
    if (!$validate) {
      print_r("It seems we can't validate your submission, contact admin");
      return false;
    }
    
    // Successful.... more code
  }
  
  /*
  * Function that will validate the token generated in the front end (html doc)
  * $token = captcha response value (public key)
  */
  function validateToken($token) {
		
		$secretKey = $GoogleCaptchaSecretKey; // replace this with the secret key
		$data = array('secret' => $secretKey, 'response' => $token);
		$url = 'https://www.google.com/recaptcha/api/siteverify';

		$options = array(
			'http' => array(
			  'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			  'method'  => 'POST',
			  'content' => http_build_query($data)
			)
		);

		$context  = stream_context_create($options);
		$response = file_get_contents($url, false, $context);
		$responseKeys = json_decode($response,true);
		header('Content-type: application/json');
		if($responseKeys["success"] && $responseKeys["score"]>5) {
			return true;
		} else {
			return false;
		}
	}

}
