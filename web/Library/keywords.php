<?php
	require 'dbsession.php';
	header('Content-type: application/json');

	$rows = array();
	$action = $_REQUEST["action"];
	$keywordIdStr = $_REQUEST["keywordId"];
	$bookIdStr = $_REQUEST["bookId"];
	$keyword = htmlspecialchars($_REQUEST["keyword"]);

	if (IsSet($_SESSION['user']) && !empty($_SESSION['user']['loginname'])) {
		if ($action == 'add' && is_numeric($bookIdStr) && !empty($keyword)) {
			$bookId = (int)$bookIdStr;

			$qry = "SELECT k.keywordid, k.bookid, u.firstname || ' ' || u.lastname createdby, k.createdon, k.keyword, k.deletedon " .
				   "FROM keywords k LEFT JOIN users u ON k.createdbyuserid = u.userid " .
				   "WHERE k.bookid = :bookid AND k.keyword = :keyword";

			$stm = $db->prepare($qry);

			$stm->bindParam(':bookid', $bookId, PDO::PARAM_INT);
			$stm->bindParam(':keyword', $keyword, PDO::PARAM_STR);
			if ($stm->execute()) {
				$row = $stm->fetch(PDO::FETCH_ASSOC);
			} else {
				$rows['firstError'] = $stm->errorInfo();
			}

			if (IsSet($row) && IsSet($row['keywordid'])) {
				$rows['keyword'] = $row;

				if (!empty($row['deletedon'])) {
					$stm = $db->prepare('UPDATE keywords SET deletedon = NULL, deletedbyuserid = NULL WHERE keywordid = :keywordid');
					$stm->bindParam(':keywordid', $row['keywordid'], PDO::PARAM_INT);
					$rows['undeleted'] = $stm->execute();
					if (!$rows['undeleted']) $rows['undeleteError'] = $stm->errorInfo();
				}

				UnSet($rows['keyword']['deletedon']);
			} else {
				$qry = "INSERT INTO keywords (bookid, createdbyuserid, keyword) VALUES (:bookid, (SELECT userid FROM users WHERE loginname = :loginname), :keyword)";

				$stm = $db->prepare($qry);

				$stm->bindParam(':bookid', $bookId, PDO::PARAM_INT);
				$stm->bindParam(':loginname', $_SESSION['user']['loginname'], PDO::PARAM_STR);
				$stm->bindParam(':keyword', $keyword, PDO::PARAM_STR);
				$rows['added'] = $stm->execute();
				if (!$rows['added']) $rows['addError'] = $stm->errorInfo();

				$qry = "SELECT k.keywordid, u.firstname || ' ' || u.lastname createdby, k.createdon, k.keyword " .
					   "FROM keywords k LEFT JOIN users u ON k.createdbyuserid = u.userid " .
					   "WHERE k.bookid = :bookid AND k.keyword = :keyword";

				$stm = $db->prepare($qry);

				$stm->bindParam(':bookid', $bookId, PDO::PARAM_INT);
				$stm->bindParam(':keyword', $keyword, PDO::PARAM_STR);
				if ($stm->execute()) {
					$rows['keyword'] = $stm->fetch(PDO::FETCH_ASSOC);
				} else {
					$rows['selectError'] = $stm->errorInfo();
				}
			}
		} else if ($action == 'delete' && is_numeric($keywordIdStr)) {
			$keywordId = (int)$keywordIdStr;
			$qry = "UPDATE keywords SET deletedon = now(), deletedbyuserid = (SELECT userid FROM users WHERE loginname = :loginname) WHERE keywordid = :keywordid";

			$stm = $db->prepare($qry);

			$stm->bindParam(':loginname', $_SESSION['user']['loginname'], PDO::PARAM_STR);
			$stm->bindParam(':keywordid', $keywordId, PDO::PARAM_INT);
			$rows['deleted'] = $stm->execute();
			if (!$rows['deleted']) $rows['deleteError'] = $stm->errorInfo();
		}
	}

	$jsonVal = json_encode($rows);
	echo "$jsonVal";
?>