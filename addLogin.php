<?php
require_once("session.php");
require_once("functions.php");
require_once("database.php");

$mysqli = Database::dbConnect();
$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (($output = message()) !== null) {
  echo $output;
}

if (isset($_POST["submit"])) {
	if (isset($_POST["username"]) && $_POST["password"] !== ""){
		$password = password_encrypt($_POST["password"]);


		$query = "SELECT * FROM Users WHERE userName = ?";


		$stmt = $mysqli -> prepare($query);
		$stmt -> execute([$_POST["username"]]);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if($stmt->rowCount() > 0) {  //Check if this username already exists in database
			$_SESSION["message"] = "The username already exists";
			redirect("addLogin.php");
		}

		else{ //If username does not exist, we start adding this username
			//We must stop foreign key check because userID is refering to a non-existence Student or Instructor
			// In the future, we must also create a student or instructor who inherists the userID that just created

			$query = "SET FOREIGN_KEY_CHECKS = 0;
								INSERT INTO Users (userName, hashed_password, userType) VALUES (?,?,?);

								SET FOREIGN_KEY_CHECKS = 1;";
			$stmt = $mysqli -> prepare($query);
			$stmt -> execute([$_POST["username"], $password, $_POST["usertype"]]);

			if($stmt) {
				//////////////////If the new user is student, we first grab the id of the new user, then create a new Student using that ID/////////////
        $query = "SELECT max(userID) as newID FROM Users";

        $stmt = $mysqli -> prepare($query);
        $stmt -> execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($_POST["usertype"]=='E'){

					$query2 = "SET FOREIGN_KEY_CHECKS = 0;
										INSERT INTO Employee (employeeID) VALUES (?);
										SET FOREIGN_KEY_CHECKS = 1;";
					$stmt = $mysqli -> prepare($query2);
					$stmt -> execute([$row['newID']]);

					$_SESSION["message"] = "Employee ".$row["newID"]." successfully created";

				}else{

          $query2 = "SET FOREIGN_KEY_CHECKS = 0;
                    INSERT INTO Owner (ownerID) VALUES (?);
                    SET FOREIGN_KEY_CHECKS = 1;";
          $stmt = $mysqli -> prepare($query2);
          $stmt -> execute([$row['newID']]);
					$_SESSION["message"] = "An Owner was created";
				}


			}
			else {
				$_SESSION["message"] = "User could not be created";
			}
		redirect("home.php");
		}

	}else{
			$_SESSION["message"] = "Please fill in all data";
			redirect ("addLogin.php");
	}
}

?>

  <head>
    <title> Cashier App ADD LOGIN </title>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
      <link rel="stylesheet" type="text/css" href ="home.css">
  </head>
  <body>
    <div class="container">
    <div class = "loginbox">
      <img src="logo.png" class="avatar">
      <h1>ADD LOGIN HERE</h1>
      <form action="addLogin.php" method="post">
        <div class="form-group">
          <label for="email">Email address</label>
          <input type="username" name ="username" class="form-control" id="email" aria-describedby="emailHelp">
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Password</label>
          <input type="password" name="password" class="form-control" id="password">
        </div>
        <div class="drop-down">
          <label for="dropdown">User Type</label>
          <br>
          <select class="dropdown" name="usertype">
					<option value="O">Owner</option>
					<option value="E">Employee</option>

				</select>
        </div>
        <div class="home-button">
          <button type="submit" name="submit" class="">Submit</button>
        </div>

      </form>
    </div>
  </div>
  </body>
