function addKeyword() {
	var kw = $('#newKeyword').val();

	if (!bookId || !kw) return;

	$.getJSON('keywords.php', {'v': 1, 'action': 'add', 'bookId':bookId, 'keyword':kw}).done(function (data) {
		if (data && data.keyword && data.keyword.keywordid) {
			showKeyword(data.keyword);
			$('#newKeyword').val('');
			showHideEditableFields();
		} else {
			alert('There was a problem adding the keyword.  Please try again later.');
		}
	}).fail('There was a problem adding the keyword.  Please try again later.');
}

function removeKeyword(keywordId) {
	if (!keywordId) return;

	$.getJSON('keywords.php', {'v': 1, 'action': 'delete', 'keywordId':keywordId}).done(function (data) {
		if (data && data.deleted) {
			$('#keyword_' + keywordId).remove();
		} else {
			alert('There was a problem removing the keyword.  Please try again later.');
		}
	}).fail('There was a problem removing the keyword.  Please try again later.');
}

function showKeyword(keyword) {
	$('#keywordsContainer').append("<div class='keyword-container' id='keyword_" + keyword.keywordid +
		"'><div class='keyword-div'><a class='keyword' title='Created by " + keyword.createdby +
		" on " + keyword.createdon +
		"' href='index.php?searchType=keyword&searchText=" + encodeURIComponent(keyword.keyword) +
		"'>" + keyword.keyword +
		"</a><a class='remove-keyword' onclick='removeKeyword(" + keyword.keywordid +
		")'>X</a></div></div>");
}

function showHideEditableFields() {
	var editableFields = $('#addKeywordRow, .remove-keyword');
	
	if (loggedInUser) {
		$('#addKeywordRow, .remove-keyword').show();
	} else {
		$('#addKeywordRow, .remove-keyword').hide();
	}
}

$('.hasUser').on('user:shown', showHideEditableFields);
$('.hasUser').on('user:hidden', showHideEditableFields);
