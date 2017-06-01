<?php
	require 'dbsession.php';
	header('Content-type: application/json');

	$rows = array();
	$username = $_POST["username"];
	$password = $_POST["password"];
	$firstname = $_POST["firstname"];
	$lastname = $_POST["lastname"];
	$confpass = $_POST["confpass"];
	$signup = $_REQUEST["signup"];
	$logout = $_REQUEST["logout"];

	if (!empty($logout)) {
		UnSet($_SESSION['user']);
		$rows['loggedOut'] = true;
	} else {
		$rows['notLogout'] = true;
		if ($signup == "true") {
			$rows['isSignup'] = true;
			if (empty($firstname)) { $rows['error'] = "First name is required"; $rows['field'] = 'firstname'; }
			else if (empty($lastname)) { $rows['error'] = "Last name is required"; $rows['field'] = 'lastname'; }
			else if (empty($username)) { $rows['error'] = "Username is required"; $rows['field'] = 'username'; }
			else if (empty($password)) { $rows['error'] = "Password is required"; $rows['field'] = 'password'; }
			else if (strlen($password) < 8) { $rows['error'] = "The password must be at least 8 characters long"; $rows['field'] = 'password'; }
			else if (!preg_match('/.*[A-Za-z].*/', $password)) { $rows['error'] = "The password must contain at least one letter"; $rows['field'] = 'password'; }
			else if (!preg_match('/.*[0-9].*/', $password)) { $rows['error'] = "The password must contain at least one number"; $rows['field'] = 'password'; }
			else if ($password != $confpass) { $rows['error'] = "The passwords don't match"; $rows['field'] = 'confpass'; }
			else {
				$passwordhash = password_hash($password, PASSWORD_DEFAULT);
				$qry = 'INSERT INTO users (loginname, firstname, lastname, passwordhash) VALUES (:loginname, :firstname, :lastname, :passwordhash)';
				$stm = $db->prepare($qry);

				$stm->bindParam(':loginname', $username, PDO::PARAM_STR);
				$stm->bindParam(':firstname', $firstname, PDO::PARAM_STR);
				$stm->bindParam(':lastname', $lastname, PDO::PARAM_STR);
				$stm->bindParam(':passwordhash', $passwordhash, PDO::PARAM_STR);

				if ($stm->execute()) {
					$rows['added'] = true;
				} else {
					$rows['error'] = ($stm->errorInfo()[0] == 23505 ? 'That username already exists.  Please try a new username' : 'Unable to add the new user');
					$username = '';
					$password = '';
				}
			}
		}

		if (!empty($username) || !empty($password)) {
			$rows['isLogin'] = true;
			$qry = "SELECT userid, loginname, firstname, lastname, passwordhash " .
				   "FROM users " .
				   "WHERE loginname = :username";

			$stm = $db->prepare($qry);

			$stm->bindParam(':username', $username, PDO::PARAM_STR);
			$stm->execute();
			$row = $stm->fetch(PDO::FETCH_ASSOC);

			if (IsSet($row) && IsSet($row['userid']) && !empty($row['loginname'])) {
				$pwh = $row['passwordhash'];

				if (password_verify($password, $pwh)) {
					$rows['user'] = array();
					$rows['user']['loginname'] = htmlspecialchars($row['loginname']);
					$rows['user']['firstname'] = htmlspecialchars($row['firstname']);
					$rows['user']['lastname'] = htmlspecialchars($row['lastname']);
					$_SESSION['user'] = $rows['user'];
				}
			} else if (!IsSet($rows['error'])) {
				$rows['error'] = 'An invalid username or password was provided.  Please try again.';
			}
		} else {
			$rows['isLogin'] = false;
		}
	}

	$jsonVal = json_encode($rows);
	echo "$jsonVal";
?>