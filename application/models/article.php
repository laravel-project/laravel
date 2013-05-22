<?php

class Article extends Eloquent {
  public static $timestamps = true;
  
  public static $count_article;

	public function comments()
	{
		return $this->has_many('Comment');
	}

	public function category()
	{
		return $this->belongs_to('Category');
	}

	public function user()
	{
		return $this->belongs_to('User');
	}

	public function userlikes()
	{
		return $this->has_many('Userlike');
	}

	public function projects()
	{
		return $this->has_many('Project');
	}

  public function crawlurl()
  {
    return $this->belongs_to('CrawlUrl', 'crawl_url_id');
  }

  public function save_data()
  {
    $validation = $this->validates(Array('title' => $this->title, 
      'content' => $this->content));
    if ( !$validation->fails() )
    {
      //generate key_id
      $this->key_id = rand(268435456, 4294967295);
      $this->save();
    }
  }

  public function validates($input)
  {
    $rules = array('title' => 'required', 'content' => 'required');
    return Validator::make($input, $rules);
  }

  public static function find_article_by_url($url)
  {
    return Article::where_article_url($url)->select('id')->first(); 
  }

  public static function find_article_by_title($title)
  {
    return Article::where_title($title)->select('id')->first();
  }

  
  public static function get_articles($string=null, $offset=0, $first=false, 
    $limit=23, $article_id=null) {

    if ($string != null) {
      $all_article = Article::with('crawlurl')->where('content','REGEXP',$string)
        ->order_by('created_at', 'desc');
    }
    else if($article_id != null) {
      $all_article = Article::with('crawlurl')->where_in('id', $article_id)
        ->order_by('created_at', 'desc');
    }
    
    if ($first == true) {
      self::$count_article = $all_article->count();  
    }

    $temp_article = $all_article->skip($offset);

    if ($limit != null) {
      $temp_article = $temp_article->take($limit);
    }

    return $temp_article->get(array('articles.id', 
      'articles.key_id', 'articles.title', 'articles.image', 'articles.content', 
      'articles.article_url', 'articles.crawl_url_id'));
  }

}
