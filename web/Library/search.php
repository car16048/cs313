<?php
	session_start();
	$dbUrl = getenv('DATABASE_URL');
	$dbOpts = parse_url($dbUrl);

	$dbHost = $dbOpts["host"];
	$dbPort = $dbOpts["port"];
	$dbUser = $dbOpts["user"];
	$dbPass = $dbOpts["pass"];
	$dbName = ltrim($dbOpts["path"], '/');

	$db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPass);
	header('Content-type: application/json');

	$rows = array();
	$rows['results'] = array();
	$searchType = $_GET["searchType"];
	$searchText = $_GET["searchText"];
	$searchId = $_GET["searchId"];

	if (($searchType == 'author' || $searchType == 'book' || $searchType == 'keyword' || $searchType == 'publisher') && (!empty($searchText) || is_numeric($searchId))) {
		$qry = "SELECT DISTINCT b.bookid, b.title, b.abstract, b.publisheddate, a.authorid, a.firstname || ' ' || a.lastname author, p.publisherid, p.name publisher " .
		       "FROM books b JOIN authors a ON b.authorid = a.authorid JOIN publishers p ON b.publisherid = p.publisherid LEFT JOIN keywords k ON b.bookid = k.bookid " .
		       "WHERE ";

		if (!empty($searchText)) {
			$qry = $qry . ($searchType == 'keyword' ? 'k.keyword' : ($searchType == 'book' ? 'b.title' : ($searchType == 'author' ? "a.firstname || ' ' || a.lastname" : 'p.name'))) . " LIKE '%' || :searchText || '%'";
		}

		if (is_numeric($searchId)) {
			$qry = $qry . ($searchType == 'keyword' ? 'k.keywordid' : ($searchType == 'book' ? 'b.bookid' : ($searchType == 'author' ? "a.authorid" : 'p.publisherid'))) . " = :searchId";
		}

		$stm = $db->prepare($qry);

		if (!empty($searchText)) $stm->bindParam(':searchText', $searchText, PDO::PARAM_STR);
		if (is_numeric($searchId)) $stm->bindParam(':searchId', $searchId, PDO::PARAM_INT);
		$stm->execute();

		foreach ($stm->fetchAll() as $row) {
			$rows['results'][] = array(
				'bookid'=>$row['bookid'],
				'title'=>$row['title'],
				'abstract'=>$row['abstract'],
				'publisheddate'=>$row['publisheddate'],
				'authorid'=>$row['authorid'],
				'author'=>$row['author'],
				'publisherid'=>$row['publisherid'],
				'publisher'=>$row['publisher']);
		}
	}

	$jsonVal = json_encode($rows);
	echo "$jsonVal";
?>