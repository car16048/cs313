</title>
		<link rel="StyleSheet" href="//code.jquery.com/ui/1.12.1/themes/start/jquery-ui.css" type="text/css" />
		<link rel="StyleSheet" href="../styles/site.css" type="text/css" />
		<script type="text/javascript" src="//code.jquery.com/jquery-3.2.1.min.js"></script>
		<script type="text/javascript" src="//code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
		<script type="text/javascript">
var loggedInUser;

function showUser(user) {
	if (user && user.loginname) {
		$('span.userName').text(user.firstname + ' ' + user.lastname);
		$('.needUser').hide();
		$('.hasUser').show();
		loggedInUser = user;
		$('.hasUser').trigger('user:shown');
	} else {
		$('span.userName').text('');
		$('.needUser').show();
		$('.hasUser').hide();
		loggedInUser = null;
		$('.hasUser').trigger('user:hidden');
	}
}
function logoutUser() {
	$.getJSON('login.php', {'logout':'true'}).done(function() { showUser(null); });
}
function loginUser() {
	$.post('login.php', {'username':$('#userName').val(), 'password':$('#passWord').val()}, null, 'json').done(function(data) {
		if (!data || !data.user || !data.user.loginname) {
			$('#userName').val('');
			$('#passWord').val('');
			alert('An invalid username or password was provided.  Please try again.');
		} else {
			showUser(data.user);
		}
	});
}
$(function() {
	showUser(<?php
	if (IsSet($_SESSION['user']) && IsSet($_SESSION['user']['loginname'])) {
		$un = htmlspecialchars($_SESSION['user']['loginname']);
		$fn = htmlspecialchars($_SESSION['user']['firstname']);
		$ln = htmlspecialchars($_SESSION['user']['lastname']);
		
		echo "{\"loginname\":\"$un\",\"firstname\":\"$fn\",\"lastname\":\"$ln\"}";
	} else {
		$vals = "null, " . (IsSet($_SESSION) ? 'true,' : 'false,') . (IsSet($_SESSION) && IsSet($_SESSION['user']) ? 'true,' : 'false,') . (IsSet($_SESSION) && IsSet($_SESSION['user']) && IsSet($_SESSION['user']['loginname']) ? 'true' : 'false');
		echo "$vals";
	}
?>);
});
		</script>
	</head>
	<body>
		<div class="body-panel">
			<div class="header">
				<a class="homelink" href="./"><div><span>Lincoln Libary</span></div></a>
				<div class="userDetail">
					<div class="needUser">
						<table>
							<tr>
								<td><label for="userName">Username:</label></td>
								<td><label for="passWord">Password:</label></td>
							</tr>
							<tr>
								<td><input type="text" id="userName" size="20" /></td>
								<td><input type="password" id="passWord" size="20" /></td>
								<td><button onclick="loginUser()">Login</button></td>
							</tr>
						</table>
					</div>
					<div class="hasUser">
						Welcome <span class="userName"></span>! <button onclick="logoutUser()">Logout</button>
					</div>
				</div>
			</div>
			<div class="content">