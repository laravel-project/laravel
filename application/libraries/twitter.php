<?php

class Twitter {
  private $oauth_token;
  private $oauth_token_secret;
  private $twitteroauth;
  private $oauth_verifier;
  private $consumer_key ;
  private $consumer_secret;
  private $username;

  function __construct() {
    $this->consumer_key = 'mfaGWg2CZy5fcNhnH74q2A';
    $this->consumer_secret = '2FmbbsNBxS2wNcWsJ8HTXGBAIoAe5DqbfbvBHNliOsc';
  }
  
  //this method is used request authorize to get oauth_token_secret
  // and oauth_token
  public function request_authorization() {
    $this->twitteroauth = new TwitterOAuth($this->consumer_key, 
      $this->consumer_secret);
    $request_token = $this->twitteroauth->getRequestToken('http://localhost:30/twitter_oauth');

    // Saving them into the session
    Session::put('oauth_token', 
      $request_token['oauth_token']);
    Session::put('oauth_token_secret', 
      $request_token['oauth_token_secret']);

    // If everything goes well..
    if($this->twitteroauth->http_code == 200){
        // Let's generate the URL and redirect
        $url = $this->twitteroauth->getAuthorizeURL($request_token['oauth_token']);
    } else {
        // It's a bad idea to kill the script, but we've got to know when there's an error.
        die('Something wrong happened.');
    }
    return $url;
  }
  
  //this method is used to get access token
  public function request_access_token() {
    $status = false;
    if (!empty($this->oauth_verifier) && !empty($this->oauth_token) && !empty($this->oauth_token_secret)) {
      $this->twitteroauth = new TwitterOAuth($this->consumer_key, $this->consumer_secret, 
        $this->oauth_token, $this->oauth_token_secret);
      $access_token = $this->twitteroauth->getAccessToken($this->oauth_verifier);
      //save to session access token
      Session::put('access_token', $access_token);
      $status = true;
      $user_info = $this->twitteroauth->get('account/verify_credentials');
      $this->username = $user_info->screen_name; 
    }

    return $status;
  }

  //this method is used to update status to tweeter
  public function update_tweet( $message=array() ) {
    $this->twitteroauth->post('statuses/update', $message);
  }

  //this method to set oauth_token
  public function set_oauth_token($oauth_token) {
    $this->oauth_token = $oauth_token;
  }

  //this method to set oauth_token_secret
  public function set_oauth_token_secret($oauth_token_secret) {
    $this->oauth_token_secret = $oauth_token_secret;
  }

  //this method is used to set oauth verifier
  public function set_oauth_verifier($oauth_verifier) {
    $this->oauth_verifier = $oauth_verifier;
  }

  //this method is used to get username
  public function get_username() {
    return $this->username;
  }

 
}

?>
