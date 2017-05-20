<?php require 'header1.php'; echo 'Book Information'; require 'header2.php'; $id = is_numeric($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
	$qry = "SELECT b.title, p.publisherid, p.name publisher, a.authorid, a.firstname || ' ' || a.lastname author, b.publisheddate, b.isbn, b.abstract FROM books b JOIN authors a ON b.authorid = a.authorid JOIN publishers p ON b.publisherid = p.publisherid WHERE b.bookid = :bookid";

	$stm = $db->prepare($qry);
	$stm->bindParam(':bookid', $id, PDO::PARAM_INT);
	$stm->execute();
	$book = $stm->fetch(PDO::FETCH_ASSOC);
}

if (empty($book)) {
	echo "<h1>Book Not Found</h1>";
} else {
	$title = $book['title'];
	$publisherid = $book['publisherid'];
	$publisher = $book['publisher'];
	$authorid = $book['authorid'];
	$author = $book['author'];
	$publisheddate = $book['publisheddate'];
	$isbn = $book['isbn'];
	$abstract = $book['abstract'];
	echo "<h1>$title</h1>";
	echo "<table>";
	echo "  <tr><th>Publisher</th><td><a href='publisher.php?id=$publisherid'>$publisher</a></td></tr>";
	echo "  <tr><th>Author</th><td><a href='author.php?id=$authorid'>$author</a></td></tr>";
	echo "  <tr><th>Published Date</th><td>$publisheddate</td></tr>";
	echo "  <tr><th>ISBN</th><td>$isbn</td></tr>";
	echo "  <tr><th>Abstract</th><td>$abstract</td></tr>";
	echo "</table>";

	$qry = "SELECT k.keywordid, k.keyword, u.firstname || ' ' || u.lastname createdby, k.createdon FROM keyword k LEFT JOIN users u ON k.createdbyuserid = u.userid WHERE k.deletedon IS NULL AND k.bookid = :bookid";
	$stm = $db->prepare($qry);
	$stm->bindParam(':bookid', $id, PDO::PARAM_INT);
	$stm->execute();

	foreach ($stm->fetchAll() as $row) {
		$keywordid = $row['keywordid'];
		$keyword = $row['keyword'];
		$createdby = $row['createdby'];
		$createdon = $row['createdon'];
		echo "<div class='keywordDiv' id='keyword_$keywordid'><a class='keyword' title='Created by $createdby on $createdon'>$keyword</a><div>";
	}
}

require 'footer.php' ?>
