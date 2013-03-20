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
        $this->url = 'http://tekno.kompas.com/read/2013/03/17/12411186/Google.Glass.Bisa.Dipakai.Orang.Berkacamata';
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
       $news = $xpath->query('//*[contains(concat( " ", @class, " " ), concat( " ", "isi_artikel", " " ))]//p');
       foreach( $news as $n){
         $ad_Doc = new DOMDocument();
         $cloned = $n->cloneNode(TRUE);
         echo $cloned;
         echo "\n";
         $ad_Doc->appendChild($ad_Doc->importNode($cloned, True));
         $xpath = new DOMXPath($ad_Doc);         
         
         $result[] = $n->nodeValue;
         //$count++;
         //if ($count >9)
           //break; //we just need  10 results. Index starts from 0
       }
       exit;
       return $result;
   }

}
