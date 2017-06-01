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
			showError('loginError', 'An invalid username or password was provided.  Please try again.');
		} else {
			showUser(data.user);
			$('#loginPanel').dialog('close');
		}
	});
}
function signupUser() {
	var signupData = {
		'signup': true,
		'firstname': $('#firstName').val(),
		'lastname': $('#lastName').val(),
		'username': $('#signUserName').val(),
		'password': $('#signPassWord').val(),
		'confpass': $('#confPass').val()
	};

	$.post('login.php', signupData, null, 'json').done(function(data) {
		if (data && data.error) {
			showError('signupError', data.error);
			if (data.field == 'lastname') { $('#lastName').focus(); }
			else if (data.field == 'username') { $('#signUserName').focus(); }
			else if (data.field == 'password') { $('#signPassWord').focus(); }
			else if (data.field == 'confpass') { $('#confPass').focus(); }
			else { $('#firstName').focus(); }
		} else if (!data || !data.user || !data.user.loginname) {
			$('#signPassWord').val('');
			$('#confPass').val('');
			showError('signupError', 'Unable to create the user.  Please try again later.');
			$('#firstName').focus();
		} else {
			showUser(data.user);
			$('#signupPanel').dialog('close');
		}
	});
}
function showError(errDiv, error) {
	$('#' + errDiv).html(error);
	$('#' + errDiv).show(500);
	setTimeout(function() {
		$('#' + errDiv).hide(2000);
		$('#' + errDiv).html('');
	}, 3000);
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
		<div id="loginPanel" style="display: none" title="Login">
			<table>
				<tr>
					<th><label for="userName">Username:</label></th>
					<td><input type="text" id="userName" /></td>
				</tr>
				<tr>
					<th><label for="passWord">Password:</label></th>
					<td><input type="password" id="passWord" /></td>
				</tr>
			</table>
			<button onclick="loginUser()">Login</button>
			<div id="loginError" class="error-text"></div>
		</div>
		<div id="signupPanel" style="display: none" title="Create a New User">
			<table>
				<tr>
					<th><label for="firstName">First Name:</label></th>
					<td><input type="text" id="firstName" /></td>
				</tr>
				<tr>
					<th><label for="lastName">Last Name:</label></th>
					<td><input type="text" id="lastName" /></td>
				</tr>
				<tr>
					<th><label for="signUserName">Username:</label></th>
					<td><input type="text" id="signUserName" /></td>
				</tr>
				<tr>
					<th><label for="signPassWord">Password:</label></th>
					<td><input type="password" id="signPassWord" /></td>
				</tr>
				<tr>
					<th><label for="confPass">Confirm:</label></th>
					<td><input type="password" id="confPass" /></td>
				</tr>
			</table>
			<button onclick="signupUser()">Create User</button>
			<div id="signupError" class="error-text"></div>
		</div>
		<div class="body-panel">
			<div class="header">
				<a class="homelink" href="./"><div><span>Lincoln Libary</span></div></a>
				<div class="userDetail">
					<div class="needUser">
						<button onclick="$('#loginPanel').dialog({modal: true});" style='margin-left: 6px; margin-right: 6px'>Log In</button>
						<button onclick="$('#signupPanel').dialog({width: 350, modal: true});" style='margin-left: 6px; margin-right: 6px'>Sign Up</button>
					</div>
					<div class="hasUser">
						Welcome <span class="userName"></span>! <button onclick="logoutUser()">Logout</button>
					</div>
				</div>
			</div>
			<div class="content">