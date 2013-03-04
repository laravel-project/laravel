<?php

//capthca generator
//this use to implement captcha
class Captcha {

  public $captcha;
	public $get_captcha;

	public function __construct() {
		$this->captcha = str_shuffle('1234567890');
		$data = curl_init();
		curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($data, CURLOPT_URL, 'http://api.img4me.com/?text='
      .$this->captcha.'&font=arial&fcolor=000000&size=10&bcolor=FFFCFC&type=png');
		$url = curl_exec($data);
		$this->get_captcha = $url;
	}
		
  public static function generate(){
    $c = new Captcha();
    return Array('captcha' => $c->captcha, 'get_captcha' => $c->get_captcha);
  }
  
  public static function generate_view(){
    $c = Captcha::generate();
    $captcha = $c['captcha'];
    $get_captcha = $c['get_captcha'];
    return "<input type='hidden' value='".base64_encode($captcha)."' name='recaptcha'>
    <img src='".$get_captcha."' class='recaptcha-image img-rounded' /> 
    <a href='".url('/?registration')."'>refresh</a></br>
    <input type='text' name='recaptcha_field' placeholder='please input text above..'><br/>";
  }

  public static function valid($image_captcha, $text_captcha){
    return base64_encode($image_captcha) == $text_captcha;
  }
}

?>
