<?php

function setCurrentSessionVars($cid, $sid, $chid, $editCourseId,$editSectionId,$editDocumentId){
	
	if (isset($_SESSION)) {
	
	$_SESSION['editCourseId'] = $editCourseId;
	$_SESSION['editSectionId'] = $editSectionId;
	$_SESSION['editDocumentId'] = $editDocumentId;
	
	$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);	
		
	$course_edit_sql ="SELECT `id`,`title` FROM `courses` WHERE `id` = $editCourseId LIMIT 1";
	$course_edit_query = mysqli_query($db,$course_edit_sql);
	
	$section_edit_sql = "SELECT `SectionId`,`SectionTitle` FROM `sections` WHERE `SectionId` = $editSectionId LIMIT 1";
	$section_edit_query = mysqli_query($db,$section_edit_sql);
	
	$document_edit_sql = "SELECT `cdl_id`, `course_section_id`, `file_name`, `file_type`, `order` FROM `course_document_list` WHERE `cdl_id` = $editDocumentId LIMIT 1";
	$document_edit_query = mysqli_query($db,$document_edit_sql);
		
	while ($r = mysqli_fetch_array($course_edit_query,MYSQLI_ASSOC)){
		$_SESSION['editCourseTitle'] = $r['title'];
	 }
	
	while ($r = mysqli_fetch_array($section_edit_query,MYSQLI_ASSOC)){
		$_SESSION['editSectionTitle'] = $r['SectionTitle'];
	 }
	 while ($r = mysqli_fetch_array($document_edit_query,MYSQLI_ASSOC)){
		$_SESSION['editDocumentTitle'] = $r['file_name'];
	 }

	 mysqli_close($db);
	}
}

function listForSelect($cid, $sid, $chid, $editCourseId, $editSectionId, $editDocumentId, $sql, $option='zzz', $selected=''){
								
	$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);
		
	$result = mysqli_query($db,$sql);
    $this->list = array(); 
	$this->qform = array();

if ( !$result )
	echo '<strong>!!! Error with sql statement: </strong><br>'.$sql;
else {
	$this->listcount = $result->num_rows;
while ($c = mysqli_fetch_array($result,MYSQLI_ASSOC)){
	
	switch ($option) {
		case "option":
			echo '<option value=\''.$c['objectId'].'\'';
            if($c['objectId']===$selected){echo ' selected ';}
            echo '>'.$c['objectTitle'].'</option>';
			break;
		case "course":
			$this->list[] = '<li>[<a class=\'roomy\' href=\''."http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]".'&ecid='.$c['objectId'].'\'>'.$c['objectId'].' - '.$c['objectTitle'].'</a>]</li>';
			break;
		case "section":
			echo '<li>[<a class=\'roomy\' href=\'?esid='.$c['objectId'].'\'>'.$c['objectOrder'].' - '.$c['objectTitle'].'</a>]</li>';
			break;
		case "document":
			echo '<li>[<a class=\'roomy\' href=\'?echid='.$c['objectId'].'\'>'.$c['objectOrder'].' - '.$c['objectTitle'].'</a>]</li>';
			break;
		case "questions":
			$this->qform[] .= '<form id=\'updatequestion\' name=\'updatequestion\' method=\'post\' >';
			
			$showColumns = ['objectId','cq_weight','cq_hint','objectOrder','on_sq','on_qz','on_fl','cq_cdl_id','objectTitle','cq_answer'];
			
			foreach ($c as $key => $value){
			 if (in_array($key, $showColumns)){
				$this->qform[] .= '<label id=\''.$key.'\'><strong>'.$key.': </strong>';
				$this->qform[] .= '<textarea type=\'text\' class=\'editQuestions\' name=\''.$key.'\' id=\''.$key.'\' >';
				$this->qform[] .= $value;
				$this->qform[] .= '</textarea></label>';
				}
			}
			$this->qform[] .= '<br /><input id=\'update\' name=\'update\' type=\'submit\' value=\'Update\' class=\'btn btn-primary\'> ';
			$this->qform[] .=  '<input id=\'deleteConfirm\' name=\'deleteConfirm\' type=\'submit\' value=\'Delete?\' class=\'btn btn-primary delete\'>';
			if (isset($_SESSION['confirmed']) && $_SESSION['confirmed']='yes')
				{
				$this->qform[] .=  "<input id='delete' name='delete' type='submit' value='!!Are You Sure?!!' class='btn btn-primary delete'>";
				unset($_SESSION['confirmed']);
				}
			$this->qform[] .= '</form><hr>';
			break;
		case "list":
			$this->list[$c['objectId']] = $c['objectTitle'];
			break;
		default:
			echo "blank";			
				}
	}
return $this->list;
return $this->qform;
return $this->listcount;
}
mysqli_close($db);
}

function showACourse($sql){
		
	$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);

	$result = mysqli_query($db,$sql);
	
	$this->showACourse = mysqli_fetch_array($result,MYSQLI_ASSOC);
	
	return $this->showACourse;
	
	mysqli_close($db);
}

function createCourse($sql){
		
	$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);

	if ($db->query($sql) === TRUE) {
    printf("Course successfully created.\n");
}
	mysqli_close($db);
}

function updateCourse($sql){
		
	$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);

	if ($db->query($sql) === TRUE) {
    printf("Course successfully Updated.\n");
}
	mysqli_close($db);
}

function deleteCourse($sql1,$sql){
		
	$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);
	
	if ($db->query($sql1) === TRUE) {
		if ($db->query($sql) === TRUE) {
			printf("Course successfully DELETED.\n");
		}else {printf("Could not be DELETED!<br>".$sql1."<br>".$sql);
	}
	}else {printf("Could Not be placed in Trash Bin!");
	}
	mysqli_close($db);
}

function updateDocument($sql){
		
	$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);

	if ($db->query($sql) === TRUE) {
    printf("Document successfully Updated.\n");
}
	mysqli_close($db);
}

function createSection($sql){
		
	$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);

	if ($db->query($sql) === TRUE) {
    printf("Section successfully created.\n");
}else { printf("<p style='color:red'>Section could NOT be created!</p>");}
	mysqli_close($db);
}

function updateSection($sql){
		
	$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);
	
	if ($db->query($sql) === TRUE) {
		printf("Section successfully Updated.\n");
	}else {
		printf("Something went wrong :(.\n".$sql);
	}
	mysqli_close($db);
}

function showASection($sql){
		
	$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);
		
	$result = mysqli_query($db,$sql);
	
	$this->showASection_arr = mysqli_fetch_array($result,MYSQLI_ASSOC);
	
	mysqli_close($db);
}

function deleteSection($sql){
		
	$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);
	
	if ($db->query($sql) === TRUE) {
    printf("Section successfully DELETED.\n");
}else {printf("<p style='color:red'>Section could NOT be delted!</p>");}
	mysqli_close($db);
}

function createDocument($sql){
		
	$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);

	if ($db->query($sql) === TRUE) {
    printf("Document successfully created.\n");
}else { printf("<p style='color:red'>Document could NOT be created!</p>".$sql);}
	mysqli_close($db);
}

function showADocument($sql){
		
	$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);
		
	$result = mysqli_query($db,$sql);
	
	$this->showADocument_arr = mysqli_fetch_array($result,MYSQLI_ASSOC);
	return $this->showADocument_arr;

	mysqli_close($db);
}

function deleteDocument($sql){
		
	$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);

	
	if ($db->query($sql) === TRUE) {
    printf("Document successfully DELETED.\n");
}else {printf("<p style='color:red'>Document could NOT be deleted!</p>");}

	mysqli_close($db);
}

function createPost($sql){
		
	$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);

	if ($db->query($sql) === TRUE) {
    printf("Post successfully created.\n");
}else {printf("Something went wrong!\n".$sql);}
	mysqli_close($db);
}

function showAPost($sql){
		
	$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);
		
	$result = mysqli_query($db,$sql);
	
	$this->showAPost_arr = mysqli_fetch_array($result,MYSQLI_ASSOC);
	
	return $this->showAPost_arr;

	mysqli_close($db);
}

function updatePost($sql){
		
	$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);
	
	if ($db->query($sql) === TRUE) {
    printf("Post successfully Updated.\n");
}
	mysqli_close($db);
}

function deletePost($sql1,$sql){
		
	$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);
	
	if ($db->query($sql1) === TRUE) {
		if ($db->query($sql) === TRUE) {
			printf("Post successfully DELETED.\n");
		}else {printf("Post not be DELETED!<br>".$sql1."<br>".$sql);
	}
	}else {printf("Could Not be placed in Trash Bin!");
	}
	mysqli_close($db);
}

function createQuestion($sql){
		
	$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);

	if ($db->query($sql) === TRUE) {
    printf("Question successfully created.\n");
}else { printf("<p style='color:red'>Question could NOT be created!</p>".$sql);}
	mysqli_close($db);
}

function deleteQuestion($sql1,$sql){
		
	$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);
	
	if ($db->query($sql1) === TRUE) {
		if ($db->query($sql) === TRUE) {
			printf("Question successfully DELETED.\n");
		}else {printf("Question not be DELETED!<br>".$sql1."<br>".$sql);
	}
	}else {printf("Could Not be placed in Trash Bin!");
	}
	mysqli_close($db);
}

function updateQuestion($sql){
		
	$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);
	
	if ($db->query($sql) === TRUE) {
		printf("Question successfully Updated.\n");
	}else {
		printf("Could Not be updated!:<br>".$sql);
	}
	mysqli_close($db);
}