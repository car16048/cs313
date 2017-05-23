<?php require 'header1.php'; echo 'Author Information'; require 'header2.php'; $id = is_numeric($_GET['id']) ? (int)$_GET['id'] : 0; ?>
<script type="text/javascript" src="scripts/search.js"></script>
<script type="text/javascript">$(function() { searchBooks('author', null, <?php echo "$id"; ?>); });</script>

<?php
if ($id > 0) {
	$qry = "SELECT a.firstname || ' ' || a.lastname author, a.website FROM authors a WHERE authorid = :authorid";

	$stm = $db->prepare($qry);
	$stm->bindParam(':authorid', $id, PDO::PARAM_INT);
	$stm->execute();
	$author = $stm->fetch(PDO::FETCH_ASSOC);
}

if (empty($author)) {
	echo "<h1>Author Not Found</h1>";
} else {
	$name = $author['author'];
	$website = $author['website'];

	if (empty($website)) {
		echo "<h1>$name has authored the following books:</h1>";
	} else {
		echo "<h1><a href='//$website'>$name</a> has authored the following books:</h1>";
	}
	echo '<div class="postSearch"><div class="searchResults"></div></div>';
}

require 'footer.php' ?>
