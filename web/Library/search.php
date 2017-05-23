<?php
	require 'dbsession.php';
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

		foreach ($stm->fetchAll(PDO::FETCH_ASSOC) as $row) {
			$rows['results'][] = $row;
		}
	}

	$jsonVal = json_encode($rows);
	echo "$jsonVal";
?>