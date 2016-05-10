<?php

class Enrollment
{

	function __construct()
		{
		include ('_includes/db_connect_ro.php');
		
		$this->db_config = $db_connect_array;
	}

	public function enrollRequest($UserID,$CourseID)
	{
	$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);
	
	$sqlEnroll ="INSERT INTO `enrollment` (`enrollId`, `enrollStudentId`, `enrollCourseId`, `enrollApproved`, `enrollTime`) VALUES (NULL,".$UserID.",".$CourseID.", NULL, CURRENT_TIMESTAMP);";
	$enrollQuery=mysqli_query($db,$sqlEnroll);
	mysqli_close($db);
	}
	
	public function suspendCourse($enrollId0)
	{
	$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);
	$sqlSuspendCourse="UPDATE `enrollment` SET enrollActive='0' WHERE enrollId=$enrollId0";
	$suspendCourse=mysqli_query($db,$sqlSuspendCourse);
	mysqli_close($db);
	}
	
	public function resumeCourse($enrollId1)
	{
	$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);
	$sqlResumeCourse1="UPDATE `enrollment` SET enrollActive='1' WHERE enrollId=$enrollId1";
	$resumeCourse1=mysqli_query($db,$sqlResumeCourse1);
	mysqli_close($db);
	}
	
	public function deletePending($enrollId2)
	{
	$db = new mysqli($this->db_config[1][0],$this->db_config[1][1],$this->db_config[1][2],$this->db_config[1][3]);
	$sqlResumeCourse="DELETE FROM `enrollment` WHERE enrollId=$enrollId2";
	$resumeCourse=mysqli_query($db,$sqlResumeCourse);
	mysqli_close($db);
	}

}

?>