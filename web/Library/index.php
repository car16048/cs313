<?php require 'header1.php'; echo 'Welcome to the Lincoln Libary'; require 'header2.php';
if (!empty($_GET['searchType']) && !empty($_GET['searchText'])) { 
	$searchType = htmlspecialchars($_GET['searchType']);
	$searchText = htmlspecialchars($_GET['searchText']);
	echo "<script type='text/javascript'>$(function() { $('#searchType').val('$searchType'); $('#searchText').val('$searchText'); searchBooks('$searchType', '$searchText'); });</script>";
}
?>
<script type="text/javascript">$(function() { searchBooks('author', null, <?php echo "$id"; ?></script>
<script type="text/javascript" src="scripts/search.js"></script>
<div class="searchPanel">
	<label for="searchType">Search by </label>
	<select id="searchType">
		<option value="keyword">Keyword</option>
		<option value="book" selected>Book Title</option>
		<option value="author">Author</option>
		<option value="publisher">Publisher</option>
	</select>
	<input type="text" size="40" id="searchText" />
	<button onclick="searchBooks($('#searchType').val(), $('#searchText').val())" id="searchButton">Search</button>
</div>
<div class="preSearch">
	<h1>Welcome to the Lincoln Libary!</h1>
	<p>We are the premier, online library for books that are not of this world!  Our extensive catalog tracks all subjects, and there is little you can't find.  You can search for a book above, or simply think of one.  Just imagine it in your mind really hard.  It will eventually appear.</p>
</div>
<div class="postSearch">
	<h1>Search Results</h1>
	<div class="searchResults">
	</div>
</div>
<?php require 'footer.php' ?>
