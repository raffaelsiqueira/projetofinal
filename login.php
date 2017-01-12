<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projetofinal";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$email = $_POST["email"];
$userpassword = $_POST["password"];

$sql = "SELECT email, password FROM user WHERE email='$email' AND password='$userpassword'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        //echo "email " . $row["email"]. " - Password: " . $row["password"]. "<br>";
        if ($row["email"] == $email){
        	if($row["password"] == $userpassword){
        		//echo '<a href="modeloImpacto.php">Login successfully</a>';
        		echo json_encode($email);
        		echo '<form action="modeloImpacto.php" method="post">
  						<button type="submit" name="your_name" value="your_value" class="btn-link">Login successfully</button>
					</form>';
        	} else{
        		echo "Wrong password";
        	}
		} else{
        	echo "Wrong email or password";
        }
    }
} else {
    echo "Wrong email or password";
}



$conn->close();
?>