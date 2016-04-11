<?php 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "finance";

$key = "";
$val = "";
$i = 0;


	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$dob = $_POST['dob'];
	$mobile = $_POST['mobile'];
	$phone = $_POST['phone'];
	$address = $_POST['address'];
	$city = $_POST['city'];
	$gender = $_POST['gender'];
	$email = $_POST['email'];
	$adharno = $_POST['adharno'];
	$drivinglic = $_POST['drivinglic'];
	$note = $_POST['note'];
	$docs = $_POST['docs'];
	$created_at=date('Y-m-d H:i:s');
	$data = array(
		'firstname'=>$firstname,
		'lastname'=>$lastname,
		'dob'=>$dob,
		'address'=>$address,
		'city'=>$city,
		'mobile'=>$mobile,
		'phone'=>$phone,
		'gender'=>$gender,
		'adharno'=>$adharno,
		'drivinglic'=>$drivinglic,
		'note'=>$note,
		'docs'=>$docs,
		'created_at'=>$created_at,				
		'email'=>$email			
	);
			


	
    foreach ($data as $k => $v) 
	{
	
	$keys[] = $k;
	$values[] =  $v;
	
	}
	
	$table = "borrower";
	//$sql = "INSERT INTO ".$table." (\"".implode('", "', $keys)."\") VALUES (".implode(', ', $values).")";
	$sql = "INSERT INTO ".$table." (".implode(', ', $keys).") VALUES (\"".implode('", "', $values)."\")";
	
	
	//$sql = "INSERT INTO ".$table." (\"".implode('", "', $keys)."\") VALUES (".implode(', ', $values).")";
	
	//$sql = 'INSERT INTO borrower (firstname, lastname, dob, address, city, mobile, phone, gender, adharno, drivinglic, note, docs, created_at, email) VALUES ("Vijay", "Kamble", "1980-03-01", "A-201, Borivali", "Borivali", "8080274441", "80808274441", "male", "123", "123", "SRP Member", "SRP Member", "2016-03-07 09:47:47", "vijay.kamble@gmail.com")';
	
	
    foreach ($_POST as $k => $v) 
	{  
		if ($i < sizeof($_POST) - 1)
		{
		  $key = $key. "'".$k."',";
		  $val = $val. "'".$v."',";
		  $i++;
		}
	}



// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


$key = substr($key, 0, -1);
$val = substr($val, 0, -1);


$key = "'borrower_id',".$key;

$q = "SELECT borrower_id from borrower ORDER BY borrower_id DESC LIMIT 1";

$result = $conn->query($q);

if ($result->num_rows > 0) 
{
    while ($row = $result->fetch_assoc())
	{
		$total =  $row["borrower_id"];    
		//echo "id: " . $row["borrower_id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
    }
} else {
    $total = 0;
}


$total++;

$val = $total.",".$val;

//$sql = "INSERT INTO borrower (".$key.") VALUES (".$val.")";


if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
	header("Location: ../borrower");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>