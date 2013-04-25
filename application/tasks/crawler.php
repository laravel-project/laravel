<?php 
error_reporting(0);

class Crawler_Task {
    private $url;
    private $request_type;
    private $result;
    private $crawl_urls;
    
    private $origins_folder = 'public/img/articles/origins/';
    private $thumbs_folder  = 'public/img/articles/thumbs/';
    
    public function run($arguments)
    {
      //make new folder on articles
      system('mkdir '.$this->origins_folder);
      system('mkdir '.$this->thumbs_folder);
      
      // Do awesome notifying...
      $this->crawl_urls = CrawlUrl::find(1);
      $this->url = $this->crawl_urls->url;
      $this->crawl()->parse_parent();
      //resize thumbs images
      $this->compress_article_images();
    }

    public function crawl()
    {
      $curl = curl_init($this->url);
      curl_setopt($curl, CURLOPT_HEADER, false);
      curl_setopt($curl, CURLOPT_TIMEOUT, 60);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
      $this->result = curl_exec($curl);
      curl_close($curl);
      return $this; //make it a chainable method
    }     

    public function parse_parent()
    {
      $dom = new DOMDocument();
      $dom->preserveWhiteSpace = false;

      $dom->loadHTML($this->result);
      $xpath = new DOMXPath($dom);
      //get characteristic content body xpath
      $content_id = Characteristic::where_name('content body')->select('id')
        ->first()->id;
      $xpath_text = $this->get_xpath($content_id);
      //get content body
      $content = $xpath->query($xpath_text)->item(0);
      //create a new dom document that contains content 
      $ad_Doc = new DOMDocument();
      $cloned = $content->cloneNode(TRUE);
      $ad_Doc->appendChild($ad_Doc->importNode($cloned, True)); 
      $xpath = new DOMXPath($ad_Doc);         
      //get all links in content dom
      $links = $xpath->query('//a');
      foreach($links as $link) 
      {
        //if article has already in database the skip this iteration, and 
        //continue next iteration
        if( Article::find_article_by_url($link->getAttribute('href')) )
        {
          continue;
        }
        
        if (!$cache[$link->getAttribute('href')])
        {
          $cache[$link->getAttribute('href')] = true;
          $this->url = $link->getAttribute('href');
          $this->crawl()->parse_content();
        }
      }
    }

    public function parse_content()
    {
      $dom = new DOMDocument();
      $dom->preserveWhiteSpace = false;
      $dom->loadHTML($this->result);
      $xpath = new DOMXPath($dom);
      
      //get xpath title, image, article and article content
      $title_id = Characteristic::where_name('title')->select('id')->first()->id;
      $xpath_title = $this->get_xpath($title_id);
      $img_id = Characteristic::where_name('picture')->select('id')
        ->first()->id;
      $xpath_img = $this->get_xpath($img_id);
      $article_id = Characteristic::where_name('article')->select('id')
        ->first()->id;
      $xpath_article = $this->get_xpath($article_id);
      $article_content_id = Characteristic::where_name('content article')->select('id')
        ->first()->id;
      $xpath_content_article = $this->get_xpath($article_content_id);
      
      //get title
      $title = trim($xpath->query($xpath_title)->item(0)->nodeValue);

      //if article has already in database then exit from this function
      if( Article::find_article_by_title($title) )
      {
        return;
      }
       
      //get content article
      $article = trim($xpath->query($xpath_article)->item(0)->nodeValue);
      //check if xpath images exist or not. If not exist, it means use 
      //article_content xpath to get the image  
      if ($xpath_img) {
        $img = $xpath->query($xpath_img)->item(0)->getAttribute('src');
      }
      else {
        $article_nodes = $xpath->query($xpath_content_article);
        foreach($article_nodes as $article_node) {
          //get image
          $ad_Doc = new DOMDocument();
          $cloned = $article_node->cloneNode(TRUE);
          $ad_Doc->appendChild($ad_Doc->importNode($cloned, True)); 
          $xpath = new DOMXPath($ad_Doc);
          if (!$xpath_img)
          {
            $xpath_img = '//img';
          }  
                
          $images = $xpath->query($xpath_img);
          //iterates in image array
          foreach ($images as $image) {
            // check height and width
            $img_property = getimagesize($image->getAttribute('src'));
            $width = $img_property[0];
            $height = $img_property[1];
            if($width >= 275 && $height >= 275) {
              $img = $image->getAttribute('src');
            }
          }
        }
      }
      $this->save_article($title, $article, $img);
    }
    
    //function to retrieve xpath from table crawl_characteristic
    private function get_xpath($characteristic_id)
    {
      $xpath = CrawlCharacteristic::
        get_xpath_by_url_and_characteristic($this->crawl_urls->id, 
        $characteristic_id);
      return $xpath;
    }

    //this function to save data to article table
    private function save_article($title, $content, $picture)
    {
      $article = new Article(); 
      $article->title = $title;
      $article->content = $content;
      $image = $this->save_image_to_folder($this->url, $picture);
      $article->image = $image;
      $article->article_url = $this->url;
      $article->crawl_url_id = $this->crawl_urls->id;
      $article->save_data();
    }
    
    //this is function to save image to folder
    //before save, it's must be convert article url to generate image name
    private function save_image_to_folder($url, $image)
    {
      $x = explode('/',$image);
      //find last on array and get image
      $image_full_name = explode('.', end($x) );
      $rand = str_shuffle("abcdefghijklmnopqrstufvxyz1234567890");
      $image_format = substr(end($image_full_name),0,3); //get image format JPG/PNG/GIF
      //name of image with random string
      $image_name = $rand.'.'.$image_format;
      system('wget -O '.$this->origins_folder.$image_name.' '.$image);
      //copy to thumbs folder
      system('cp '.$this->origins_folder.$image_name.' '.$this->thumbs_folder.$image_name);
      //return image name for naming the image into database;
      return $image_name;
    }
    
    private function compress_article_images()
    {
      system('mogrify -resize 275x275 '.$this->thumbs_folder.'*');
    }
}
