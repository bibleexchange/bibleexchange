<?php namespace BibleExperience\Http\Controllers;

use Input, Redirect, stdClass;
use BibleExperience\BibleReference;
use Request;
use BibleExperience\Note;

class ReactController extends BaseController {

  public function __construct() {


    $this->meta = new stdClass;

    $this->meta->title = 'Bible Exchange';
    $this->meta->keywords = "faith, hope, bible, study, learn";
    $this->meta->author = "Deliverance Center";
    $this->meta->description = 'Bible exchange is your companion in discovery. Equip yourself to better know and share your faith in Jesus Christ by engaging in Biblical conversation.';//No more than 155 characters
    $this->meta->logo = 'https://bible.exchange/images/be_logo.png';
    $this->meta->shareImage = 'https://bible.exchange/assets/img/be_logo.png';//Twitter summary card with large image must be at least 280x150px
    $this->meta->siteName = 'Bible exchange';
    $this->meta->publisherTwitterHandle = '@bible_exchange';
    $this->meta->authorTwitterHandle = '@mjamesderocher';
    $this->meta->url = Request::url(); //current url
    $this->meta->articlePublished = '2015-02-25T19:08:47+01:00';//2013-09-16T19:08:47+01:00
    $this->meta->articleModified = '2015-02-25T19:08:47+01:00';//2013-09-16T19:08:47+01:00
    $this->meta->facebookAppId = '1529479753993292';
    $this->meta->articleSection = 'Home of Bible exchange';
    $this->meta->themeColor = "#00c97b";//green
  }
  
  public function index() {

    return view('react', [
      'meta' => $this->getMeta(),
      'pageTitle'=>'Bible exchange | Your Place for Bible Sharing and Discovery'
		]);
  }
  
    
  public function getMeta(){
    $meta = $this->meta;

    $metas = [];
    $i = 0;

    $metas[$i] = ["name"=>"keywords", "property"=>"kewords", "content"=>$meta->keywords];
    $metas[$i++] = ["name"=>"author", "property"=>"author", "content"=>$meta->author];
    $metas[$i++] = ["name"=>"title", "property"=>"title", "content"=>$meta->title];

    $metas[$i++] = ["property"=>"og:title", "content"=>$meta->title];
    $metas[$i++] = ["property"=>"og:image", "content"=>$meta->shareImage];
    $metas[$i++] = ["property"=>"og:site_name", "content"=>$meta->siteName];
    $metas[$i++] = ["property"=>"og:description", "content"=> $meta->description];
    $metas[$i++] = ["property"=>"og:url", "content"=>$meta->url];

    
    $metas[$i++] = ["name"=>"twitter:card","content"=>"summary"];
    $metas[$i++] = ["name"=>"twitter:site","content"=>$meta->publisherTwitterHandle];
    $metas[$i++] = ["name"=>"twitter:title","content"=>$meta->title];
    $metas[$i++] = ["name"=>"twitter:description","content"=>$meta->description];
    $metas[$i++] = ["name"=>"twitter:image","content"=>$meta->shareImage];


    $metas[$i++] = ["name"=>"application-name", "property"=>"application-name", "content"=>$meta->siteName];
    $metas[$i++] = ["name"=>"og:type", "property"=>"og:type", "content"=>"application"];
    $metas[$i++] = ["name"=>"fb:app_id", "property"=>"facebook-app-id", "content"=>$meta->facebookAppId];

    $metas[$i++] = ["name"=>"msapplication-TileColo", "content"=>$meta->themeColor];
    $metas[$i++] = ["name"=>"msapplication-TileImag", "content"=> $meta->logo];
    $metas[$i++] = ["name"=>"theme-color", "content"=> $meta->themeColor];

    //Windows Phone **
    $metas[$i++] = ["name"=>"msapplication-navbutton-color", "content"=> $meta->themeColor];

    // iOS Safari
    $metas[$i++] = ["name"=>"apple-mobile-web-app-capable", "content"=> "yes"];
    $metas[$i++] = ["name"=>"apple-mobile-web-app-status-bar-style", "content"=> "black-translucent"];


    return $metas;
  }
    public function note($noteId) {

      $code = explode(':',base64_decode($noteId));

        $note = Note::find($code[1]);
        $this->meta = $note->getMeta($this->meta);

    return view('react', [
      'meta' => $this->getMeta(),
      'pageTitle'=> $this->meta->title
    ]);
  }

      public function course($courseId) {

    return view('react', [
      'meta' => $this->getMeta(),
      'pageTitle'=>  $this->meta->title
    ]);
  }

      public function bible($reference) {

        $ref = new BibleReference($reference);
        $this->meta = $ref->getMeta($this->meta);

    return view('react', [
      'meta' => $this->getMeta(),
      'pageTitle'=>  $this->meta->title
    ]);
  }

}
