<?php
	require 'dbsession.php';
	header('Content-type: application/json');

	$rows = array();
	$username = $_POST["username"];
	$password = $_POST["password"];
	$logout = $_REQUEST["logout"];

	if (!empty($logout)) {
		UnSet($_SESSION['user']);
		$rows['loggedOut'] = true;
	} else if (!empty($username) || !empty($password)) {
		$qry = "SELECT userid, loginname, firstname, lastname, passwordhash " .
		       "FROM users " .
			   "WHERE loginname = :username";

		$stm = $db->prepare($qry);

		$stm->bindParam(':username', $username, PDO::PARAM_STR);
		$stm->execute();
		$row = $stm->fetch(PDO::FETCH_ASSOC);

		if (IsSet($row) && IsSet($row['userid'])) {
			$pwh = $row['passwordhash'];

			if (password_verify($password, $pwh)) {
				$rows['user'] = array();
				$rows['user']['loginname'] = htmlspecialchars($row['loginname']);
				$rows['user']['firstname'] = htmlspecialchars($row['firstname']);
				$rows['user']['lastname'] = htmlspecialchars($row['lastname']);
				$_SESSION['user'] = $rows['user'];
			}
		}
	}

	$jsonVal = json_encode($rows);
	echo "$jsonVal";
?>