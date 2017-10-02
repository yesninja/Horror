<!DOCTYPE html>
<html>
<head>
<title>Horror Helper</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
<link rel="stylesheet" href="www/css/app.css">

</head>

<body>
	<div id="content">
		<form id="login_form" action="app.php">
		  <div class="imgcontainer">
		    <img src="www/images/Alucard.png" alt="Avatar" class="avatar">
		  </div>

		  <div class="container">
		    <label><b>Username</b></label>
		    <input type="text" placeholder="Enter Username" name="uname" required>

		    <label><b>Password</b></label>
		    <input type="password" placeholder="Enter Password" name="psw" required>

		    <button type="submit">Login</button>
		  </div>

		  <div class="container" style="background-color:#f1f1f1">
		    <button type="button" class="cancelbtn">Cancel</button>
		  </div>
		</form>
	</div>
</body>

<script type="text/javascript" src="www/js/app.js"></script>
</html>

