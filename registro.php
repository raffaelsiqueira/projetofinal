<?php
								$servername = "localhost";
								$username = "root";
								$password = "";
								$dbname = "projetofinal";
								$name = $email = $userpassword = "";

								//echo "teste";

								// Create connection
								$conn = mysqli_connect($servername, $username, $password, $dbname);
								// Check connection
								if (!$conn) {
								    die("Connection failed: " . mysqli_connect_error());
								} else {
									//echo "Connection successfully";
								}

								$name = $_POST["name"];
								$email = $_POST["email"];
								$userpassword = $_POST["password"];


								$sql = "INSERT INTO user
								VALUES ('$name' ,'$email', '$userpassword')";

								if (mysqli_query($conn, $sql)) {
								    echo "Register complete!" . "<br>";
								} else {
								    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
								}

								echo '<a href="index.php">Return to main page</a>';

								mysqli_close($conn);
								?>