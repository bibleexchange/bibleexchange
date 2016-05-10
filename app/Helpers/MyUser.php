<?php

class MyUser
{
	
function __construct()	{
		include_once ('_includes/string.class.php');
		include ('_includes/tile_colors.php');
		include ('_includes/db_connect_ro.php');
		$this->db_config = $db_connect_array;
		$this->tileColors = $tileColors;		
	}

	//Make Sure User is Signed in or Redirect to Login Page
public function authenticate()	{

	if($_SESSION['authenticate'] == false || !isset($_SESSION['authenticate']))
	{
        $_SESSION['authenticatePre'] = false;
        $_SESSION['authenticate'] = false;
        $_SESSION['error'] = "You must log in first!";
		unset($_SESSION['userName'],$_SESSION['userPass'],$_SESSION['timeStmp'],$_SESSION['formURL']);
        header('Location: ?v=signin');
	}
	}

public function authenticateAdmin() {

	if($_SESSION['authenticateAdmin'] == false || !isset($_SESSION['authenticateAdmin']))
	{
        $_SESSION['error'] = "You must log in as an Administrator first!";
        header('Location: ?v=signin');
	}
	}

public function authenticateUser($myusername,$mypassword){
	$_SESSION['stopped'] = __LINE__;
	$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);

	// To protect MySQL injection
	$myusername = stripslashes($myusername);
	$mypassword = stripslashes($mypassword);

	$sql="
		SELECT * FROM `users` 
		WHERE `userName`='$myusername' 
		AND `password`= MD5('$mypassword') 
		AND `active`='1'
		LIMIT 1
		";
		
		$studentDetails = mysqli_query($db,$sql);
		
		// Mysql_num_row is counting table row
		$count=mysqli_num_rows($studentDetails);
	
	if($count > 0)
	{
	$_SESSION['stopped'] = __LINE__;
    $_SESSION['authenticate'] = true;
	
    If ($_SESSION['authenticatePre'] == true && $_SESSION['authenticate'] == true)
	{
    $_SESSION['stopped'] = __LINE__;   
    while ($row = mysqli_fetch_array($studentDetails,MYSQLI_ASSOC)){
		$userId = $row['id'];
		$_SESSION['userFirstName'] = $row['fName'];
		$_SESSION['userLastName'] = $row['lName'];
		$_SESSION['userGender'] = $row['gender'];
		$_SESSION['userCreatedTimeStamp'] = $row['creationTimeStamp'];
        
	$_SESSION['error'] = "false";
	$_SESSION['userID'] = $userId;

	unset(
		$_SESSION['UserName'],
		$_SESSION['UserPass'],
		$_SESSION['timeStmp'],
		$_SESSION['formURL'],
		$_SESSION['sqa'],
		$_SESSION['course'],
		$_SESSION['authenticatePre'],
		$_SESSION['userGender'],
		$_SESSION['userCreatedTimeStamp']
		);
	
    $_SESSION['stopped'] = __LINE__;
    
	$sql0="INSERT INTO `dcenter`.`logins` (`loginId`, `userId`, `loginTimeStamp`) VALUES (NULL, '$userId', CURRENT_TIMESTAMP);";
	$result0=mysqli_query($db,$sql0);
	
	if($row['userType']==='student'){
            $_SESSION['stopped'] = __LINE__;
            $path = "text/desk/_225";
		}else if($row['userType']==='admin'){
            $_SESSION['stopped'] = __LINE__;
            $_SESSION['authenticateAdmin'] = true;
			$path = "?v=administrator&s=top&d=manage-courses_293";			
		}
    }
    $_SESSION['stopped'] = __LINE__;
	header('Location: '.$path);
	}   
	}
	
    else {
        $_SESSION['stopped'] = __FILE__.' - line: '.__LINE__;
    	$_SESSION['authenticate'] = false;
    	$_SESSION['authenticatePre'] = false;
    	$_SESSION['error'] = "Wrong User Name or Password!";
    	header('Location: ?v=signin');
	}
	mysqli_close($db);
}

public function logOut(){
	unset($_SESSION);
	session_destroy();
	}

public function enrolledCourses($UserID){

$str = new string_clean_up();

$tcLimit = count($this->tileColors)-1;	
$colorCounter=0;
$list = "";

	$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);

	$sql="SELECT distinct(`enrollId`),`courseId`, `courseTitle`, `SectionId`,`cdl_id`,`courseSubtitle`
		FROM  `enrollment` AS a
		LEFT JOIN  `courses` AS b
		ON  a.`enrollCourseId` =  b.`courseId` 
		LEFT JOIN `courses_sections` AS c
		ON b.`courseId` = c.`SectionCoursesId`
		LEFT JOIN `course_document_list` AS d
		ON c.`sectionId` = d.`course_section_id` 
		WHERE `enrollStudentId` =  $UserID
		AND  `enrollApproved` =  '1'
		AND `enrollActive`='1'
		GROUP BY `enrollId`
		ORDER BY  `courseTitle` ASC";		
		
$result=mysqli_query($db, $sql);

if (!empty($result)){
echo "<ul class='wrapper'>";
while($row = mysqli_fetch_array($result))
  {
	$iObject = $row['courseTitle'];
	$iObjectLength = mb_strlen( $iObject );
	
	$iObjectSub = $row['courseSubtitle'];
	
	if ($iObjectLength <= 28){
		$iObjectA = substr($iObject, 0, 28);
	}else {
		$iObjectA = substr($iObject, 0, 28)."...";
	}
	
	$courseId = $row['courseId'];
	$sectionId = $row['SectionId'];
	$chid = $row['cdl_id'];
	$color = $this->tileColors[$colorCounter];
		
	$iObjectFile = '../library/'.$str->prettyName($iObject)."/.";
	
	$modified = date("n/d/Y h:m a", filemtime($iObjectFile));
		
	$list.= "<li class='box' style='background-color: ".$color."'>
				<p class='modified-date'>".$modified."</p>
				<a href='library/?cid=".$courseId."&&sid=".$sectionId."&&chid=".$chid."'>
					<p class='course-title'>".$iObjectA."</p>
					<p class='course-info'>".$iObjectSub."</p>
				<img src='/dbi/images/tiles/".$str->prettyName($iObject).".jpg'  alt='tile'>
			<form name='suspendCourse' method='post'>
				<input type='hidden'  name='suspendEnrollId' value='".$row['enrollId']."' >
				<input type='image' src='/dbi/images/delete-icon.png' alt='Suspend Course' name='suspendSubmit' value='Suspend Course' >
			</form>
  </a></li>";
	$colorCounter++;

if ($colorCounter>$tcLimit){$colorCounter=0;}
	
  }
  echo $list;
  echo "</ul>";
  }

 else {echo "<h3>You Are Not Enrolled in any Courses Yet</h3>";}	
}
	
public function enrolledCoursesOptions($UserID){

$str = new string_clean_up();
$list = "";

	$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);

	$sql="SELECT distinct(`enrollId`),`courseId`, `courseTitle`, `SectionId`,`cdl_id`
		FROM  `enrollment` AS a
		LEFT JOIN  `courses` AS b
		ON  a.`enrollCourseId` =  b.`courseId` 
		LEFT JOIN `courses_sections` AS c
		ON b.`courseId` = c.`SectionCoursesId`
		LEFT JOIN `course_document_list` AS d
		ON c.`sectionId` = d.`course_section_id` 
		WHERE `enrollStudentId` =  $UserID
		AND  `enrollApproved` =  '1'
		AND `enrollActive`='1'
		GROUP BY `enrollId`
		ORDER BY  `courseTitle` ASC";		
		
$result=mysqli_query($db, $sql);

if (!empty($result)){
echo "<ul class='wrapper'>";
while($row = mysqli_fetch_array($result))
  {
	$list.= "<option value='".$row['courseId']."'>".$row['courseTitle']."</option>";
  }
	echo $list;
  }
}
		

public function availableCourses($UserID){

	$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);

	$sql="SELECT `courseId`, `courseTitle` FROM `courses` AS a WHERE `courseAcceptingEnroll`='1' AND `courseId` NOT IN (SELECT `enrollCourseId` FROM `enrollment` WHERE `enrollStudentId` = $UserID ORDER BY `courseYear` ASC)";

	$result=mysqli_query($db, $sql);

if (!empty($result))
{
print "<ul>";
while($r = mysqli_fetch_array($result))
  {
  echo "<li><h4>" . $r['courseTitle'] . " 
		<form name='enrollRequest' method='post'>
			<input type='hidden'  name='enrollStudentId' value='".$UserID."' >
			<input type='hidden'  name='enrollCourseId' value='".$r['courseId']."' >
			<input type='image' src='/dbi/images/add-icon.png' alt='Request Enroll' name='enrollSubmit' value='Request Enroll' >enroll
		</form></h4></li>";		
  }
print "</ul>";
}
else {echo "<h3>No New New Courses are Available to You.</h3>";}
}	
	
	
public function pendingEnrollment($UserID){

	$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);
	
	$sql="SELECT  `courses`.`courseTitle`, `enrollment`.`enrollTime`, `enrollment`.`enrollId`
		FROM  `enrollment` 
		INNER JOIN  `courses` ON  `enrollment`.`enrollCourseId` =  `courses`.`courseId` 
		WHERE  `enrollment`.`enrollStudentId` =  $UserID
		AND `enrollApproved` =  '0'
		ORDER BY  `courses`.`courseYear` ASC";
	$result=mysqli_query($db, $sql);

	if (!empty($result))	
{	

while($r = mysqli_fetch_array($result))
  {
  echo "<li><b>Course:</b> " . $r['courseTitle']." <b>Request Received:</b> .".$r['enrollTime']."<form style='display:inline;' name='deletePending'  method='post'><input type='hidden'  name='deletePendingId' value='".$r['enrollId']."' ><input type='image' name='submitDelete' src='/dbi/images/delete-icon.png'></form></li>";
  }
  }  
}	
	
	
public function assignmentsToDo($UserID,$CourseId){

	$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);
	
	$sql="
		SELECT `taskId` ,`taskName`,`taskDescription`,`taskCourseId`,`taskType`,`task_cdl_id`,
		FROM `tasks` 
		INNER JOIN `progress`
		
		!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!FIX Query 
		WHERE `taskType` = 1 && `taskCourseId` = 1
	";
		
	$result=mysqli_query($db, $sql);

	if (!empty($result))	
{	

while($r = mysqli_fetch_array($result))
  {
  echo "<li><a href=''>" . $r['courseTitle']."</a></li>";
  }
  }  
}		
	
public function assignmentsDone($UserID,$CourseId){

	$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);
	
	$sql="";
	$result=mysqli_query($db, $sql);

	if (!empty($result))	
{	

while($r = mysqli_fetch_array($result))
  {
  echo "<li><a href=''>" . $r['courseTitle']."</a></li>";
  }
  }  
}			
	
public function registerNewStudent(){
	
	$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);
	
	$url = new urlHandling();
	
	$fName = $_SESSION['FirstName'];
	$lName = $_SESSION['LastName'];
	$userName = $_SESSION['UserName'];
	$password = MD5($_SESSION['Passwd']);
	$BirthMonth = $_SESSION['BirthMonth'];
	$BirthDay = $_SESSION['BirthDay'];
	$BirthYear = $_SESSION['BirthYear'];
	$gender = $_SESSION['Gender'];
	$mobilePhone = $_SESSION['RecoveryPhoneNumber'];
	$email = $_SESSION['RecoveryEmailAddress'];
	$country = $_SESSION['CountryCode'];

	$sql_new_student = "INSERT INTO `users` (`id`, `fName`, `lName`, `BirthMonth`, `BirthDay`, `BirthYear`, `email`, `userName`, `password`, `mobilePhone`, `gender`, `country`, `creationTimeStamp`) 
	VALUES 
	(NULL, '$fName', '$lName', '$BirthMonth', '$BirthDay', '$BirthYear', '$email', '$userName', '$password', '$mobilePhone', '$gender', '$country', CURRENT_TIMESTAMP);";
		
if (!mysqli_query($db, $sql_new_student)) {
    $_SESSION['error'] = "User Name Already Exists!";
	$_SESSION['duplicate_user_name'] = true;
	unset($_SESSION['UserName'],$_SESSION['Passwd']);
	header('Location: /dbi/registerForm.php');
}else{
	session_destroy();
	session_start();
	$_SESSION['error'] = "Your user name is registered.";
	header('Location: /dbi/signInForm.php');
	}
	}
	
}	
?>