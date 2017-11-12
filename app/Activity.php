<?php namespace BibleExperience;

use stdClass;
use BibleExperience\BibleVerse;
use GrahamCampbell\Markdown\Facades\Markdown;

class Activity extends BaseModel {

  public $timestamps = true;
  protected $table = 'activities';
  protected $fillable = ['lesson_id','config', 'data', 'order_by', 'created_at', 'updated_at'];
  protected $appends = ['body','swahiliBody'];

  public function lesson() {
    return $this->belongsTo('\BibleExperience\Lesson');
  }

  public function statements() {
    return $this->hasMany('\BibleExperience\Statement');
  }

  public static function getJson($string){
    return json_decode($string);
  }

  public function getFileByLanguage($file_name, $lang = "ENGLISH"){
          switch($lang){
              case 'ENGLISH':
                return file_get_contents($file_name);
                break;
              case 'SWAHILI':
                //http://localhost/bin/courses/doctrine-3/0001_cover.md
               $file_name2 = str_replace("bin/courses",'bin/courses/translations',$file_name);
               $file = @file_get_contents($file_name2);

                if($file !== false){
                  return $file;
                }else{
                  //return file_get_contents($file_name);
                }
                break;

              default:
                return file_get_contents($file_name);

            }
  }

public function getBody($lang = "ENGLISH"){
        $config = json_decode($this->config);
        $body = new stdClass;
        $body->template = null;
        $body->props = null;
        $body->lang = $lang;

        if(is_object($config)){
        switch($config->template){

          case "READ_THIS_HTML_FILE":
            $body->template = 'READ_THIS';
            $body->props = $this->getFileByLanguage($config->data, $body->lang);
            break;

          case "READ_THIS_HTML":
            $body->props = $config->data;
            $body->template = 'READ_THIS';
            break;

          case "READ_THIS_MD_FILE":
          //add logic for Languages HERE
          //both swahili and english
            $body->props = Markdown::convertToHtml($this->getFileByLanguage($config->data, $body->lang));
            $body->template = 'READ_THIS';
            break;

          case "READ_THIS_MD":
            $body->props = Markdown::convertToHtml($config->data);
            $body->template = 'READ_THIS';
            break;

          case "READ_THIS_REFERENCE":

            $verses = BibleVerse::findVersesByReference($config->data);
            $body->template = $config->template;
            $body->props = new stdClass;
            $body->props->reference = $config->data;

            $body->props->verses = [];

            foreach($verses AS $v){
              $verse = new stdClass;
              $verse->id = $v->id;
              $verse->reference = $v->reference;
              $verse->bookNumber = $v->bookNumber;
              $verse->chapterNumber = $v->chapterNumber;
              $verse->verseNumber = $v->verseNumber;
              $verse->body = $v->body;

              $body->props->verses[] = $verse;
            }
            break;

          case "QUIZ_THIS":
            $body->props = $config->data;
            $body->template = $config->template;
            break;

          case "QUIZ_THIS_FILE":
            $body->props = file_get_contents($config->data);
            $body->template = 'QUIZ_THIS';
            break;

          default:
            $body->template = 'READ_THIS';
            $body->props = Markdown::convertToHtml($this->config);
        }

        }else {
            $body->template = 'READ_THIS';
            $body->props = Markdown::convertToHtml($this->config);
        }
      
      return $body;
}

public function getSwahiliBodyAttribute(){
        $body = $this->getBody("SWAHILI");
        $string = json_encode($body);
        return $string;
}

    public function getBodyAttribute(){

      if($this->data !== null && $this->data !== ""){
        return $this->data;
      }else{

        $body = $this->getBody("ENGLISH");
        $string = json_encode($body);
        return $string;

        }


    }

}
