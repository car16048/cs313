<?php require 'header1.php'; echo 'Publisher Information'; require 'header2.php'; $id = is_numeric($_GET['id']) ? (int)$_GET['id'] : 0; ?>
<script type="text/javascript" src="scripts/search.js"></script>
<script type="text/javascript">$(function() { searchBooks('publisher', null, <?php echo "$id"; ?>); });</script>

<?php
if ($id > 0) {
	$qry = "SELECT p.name, p.website FROM publishers p WHERE publisherid = :publisherid";

	$stm = $db->prepare($qry);
	$stm->bindParam(':publisherid', $id, PDO::PARAM_INT);
	$stm->execute();
	$publisher = $stm->fetch(PDO::FETCH_ASSOC);
}

if (empty($publisher)) {
	echo "<h1>Publisher Not Found</h1>";
} else {
	$name = $publisher['name'];
	$website = $publisher['website'];

	if (empty($website)) {
		echo "<h1>$name has published the following books:</h1>";
	} else {
		echo "<h1><a href='//$website'>$name</a> has published the following books:</h1>";
	}
	echo '<div class="postSearch"><div class="searchResults"></div></div>';
}

require 'footer.php' ?>
