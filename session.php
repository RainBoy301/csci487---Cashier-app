<?php


	session_start();

	
	function message() {
		if (isset($_SESSION["message"])) {

			$output = "<div class='row'>";
			$output .= "<div data-alert class='alert-box info round'>";
			// Convert all applicable characters to HTML entities
			$output .= htmlentities($_SESSION["message"]);

			$output .= "</div>";
			$output .= "</div>";

			// clear message after use
			$_SESSION["message"] = null;

			return $output;
		}
		else {
			return null;
		}
	}

	function errors() {
		if (isset($_SESSION["errors"])) {
			$errors = $_SESSION["errors"];

			$_SESSION["errors"] = null;

			return $errors;
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////

	function verify_login() {
		if(!isset($_SESSION["id"])&& $_SESSION["id"] === NULL) {
			$_SESSION["message"] = "You must login in first!";
			header("Location: main.php");
			exit;
		}
	}

///////////////////////////////////////////////////////////////////////////////////////////////////

?>
