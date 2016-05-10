<?php

class Gifts
{

function __construct()
	{
		include_once(dirname(__FILE__)."/string.class.php");
		include_once(dirname(__FILE__)."/url_handling.class.php");
		
		$this->str = new string_clean_up();
		$this->url = new urlHandling();
		$db_config = [
			["localhost", "root", "6#52.@1)seap", "dbi", "", "mysqli"],
			["localhost", "student", "dcdbi1969", "dbi", "", "mysqli"]
			];
		$this->db = new mysqli($db_config[1][0],$db_config[1][1],$db_config[1][2],$db_config[1][3]);
	}
	
public function getFinancialAccounts(){
	
	$sql = "SELECT ID a, AccountName b FROM financialaccounts ORDER BY a ASC";
		
	$result = mysqli_query($this->db,$sql);
                     
while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
		echo '<option value=\''.$row[a].'\'>'.$row[b].'</option>';
}

}

public function getDeposits(){

	$sql = "SELECT DepositId a, DepositDate b, DepositAccount c FROM deposits ORDER BY b DESC";
		
	$result = mysqli_query($this->db,$sql);
                     
while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
		echo '<option value=\''.$row['a'].'\'>'.$row['b'].'--Acct:'.$row['c'].'</option>';
}

}									

public function getOfferings(){

	$sql = "SELECT OfferingName ofn, OfferingID ofi FROM offerings ORDER BY ofi DESC";
		
	$result = mysqli_query($this->db,$sql);
                     
while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
		echo '<option value=\''.$row['ofi'].'\'>'.$row['ofn'].'</option><br>';
}

}	

public function getGivers(){

	$sql = "SELECT `ID`, `fName`, `lName` FROM `contacts` ORDER BY `lName`";
		
	$result = mysqli_query($this->db,$sql);
                     
while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
		echo '<option value=\''.$row['ID'].'\'>'.$row['lName'].', '.$row['fName'].'</option><br>';
}

}	

public function authenticateOfficeUser($redirectFile){

// UserName and password sent from form
$myUserName = $_SESSION['UserName'];
$mypassword = $_SESSION['UserPass'];

// To protect MySQL injection (more detail about MySQL injection)
$myUserName = stripslashes($myUserName);
$mypassword = stripslashes($mypassword);

$sql="SELECT * FROM office WHERE `UserName`='$myUserName' and `password`=md5('$mypassword') AND `activeOffice`='1' LIMIT 1";
$result = mysqli_query($this->db,$sql);
				
$officeDetails = mysqli_fetch_array($result,MYSQLI_ASSOC);

// Mysql_num_row is counting table row
$count=mysqli_num_rows($result);

if($count > 0)
{
$_SESSION['authenticate_office'] = "true";
$_SESSION['officeId'] = $officeDetails['officeId'];
$_SESSION['fName'] = $officeDetails['fName'];
$_SESSION['lName'] = $officeDetails['lName'];
$_SESSION['userName'] = $officeDetails['userName'];
}

If ($_SESSION['authenticatePre'] == "true" && $_SESSION['authenticate_office'] == "true")
{
$_SESSION['error'] = "false";
$_SESSION['userID'] = $officeDetails['officeId'];
$userID = $officeDetails['officeId'];

header("Location: $redirectFile");
}
else {
$_SESSION['authenticate_office'] = "false";
$_SESSION['error'] = "Wrong User Name and/or Password";
header('Location: /office/signInForm.php');
}

}

public function displayNumOptions(){
$a = 0;
for( $i=0; $i<400; $i++ )
{
	echo "<option>".$a."</option>";
	$a++;
}
}

public function insertOfferingData(){

if (isset($_POST['giver'])) {
	$Check=$_POST['Checks'];
	$CheckNu=$_POST['CheckNu'];
	$Penny=$_POST['Penny'];
	$Nickel=$_POST['Nickel'];
	$Dime=$_POST['Dime'];
	$Quarter=$_POST['Quarter'];
	$HalfD=$_POST['HalfD'];
	$OneD=$_POST['OneD'];
	$TwoD=$_POST['TwoD'];
	$FiveD=$_POST['FiveD'];
	$TenD=$_POST['TenD'];
	$TwentyD=$_POST['TwentyD'];
	$FiftyD=$_POST['FiftyD'];
	$HundredD=$_POST['HundredD'];
	$Memo=$_POST['SMemo'];
	$giver=$_POST['giver'];
	$offering=$_POST['offering'];

$sql = "
	 INSERT INTO `accountsreceivable` (
		`IdAR` ,`Sum Total` ,`Penny` ,`Cash` ,`Nickel` ,`Dime` ,
		`Quarter` ,`HalfD` ,`OneD` ,`TwoD` ,`FiveD` ,`TenD` ,
		`TwentyD` ,`FiftyD` ,`HundredD` ,`CheckSeriel` ,`TimeStamp` ,
		`Name` ,`ReceivableMemo` ,`OfferingID` ,`Checks`
	)
	VALUES (
		NULL , NULL , $Penny, NULL , $Nickel, $Dime, 
		$Quarter,$HalfD, $OneD, $TwoD, $FiveD, $TenD, 
		$TwentyD, $FiftyD, $HundredD, $CheckNu, CURRENT_TIMESTAMP, 
		$giver, '$Memo', $offering, $Check
	)
		";
}
	
if (isset($_POST['OfferingName'])) {

$DepositsID=$_POST['DepositID'];
$OfferingName=$_POST['OfferingName'];
$OfferingMemo=$_POST['OfferingMemo'];
 
$sql= "
				 INSERT INTO `offerings` (
					`OfferingID` ,`OfferingName` ,`OfferingMemo` ,`DepositsID` 				
					)
				VALUES (
					NULL , '$OfferingName', '$OfferingMemo', '$DepositsID'			
				)
					";
 }
 
if (isset($_POST['DepositAccount'])) {

$DepositDate=$_POST['DepositDate'];
$DepositAccount=$_POST['DepositAccount'];
$DepositMemo=$_POST['DepositMemo'];	
       
$sql="
	INSERT INTO `deposits` (
	`DepositId` ,
	`DepositDate` ,
	`DepositAccount` ,
	`DepositMemo`
	)
	VALUES (
	NULL , 
	'$DepositDate', 
	'$DepositAccount', 
	'$DepositMemo'	
	)";
}          

/*// Delete records
if (isset($_POST['delete']))
{
$tbl_name = "accountsreceivable"; // Table name

    // Concatenate ids in a comma-separated string
    $ids = implode(',', $_POST['checkbox']);

    if (!empty($ids))
    {
        $sql = "DELETE FROM $tbl_name WHERE IdAR IN ($ids)";
        $result = mysql_query($sql) or die(mysql_error());
    }

    // Redirect back
   $this->url->redirect("index.php");
    die();

// Select records
$sql = "SELECT * FROM $tbl_name";
$result = mysql_query($sql);
$count = mysql_num_rows($result);
}*/
mysqli_query($this->db,$sql);
header('Location: /office/');
}


 public function __destruct() {
    mysqli_close($this->db);
   }

}

?>