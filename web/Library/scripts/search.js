function searchBooks(searchType, searchText, searchId) {

	var searchUrl = 'search.php?v=3';
	if (searchType) searchUrl += '&searchType=' + encodeURIComponent(searchType);
	if (searchText) searchUrl += '&searchText=' + encodeURIComponent(searchText);
	if (searchId) searchUrl += '&searchId=' + encodeURIComponent(searchId);

	$('#searchButton').prop('disabled', true);
	$(".preSearch").hide();
	$(".searchResults").html('Please wait while we look for that...');
	$(".postSearch").show();

	$.getJSON(searchUrl).done(function (data) {
		try
		{
			var html = [];

			if (data.results && data.results.length) {
				for (var i = 0; i < data.results.length; i++) {
					var res = data.results[i];
					
					html.push('<div class="searchResult"><a class="bookTitle" href="book.php?id=');
					html.push(res.bookid);
					html.push('">');
					html.push(res.title);
					html.push('</a><div class="bookByline">Written by <a class="authorName" href="author.php?id=');
					html.push(res.authorid);
					html.push('">');
					html.push(res.author);
					html.push('</a>, published on ');
					html.push(res.publisheddate);
					html.push(' by <a class="publisherName" href="publisher.php?id=');
					html.push(res.publisherid);
					html.push('">');
					html.push(res.publisher);
					html.push('</a></div><div class="abstract"></div>');
					html.push(res['abstract']);
					html.push('</div>');
				}
			} else {
				html.push('<div class="warning">No results were found</div>');
			}

			$(".searchResults").html(html.join(''));
		}
		finally
		{
			$('#searchButton').prop('disabled', false);
		}
	}).fail(function() { $('#searchButton').prop('disabled', false); alert("An unknown error has occurred.  Please try your request later."); });
}
