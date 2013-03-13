<?php 
error_reporting(0);

class Crawler_Task {
    private $url;
    private $request_type;
    private $data;
    private $post_params;
    
    public function run($arguments)
    {
        // Do awesome notifying...
        $this->url = 'http://www.kompas.com/';
        $this->request_type = 'GET';
        $this->data = '';
        $this->post_params = array();
        $this->crawl()->parse();
    }

    public function crawl()
    {
      $curl = curl_init($this->url);
      curl_setopt($curl, CURLOPT_HEADER, false);
      curl_setopt($curl, CURLOPT_TIMEOUT, 60);
      curl_setopt($curl, CURLOPT_USERAGENT, 'cURL PHP');
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
      $this->data = curl_exec($curl);
      curl_close($curl);
      return $this; //make it a chainable method
    }     

    function parse(){
       $result = array();
       $count = 0;
       $dom = new DOMDocument;
       $dom->preserveWhiteSpace = false;
       $dom->loadHTML($this->data);
       $xpath = new DOMXPath($dom);
       $news = $xpath->query('//*[(@id = "jsddm")]//li[(((count(preceding-sibling::*) + 1) = 8) and parent::*)]//a');
       foreach( $news as $n){
           $result[] =   $n->nodeValue;
           $count++;
           if ($count >9)
               break; //we just need  10 results. Index starts from 0
       }
       var_dump($result);
       exit;
       return $result;
   }

}
