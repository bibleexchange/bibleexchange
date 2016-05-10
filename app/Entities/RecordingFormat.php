<?php namespace BibleExchange\Entities;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class RecordingFormat extends Model {

	use PresentableTrait;
	
	protected $table = 'recording_formats';
	
	//protected $appends = ['stream'];
	
	protected $fillable = [ 'recording_id','file' , 'host' , 'format','memo' ];
	
	//protected $presenter = 'BibleExchange\Presenters\RecordingPresenter';
	
	protected $appends = ['stream','download'];
	
	public $timestamps = false;
	
	public static function make($recording_id, $file_name, $format, $memo){
		
		switch($format){
			
			case 'mp3':
				$host = 'local';
				break;
			case 'godaddy-mp3':
				$host = 'godaddy';
				break;
			case 'soundcloud-mp3':
			case 'soundcloud-m4a':
				$host = 'soundcloud';
				break;
			default:
				$host = 'local';
			
		}
		
		$format = RecordingFormat::create([
				'recording_id' => $recording_id,
				'file' =>  $file_name,
				'format' => $format,
				'host' => $host,
				'memo' => $memo
		]);
		
		return $format;
	}
	
	public function recording(){
		
		return $this->belongsTo('BibleExchange\Entities\Recording');
		
	}
	
	public function getDownloadAttribute()
	{
		if($this->format == 'soundcloud'){
			return '<a href="http://feeds.soundcloud.com/stream/'.$this->file.'">
					download
					</a>';
		}
		
		return null;
	}
	
	public function getStreamAttribute()
	{
			
		switch($this->format){
	
			case 'tape':
				$markup = 'Available <a target="_blank" href="mailto:?subject=cassette of sermon #'.$this->id.' request&body=Please, mail me a copy of this cassete. Please include your mailing address and consider donating.">
						&nbsp;by request </a> on cassette tape.';
				break;
	
			case 'mp3':
				$markup = 'Available as an email attachment. Email us a request for a mp3 file of recording #'.$this->recording_id;
				break;
					
			case 'godaddy-mp3':
				$markup = 'godaddy-mp3';
				break;
	
			case 'soundcloud-mp3':
			case 'soundcloud-m4a':
				$markup = '<div>
		    	<iframe width="100%" height="20" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/'.$this->file.'&amp;color=ff5500&amp;inverse=false&amp;auto_play=false&amp;show_user=true"></iframe>
		    	</div>';
					
				break;
	
			default:
				$markup = '';
	
		}
			
		return $markup;
	}

	public function scopeSoundcloud($query)
	{
		return $query->where('host', '=', 'soundcloud');
	}
	
}
