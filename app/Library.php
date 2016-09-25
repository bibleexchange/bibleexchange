<?php namespace BibleExperience;

use Illuminate\Database\Eloquent\Model;
use DB; 
use BibleExperience\Core\UUIDTrait;

class Library extends BaseModel {
   
    use UUIDTrait;
    protected $table = 'libraries';
	
    public $timestamps = true;
	
    protected $fillable = ['title','description'];
	
    public function courses()
    {
	/*if($this->id === 1){
	  return $this->hasMany('\BibleExperience\BibleBook','library_id');
	}else{*/
	  return $this->hasMany('\BibleExperience\Course','library_id');
	//}
        
    }
		
   public function migrate(){
	/*
	DB::raw('CREATE TABLE `libraries` (`id` int(10) UNSIGNED NOT NULL,
	  `title` varchar(512) NOT NULL,
	  `description` varchar(1024) NOT NULL,
	  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
	) ENGINE=InnoDB DEFAULT CHARSET=latin1;');


	DB::raw("INSERT INTO `libraries` (`id`, `title`, `description`, `created_at`, `updated_at`) VALUES (1, 'The Holy Bible', 'Gods Holy Word unedited and unchanged.', '2016-09-20 23:49:03', '2016-09-20 23:49:03'),(2, 'Deliverance Center', '', '2016-09-20 23:49:14', '2016-09-20 23:49:14')");


	DB:raw("ALTER TABLE `libraries` ADD PRIMARY KEY (`id`);");



	DB:raw("ALTER TABLE `libraries` MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;");

*/
	//DB:raw("");





   }

}

