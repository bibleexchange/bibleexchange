<?php

class Notes
{
	
function __construct()
	{
		/*include_once("_includes/string.class.php");
		include ("_includes/tile_colors.php");
		include ("_includes/db_connect_ro.php");
				
		$this->db_config = $db_connect_array;
		$this->str = new string_clean_up();
		$this->tileColors = $tileColors;
		$this->protected = [42,43];*/
	}


public function testDb(){

$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);

if (!$db) {
  echo "An error occurred.\n";
  exit;
}else {echo "Connected to Database!";};

}
	
public function setIds($sql){

$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);

$result = mysqli_query($db,$sql);
$this->pageIdsArray = array();     

while ($r = mysqli_fetch_array($result,MYSQLI_ASSOC)){
	$this->pageIdsArray['cid'] = $r['cid'];
	$this->pageIdsArray['sid'] = $r['sid'];
	$this->pageIdsArray['chid'] = $r['chid'];
}
return $this->pageIdsArray;
}	
	
public function showAnswers($answer){
		switch ($answer) {
			case true:
				return ".textbook .questions-page h3 { visibility:visible;}";
				break;
			default:
				return ".textbook .questions-page h3 { visibility:hidden;}";
				}
}

public function getAllCourses($sql,$cwr=1){
		
$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);
$result = mysqli_query($db,$sql);

$this->list = "";
        
while ($dbiCourses = mysqli_fetch_array($result,MYSQLI_ASSOC)){
	$this->list.= '<h3><a href=\'?v=list&c='.$this->str->prettyName($dbiCourses['title']).'_'.$dbiCourses['id'].'\'>'.$dbiCourses['title'].'</h3></a>';
}
return $this->list;
mysqli_close($db);
}

public function listCoursesByYear($id,$sql,$cwr=1){
		
		$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);

$result = mysqli_query($db,$sql);

$tcLimit = count($this->tileColors)-1;	
$colorCounter=$id;
$session_course_years = "yr_".$id."_courses_available";
$courses_available = mysqli_num_rows($result);
$this->courses_available = $courses_available;
$this->list = "";
                     
while ($dbiCourses = mysqli_fetch_array($result,MYSQLI_ASSOC)){
		
	$iObject = $dbiCourses['title'];
	$iObjectLength = mb_strlen( $iObject );
	
	$iObjectSub = $dbiCourses['subtitle'];
	
	if ($iObjectLength <= 28){
		$iObjectA = substr($iObject, 0, 28);
	}else {
		$iObjectA = substr($iObject, 0, 28)."...";
	}
	
	$id = $dbiCourses['id'];
	$sectionId = $dbiCourses['SectionId'];
	$color = $this->tileColors[$colorCounter];
	
	$courseTitle = $dbiCourses['title'];
	$sectionTitle = $dbiCourses['SectionTitle'];
	$chapterTitle = $dbiCourses['file_name'];
	$chapterId = $dbiCourses['cdl_id'];
			
	$iObjectFile = "library/".$this->str->prettyName($iObject)."/.";
	$modified = date ("n/d/Y h:m a", filemtime($iObjectFile));
		
	$this->list.= '
	<li class=\'box\' style=\'background-color: '.$color.'\'>
		<p class=\'modified-date\'>'.$modified.'</p>
		<a href=\'/dbi/?v=list&c='.$this->str->prettyName($courseTitle).'_'.$id.'\'>
			<p class=\'course-title\'>'.$iObjectA.'</p>
			<p class=\'course-info\'>'.$iObjectSub.'</p>
			<img src=\'images/tiles/'.$this->str->prettyName($iObject).'.jpg\' alt=\' \'>
		</a>
	</li>';
	$colorCounter++;

if ($colorCounter>$tcLimit){$colorCounter=0;}
}
mysqli_close($db);
}

public function firstCourseDocument($sql){

$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);

$result = mysqli_query($db,$sql);
                   
while ($r = mysqli_fetch_array($result,MYSQLI_ASSOC)){
	$id1 = $r['id1'];
	$id2 = $r['id2'];
	$this->fcdArray = [$id1,$id2];
}
return $this->fcdArray;
}

public function createFullText($id, $sql, $showLanguage, $includeOrEcho='include'){
		
		$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);
	
$result = mysqli_query($db,$sql);

if ($includeOrEcho === 'echo'){
	$start = '<div contenteditable=true>';
	$end = '</div>';
	}else if ($includeOrEcho === 'include'){
	$start = '';
	$end = '';
}

echo $start;		
while ($doc = mysqli_fetch_array($result,MYSQLI_ASSOC)){
		
		$courseTitle = $this->str->prettyName($doc['title']);
		$docName = $this->str->prettyName($doc['file_name']);
		$docType = $doc['file_type'];
		$document = $docName.'.'.$docType;
		
		if ($includeOrEcho === 'echo'){
			echo "echo null > ".$document."<br>";
			}else if ($includeOrEcho === 'include'){
			$this->parseHTML($courseTitle.'/'.$document,$showLanguage);
		}
}
echo $end;
mysqli_close($db);
}

public function filenameToTitle($string){
$replacedString = str_replace("-"," ",$string);
$upperCasedString = ucwords($replacedString);
$finishedString = str_replace("Dbi","D.B.I.",$upperCasedString);
return $finishedString;
}

public function stringToLCAlpha($string){
$string1 = str_replace("-","",$string);
$string2 = str_replace(" ","",$string1);
$string3 = preg_replace('/[^a-zA-Z\s]/', '', $string2);
$lowerCasedString = strtolower($string3);
$finishedString = $lowerCasedString;
return $finishedString;
}

public function filetype_remove ($string){
$a = [".html"=>"",".php"=>""];
$f = strtr($string, $a);
return $f;
}

public function createTocFromDb($id){

$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);

$sql_documents_by_section = "SELECT `id`, `title`, `SectionTitle`, `SectionId`, `SectionOrder` FROM `courses` INNER JOIN `sections` ON `courses`.`id` = `sections`.`SectionCoursesId` WHERE `sections`.`SectionCoursesId` = $id ORDER BY `SectionOrder` ASC";

$result = mysqli_query($db,$sql_documents_by_section);
$toc = '';                
while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
  {
  
  	$prettyCourse = $this->str->prettyName($row["title"]);
    $href1 = $row['SectionTitle'];
	$href2 = strtolower($href1);
	$href = $this->str->prettyName($href2);
	$sid = $row['SectionId'];
	$sectionTitle = $row['SectionTitle'];
  
 $toc .= "<h2 id='".$href."'>".$row['SectionTitle']."</span></h2>";
  
  $sql2 = '
	  SELECT a.`title`, b.`SectionTitle`, c.`cdl_id`, c.`file_name`, c.`file_type`,c.`order`
		FROM `sections` AS b
		INNER JOIN `course_document_list` AS c
		ON b.`SectionId` = c.`course_section_id` 
		LEFT JOIN `courses` AS a
		ON b.`SectionCoursesId` = a.`id`
		WHERE b.`SectionCoursesId` = '.$row['id'] 
		.' AND b.`SectionId` = '.$sid.'
		 ORDER BY c.`order` ASC
';
  
  $result2 = mysqli_query($db,$sql2);
  
  while ($rw = mysqli_fetch_array($result2,MYSQLI_ASSOC)){
	
	$course = strtolower($rw['title']);
	$course = $this->str->prettyName($course);
	
	$section = strtolower($rw['SectionTitle']);
	$section = $this->str->prettyName($section);
	
	$chapterTitle = $rw['file_name'];
	$chapter = strtolower($chapterTitle);
	$chapter = $this->str->prettyName($chapter);
	$chapterId = $rw['cdl_id'];
	
	$target= "?v=text&c=".$course."&s=".$section."&d=".$chapter."_".$chapterId;

	if ($chapterTitle !="Table of Contents"){
	 $toc .=  "<h3><a href='".$target."'>".$chapterTitle."</a></h3>";
	} 
  }
  }
}
return $toc;
mysqli_close($db);
}

public function createTocFromDbSection($id,$sectionId,$path='library/'){
	
$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);

$sql = "SELECT `sections`.`SectionId`,  `course_document_list`.`cdl_id`, `course_document_list`.`file_name`, `course_document_list`.`file_type`,`course_document_list`.`order` FROM `sections` INNER JOIN `course_document_list` ON `sections`.`SectionId` = `course_document_list`.`course_section_id` WHERE `sections`.`SectionCoursesId` = ".$id." AND `sections`.`SectionId` = ".$sectionId." ORDER BY `order` ASC";
	
$result = mysqli_query($db,$sql);
                     
while ($rw1 = mysqli_fetch_array($result,MYSQLI_ASSOC)){
	$h3a = $rw1['file_name'];
	$h3FileType = $rw1['file_type'];
	$chid = $rw1['cdl_id'];
	$h3b = strtolower($h3a);
	$h3 = $this->str->prettyName($h3b);
	
	$doc_target = $path."?cid=".$id."&&sid=".$sectionId."&&chid=".$chid;

	if ($h3a!="Table of Contents"){
	  echo "<h3><a href='".$doc_target."'><span lang='en'>".$h3a."</span></a></h3>";
	} 
  }
  mysqli_close($db);
}

public function setCurrentSessionVars($chid,$sql_getIds){

	$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);
	
	if (isset($_SESSION)) {
	
		$query_getIds = mysqli_query($db,$sql_getIds);
		
		while ($r = mysqli_fetch_array($query_getIds,MYSQLI_ASSOC)){
			$this->cid = $r['cid'];
			$this->sid = $r['sid'];		
			$this->chid = $r['chid'];
		 }
			
		if( !isset($_SESSION['authenticate']) || $_SESSION['authenticate'] == false){$_SESSION['lang'] = 'eng';}	
		
		$course_sql ="SELECT `id`,`title` FROM `courses` WHERE `id` = $this->cid LIMIT 1";
		$course_query = mysqli_query($db,$course_sql);
		
		$section_sql = "SELECT `SectionId`,`SectionTitle`,`SectionCoursesId`, `SectionOrder` FROM `sections` WHERE `SectionId` = $this->sid LIMIT 1";
		$section_query = mysqli_query($db,$section_sql);
		
		$document_sql = "SELECT `cdl_id`, `course_section_id`, `file_name`, `file_type`, `order` FROM `course_document_list` WHERE `cdl_id` = $this->chid LIMIT 1";
		$document_query = mysqli_query($db,$document_sql);

		while ($r = mysqli_fetch_array($course_query,MYSQLI_ASSOC)){
			$_SESSION['course_id'] = $r['id'];
			$_SESSION['course_name'] = $r['title'];
		 }
		
		 while ($r = mysqli_fetch_array($section_query,MYSQLI_ASSOC)){
			$_SESSION['section_id'] = $r['SectionId'];
			$_SESSION['section_title'] = $r['SectionTitle'];
		 }

		 while ($r = mysqli_fetch_array($document_query,MYSQLI_ASSOC)){
			$_SESSION['file_name'] = $r['file_name'];
			$_SESSION['file_type'] = $r['file_type'];
		 }
	}
mysqli_close($db);
return $this->cid;
return $this->sid;	
}

public function displayStudentAnswers($userId,$documentId,$referringPage){
	$displayStudentAnswers = '';
	$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);    
	
		$sql1 ="
		SELECT `cq_id` 
		FROM `courses_questions` AS b 
		INNER JOIN `course_document_list` AS c 
		ON b.`cq_cdl_id` = c.`cdl_id` 
		INNER JOIN `sections` AS d 
		ON c.`course_section_id` = d.`SectionId` 
		INNER JOIN `courses` AS e 
		ON d.`SectionCoursesId` = e.`id` 
		WHERE b.`cq_cdl_id` = $documentId 
		GROUP BY b.`cq_id`
	";
	
	$sql_sq_qna1 = mysqli_query($db,$sql1);

    if(mysqli_num_rows($sql_sq_qna1) == 0 || $userId == FALSE){
		$displayStudentAnswers .= '<br>';
	} else{
	
	$sql ="
		SELECT `csa_id`,`csa_answer`, `csa_time_stamp`, `cq_question`, `cq_id` 
		FROM `courses_student_answers` AS a 
		INNER JOIN `courses_questions` AS b 
		ON a.`csa_cq_id` = b.`cq_id` 
		INNER JOIN `course_document_list` AS c 
		ON b.`cq_cdl_id` = c.`cdl_id` 
		INNER JOIN `sections` AS d 
		ON c.`course_section_id` = d.`SectionId` 
		INNER JOIN `courses` AS e 
		ON d.`SectionCoursesId` = e.`id` 
		WHERE `csa_user_id` = $userId AND `cdl_id` = $documentId GROUP BY a.`csa_id`
	";

	$sql_sq_qna = mysqli_query($db,$sql);
	
    if(mysqli_num_rows($sql_sq_qna) == 0){
		
	$sql2 ="SELECT `cq_id`, `cq_question`, `cq_answer`, `cq_weight`, `cq_hint`  FROM `courses_questions` WHERE `cq_cdl_id` = $documentId AND `on_sq` = 1 ORDER BY `cq_order` ASC";

	$sql_sq_qna2 = mysqli_query($db,$sql2);
	$questionArray = mysqli_fetch_array($sql_sq_qna2,MYSQLI_ASSOC);
	
	$displayStudentAnswers .= '<div class=\'questions-page\'><h1>Study Questions</h1>';
	
  $displayStudentAnswers .= '<form name=\'input\' action=\'student-questions.php\' method=\'post\'>';
  
  $displayStudentAnswers .= '<input type=\'hidden\' name=\'userId\' value=\''.$userId.'\'>';
  $displayStudentAnswers .= '<input type=\'hidden\' name=\'referringPage\' value=\''.$referringPage.'\'>';
  $displayStudentAnswers .= '<input type=\'hidden\' name=\'submitType\' value=\'submit\'>';
  
 while ($sq_row = mysqli_fetch_array($sql_sq_qna2,MYSQLI_ASSOC)){
  
	$displayStudentAnswers .= '<h2>'.$sq_row['cq_question'].'</h2>';
	$displayStudentAnswers .= '<input type=\'text\' name=\''.$sq_row['cq_id'].'\'><br />';
		
	}
	$displayStudentAnswers .= '<br /><br /><input type=\'submit\' name=\'submit\' value=\'submit\'></form></div>';

	mysqli_close($db);
		
	} else {
	
	$questionArray = mysqli_fetch_array($sql_sq_qna,MYSQLI_ASSOC);
	
	$displayStudentAnswers .= '<div class=\'questions-page\'><h1>&quot;'.$chapterTitle.'&quot; Study Questions</h1>';
	$displayStudentAnswers .= '<form name=\'input\' action=\'student-questions.php\' method=\'post\'>';
		$displayStudentAnswers .= '<input type=\'hidden\' name=\'userId\' value=\''.$userId.'\'>';
		$displayStudentAnswers .= '<input type=\'hidden\' name=\'submit\' value=\'update\'>';
		$displayStudentAnswers .= '<input type=\'hidden\' name=\'referringPage\' value=\''.$referringPage.'\'>';

 while ($sq_row = mysqli_fetch_array($sql_sq_qna,MYSQLI_ASSOC)){
  
	$displayStudentAnswers .= '<h2>'.$sq_row['cq_question'].'</h2>';
	$displayStudentAnswers .= 'input type=\'text\' name=\''.$sq_row['csa_id'].'\' value=\''.$sq_row['csa_answer'].'\'><br />';
	
}
$displayStudentAnswers .= '<br /><br /><input type=\'submit\' name=\'submitType\' value=\'update\'></form></div>';
}
}
return $displayStudentAnswers;
}


public function saveStudentAnswers($sql_save_sqs){

	$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]); 	

	mysqli_query($db,$sql_save_sqs);
	mysqli_close($db);

}

public function posts($option='list'){
		
$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);
$sql = "SELECT `id`,`title`,`body`,`created`,`modified` FROM `posts` ORDER BY `modified` DESC, `created` DESC";
$posts = '';
	
$result = mysqli_query($db,$sql);

if ($option=='list'){
	$posts .=  '<ul class=\'bullets\'>';
						 
	while ($p = mysqli_fetch_array($result,MYSQLI_ASSOC)){
			
	$posts .=  '<li>'.$p['body'].'</li>';

	}
	$posts .=  '</ul>';
}else if ($option=='admin'){
	
	while ($p = mysqli_fetch_array($result,MYSQLI_ASSOC)){
	
	$posts .= '<li>[<a class=\'roomy\' href=\'?epost='.$p['id'].'\'>'.$p['body'].'</a>]</li>';

	}
	
}
return $posts;
mysqli_close($db);
}

public function parseHTML($mainFileUrl,$showLanguage){

switch ($showLanguage) {
	case 'en':
		$hideLanguage = 'swa';
		break;
	case 'swa':
		$hideLanguage = 'en';
		break;
	case 'en-swa':
		$hideLanguage = 'null';
		break;
	default:
		$hideLanguage = 'swa';
		}
				
$html = file_get_html($mainFileUrl);
 
foreach($html->find('span[lang='.$hideLanguage.']') as $e){
    $e->outertext = '';
	}
	$html = str_replace('<span lang="swa"></span>','',$html);
	$find = ['<h1></h1>','<h2></h2>','<h3></h3>','<h4></h4>','<h5></h5>','<h6></h6>','<p></p>','<li></li>','<blockquote></blockquote>','<td></td>','<th></th>'];
	$html = str_replace($find,'',$html);
	return $html;
}


public function courseInfoByDocument($documentId,$sql){
	$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);
	$result = mysqli_query($db,$sql);
	$array = array();
	$i = 0;
	while ($r = mysqli_fetch_array($result,MYSQLI_ASSOC)){
		$array[$i] = $r;
		$i++;
	}
	return $array;
}	

public function courseSummary($cid){
$course_summary = '';
$sql_sections = "
SELECT * FROM `sections` WHERE `SectionCoursesId` = $cid;
";
	
$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);

$result = mysqli_query($db,$sql_sections);
$course_summary .= '<ul class=\'courseSummary\'>';	 
while ($r = mysqli_fetch_array($result,MYSQLI_ASSOC)){
	$course_summary .= '<li>'.$r['SectionTitle'];
	
	$sectionId = $r['SectionId'];
	$sql_documents = "SELECT * FROM `course_document_list` WHERE `course_section_id` = $sectionId";
	$result_documents = mysqli_query($db,$sql_documents);
	
	$course_summary .= '<ul>';	
	while ($d = mysqli_fetch_array($result_documents,MYSQLI_ASSOC)){
		$course_summary .= '<li>'.$d['file_name'];
		
		$cdlid = $d['cdl_id'];
		$sql_tasks = "SELECT * FROM `tasks` WHERE `task_cdl_id` = $cdlid;";
		$result_tasks = mysqli_query($db,$sql_tasks);

		$course_summary .= '<ul>';
		while ($t = mysqli_fetch_array($result_tasks,MYSQLI_ASSOC)){
			$course_summary .= '<div class=\'taskTypeK'.$t['taskType'].'\'></div><li> '.$t['taskName'].'</li>';
		}
	$course_summary .= '</ul></li>';
	}
 $course_summary .= '</ul></li>';	
}             
  $course_summary .= '</ul>';	
  return $course_summary;
  mysqli_close($db);
}

 function __destruct() {
    
   }

}

?>