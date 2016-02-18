<?php namespace BibleExchange\Entities;
 
class Edit extends Eloquent {
	
	/*protected $fillable = array('sections_id','file_name','file_type','orderBy');*/
	
public static $firstYear = [
			7 =>['title' => 'Bible Atlas','id' => 7, 					'gather' => 20, 'format' => 0, 'dbRecords' => 0, 'divide' => 0, 'edit2' => 0, 'qs' => 0, 'graphics' => 0, 'translate' => 0],
			5 =>['title' => 'Bible Introduction','id' => 5, 			'gather' => 100, 'format' => 100, 'dbRecords' => 100, 'divide' => 100, 'edit2' => 80, 'qs' => 50, 'graphics' => 90, 'translate' => 1],
			9 =>['title' => 'Church History','id' => 9, 				'gather' => 100, 'format' => 100, 'dbRecords' => 100, 'divide' => 5, 'edit2' => 85, 'qs' => 90, 'graphics' => 70, 'translate' => 80], 
			11 =>['title' => 'Communication 1','id' => 301, 			'gather' => 70, 'format' => 0, 'dbRecords' => 0, 'divide' => 0, 'edit2' => 0, 'qs' => 0, 'graphics' => 0, 'translate' => 0], 
			10 =>['title' => 'Cults','id' => 300, 						'gather' => 100, 'format' => 0, 'dbRecords' => 0, 'divide' => 0, 'edit2' => 0, 'qs' => 0, 'graphics' => 0, 'translate' => 0], 
			8 =>['title' => 'Doctrine 1','id' => 8, 					'gather' => 100, 'format' => 90, 'dbRecords' => 100, 'divide' => 100, 'edit2' => 10, 'qs' => 50, 'graphics' => 0, 'translate' => 80], 
			12 =>['title' => 'Epistles 1','id' => 302, 					'gather' => 85, 'format' => 60, 'dbRecords' => 0, 'divide' => 0, 'edit2' => 0, 'qs' => 0, 'graphics' => 0, 'translate' => 0], 
			13 =>['title' => 'Homiletics 1','id' => 303, 				'gather' => 100, 'format' => 0, 'dbRecords' => 0, 'divide' => 0, 'edit2' => 0, 'qs' => 0, 'graphics' => 0, 'translate' => 0], 
			14 =>['title' => 'Life of Christ','id' => 304, 				'gather' => 30, 'format' => 0, 'dbRecords' => 0, 'divide' => 0, 'edit2' => 0, 'qs' => 0, 'graphics' => 0, 'translate' => 0], 
			6 =>['title' => 'Pentateuch','id' => 6, 					'gather' => 100, 'format' => 100, 'dbRecords' => 100, 'divide' => 100, 'edit2' => 60, 'qs' => 0, 'graphics' => 70, 'translate' => 90], 
			15 =>['title' => 'Personal Evangelism','id' => 305, 		'gather' => 100, 'format' => 0, 'dbRecords' => 0, 'divide' => 0, 'edit2' => 0, 'qs' => 0, 'graphics' => 0, 'translate' => 90], 
			16 =>['title' => 'Sunday School Evangelism','id' => 306, 	'gather' => 100, 'format' => 0, 'dbRecords' => 0, 'divide' => 0, 'edit2' => 0, 'qs' => 0, 'graphics' => 0, 'translate' => 95]
		];

public static $secondYear = [
			19 =>['title'=>'Acts','id' => 19, 					'gather' => 90, 'format' => 5, 'dbRecords' => 0, 'divide' => 0, 'edit2' => 0, 'qs' => 0, 'graphics' => 0, 'translate' => 0],
			21 =>['title'=>'Communication 2','id' => 21, 			'gather' => 0, 'format' => 0, 'dbRecords' => 0, 'divide' => 0, 'edit2' => 0, 'qs' => 0, 'graphics' => 0, 'translate' => 0],
			20 =>['title'=>'Dispensational Truth','id' => 20, 	'gather' => 0, 'format' => 0, 'dbRecords' => 0, 'divide' => 0, 'edit2' => 0, 'qs' => 0, 'graphics' => 0, 'translate' => 0], 
			17 =>['title'=>'Doctrine 2','id' => 17, 				'gather' => 100, 'format' => 30, 'dbRecords' => 100, 'divide' => 50, 'edit2' => 0, 'qs' => 30, 'graphics' => 10, 'translate' => 65], 
			17 =>['title'=>'Doctrine 2','id' => 17, 				'gather' => 100, 'format' => 30, 'dbRecords' => 100, 'divide' => 50, 'edit2' => 0, 'qs' => 30, 'graphics' => 10, 'translate' => 65], 
			22 =>['title'=>'Epistles 2','id' => 22, 				'gather' => 95, 'format' => 100, 'dbRecords' => 95, 'divide' => 100, 'edit2' => 15, 'qs' => 5, 'graphics' => 3, 'translate' => 95], 
			23 =>['title'=>'Gospel of John','id' => 23, 			'gather' => 70, 'format' => 70, 'dbRecords' => 100, 'divide' => 100, 'edit2' => 10, 'qs' => 30, 'graphics' => 40, 'translate' => 0], 
			24 =>['title'=>'Homiletics 2','id' => 24, 			'gather' => 100, 'format' => 100, 'dbRecords' => 100, 'divide' => 100, 'edit2' => 85, 'qs' => 2, 'graphics' => 70, 'translate' => 95], 
			25 =>['title'=>'Local Church','id' => 25, 			'gather' => 0, 'format' => 0, 'dbRecords' => 0, 'divide' => 0, 'edit2' => 0, 'qs' => 0, 'graphics' => 0, 'translate' => 0], 
			26 =>['title'=>'New Testament Introduction','id' => 26,'gather' => 0, 'format' => 0, 'dbRecords' => 0, 'divide' => 0, 'edit2' => 0, 'qs' => 0, 'graphics' => 0, 'translate' => 0], 
			29 =>['title'=>'Old Testament History','id' => 29, 	'gather' => 0, 'format' => 0, 'dbRecords' => 0, 'divide' => 0, 'edit2' => 0, 'qs' => 0, 'graphics' => 0, 'translate' => 0], 
			27 =>['title'=>'Romans','id' => 27, 					'gather' => 0, 'format' => 0, 'dbRecords' => 0, 'divide' => 0, 'edit2' => 0, 'qs' => 0, 'graphics' => 0, 'translate' => 0], 
			18 =>['title'=>'Synoptic Gospels','id' => 18, 		'gather' => 0, 'format' => 0, 'dbRecords' => 0, 'divide' => 0, 'edit2' => 0, 'qs' => 0, 'graphics' => 0, 'translate' => 0],
			28 =>['title'=>'Typology 1','id' => 28, 				'gather' => 0, 'format' => 0, 'dbRecords' => 0, 'divide' => 0, 'edit2' => 0, 'qs' => 0, 'graphics' => 0, 'translate' => 0]
		];

public static $thirdYear = [
			30 =>['title' => 'Communication 3','id' => 30, 		'gather' => 100, 'format' => 5, 'dbRecords' => 0, 'divide' => 0, 'edit2' => 0, 'qs' => 5, 'graphics' => 0, 'translate' => 0],
			2 =>['title' => 'Doctrine 3','id' => 2, 			'gather' => 100, 'format' => 100, 'dbRecords' => 100, 'divide' => 100, 'edit2' => 5, 'qs' => 5, 'graphics' => 0, 'translate' => 50],
			4 =>['title' => 'Epistles 3','id' => 4, 			'gather' => 100, 'format' => 100, 'dbRecords' => 100, 'divide' => 100, 'edit2' => 40, 'qs' => 10, 'graphics' => 40, 'translate' => 0], 
			3 =>['title' => 'Hebrews','id' => 3, 				'gather' => 95, 'format' => 100, 'dbRecords' => 100, 'divide' => 100, 'edit2' => 5, 'qs' => 5, 'graphics' => 10, 'translate' => 0], 
			31 =>['title' => 'Homiletics 3','id' => 31, 		'gather' => 30, 'format' => 0, 'dbRecords' => 0, 'divide' => 0, 'edit2' => 0, 'qs' => 3, 'graphics' => 0, 'translate' => 0], 
			32 =>['title' => 'Major and Minor Prophets','id' => 32,'gather' => 100, 'format' => 0, 'dbRecords' => 0, 'divide' => 0, 'edit2' => 0, 'qs' => 0, 'graphics' => 0, 'translate' => 0], 
			33 =>['title' => 'Parliamentary Law','id' => 33, 	'gather' => 70, 'format' => 0, 'dbRecords' => 0, 'divide' => 0, 'edit2' => 0, 'qs' => 0, 'graphics' => 0, 'translate' => 0], 
			34 =>['title' => 'Pastoral Theology','id' => 34, 	'gather' => 0, 'format' => 0, 'dbRecords' => 0, 'divide' => 0, 'edit2' => 0, 'qs' => 0, 'graphics' => 0, 'translate' => 0], 
			35 =>['title' => 'Poetry','id' => 35, 				'gather' => 0, 'format' => 0, 'dbRecords' => 0, 'divide' => 0, 'edit2' => 0, 'qs' => 0, 'graphics' => 0, 'translate' => 0], 
			36 =>['title' => 'Prophecy and Daniel','id' => 36, 	'gather' => 95, 'format' => 14, 'dbRecords' => 0, 'divide' => 0, 'edit2' => 0, 'qs' => 0, 'graphics' => 0, 'translate' => 0], 
			1 =>['title' => 'Revelation','id' => 1, 			'gather' => 60, 'format' => 60, 'dbRecords' => 60, 'divide' => 60, 'edit2' => 0, 'qs' => 20, 'graphics' => 70, 'translate' => 0], 
			37 =>['title' => 'Typology 2','id' => 37, 			'gather' => 0, 'format' => 0, 'dbRecords' => 0, 'divide' => 0, 'edit2' => 0, 'qs' => 0, 'graphics' => 0, 'translate' => 0]
		];
		

public static $electives = [
			38 =>['title' => 'The Bride of Christ','id' => 38, 					'gather' => 0, 'format' => 0, 'dbRecords' => 0, 'divide' => 0, 'edit2' => 0, 'qs' => 0, 'graphics' => 0, 'translate' => 0],
			39 =>['title' => 'Sermon Outlines by James Reynolds Sr','id' => 39, 'gather' => 0, 'format' => 0, 'dbRecords' => 0, 'divide' => 0, 'edit2' => 0, 'qs' => 0, 'graphics' => 0, 'translate' => 0],
			40 =>['title' => 'Men of the Bible','id' => 40, 					'gather' => 0, 'format' => 0, 'dbRecords' => 0, 'divide' => 0, 'edit2' => 0, 'qs' => 0, 'graphics' => 0, 'translate' => 0] 
				];
		
public static $categories = ['gather'=>'#E96D63','format'=>'#7FCA9F','dbRecords'=>'#F4BA70','divide'=>'#85C1F5','edit2'=>'#4A789C','qs'=>'#EC799A','graphics'=>'#FF9900','translate'=>'teal'];
	
/*	
	public function course()
	{
	    return $this->belongsTo('Course', 'sections_id');
	}
	
 */

}