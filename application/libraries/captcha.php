<?php

//capthca generator
//this use to implement captcha
class Captcha {

  public $captcha;
	public $get_captcha;

	public function __construct() {
		$this->captcha = str_shuffle('1234567890');
		$this->get_captcha = system('curl http://api.img4me.com/?text='
      .$this->captcha.'&font=arial&fcolor=FFBF00&size=10&bcolor=FFFCFC&type=png');
	}
		
  public static function generate(){
    $c = new Captcha();
    return Array('captcha' => $c->captcha, 'get_captcha' => $c->get_captcha);
  }
  
  public static function generate_view($captcha, $get_captcha){
    return "<input type='hidden' value='".base64_encode($captcha)."' name='recaptcha'>
    <img src='".$get_captcha."' class='recaptcha-image img-rounded' /></br>
    <input type='text' name='recaptcha_field' placeholder='please input text above..'><br/>";
  }

  public static function valid($image_captcha, $text_captcha){
    return base64_encode($image_captcha) == $text_captcha;
  }
}

?>
