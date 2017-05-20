</title>
		<link rel="StyleSheet" href="//code.jquery.com/ui/1.12.1/themes/start/jquery-ui.css" type="text/css" />
		<link rel="StyleSheet" href="../styles/site.css" type="text/css" />
		<script type="text/javascript" src="//code.jquery.com/jquery-3.2.1.min.js"></script>
		<script type="text/javascript" src="//code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
		<script type="text/javascript">
var userName = '<?php
	if (IsSet($_SESSION["user"])) {
		$cleanUser = htmlspecialchars($_SESSION["user"]);
		echo "$cleanUser";
	}
?>';
		</script>
	</head>
	<body>
		<div class="body-panel">
			<div class="header">
				<a class="homelink" href="./">Lincoln Libary</a>
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
						<span class="userName"></span>
					</div>
				</div>
			</div>
			<div class="content">