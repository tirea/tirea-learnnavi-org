<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Login</title>

<style type="text/css">
	* {
		margin: 0;
		padding: 0;
	}

	body {
                color:#bbb;
                font:15px "Helvetica Neue", Helvetica, Arial, sans-serif;
                background-color:#0f0f0f;
        }

        a {
                text-decoration:none;
                color:#2dabe0;
        }

        a:hover {
                text-decoration:underline;

        }
	
	.login_box {
		width: 260px;
		padding: 10px;
		border: 3px solid #383838;
		font-family:"Helvetica Neue", Helvetica, Arial, sans-serif;
		font-size: 15px;
		margin: 100px auto 10px auto;	
	}
	
	.login_title {
		font-size: 1.2em;
		font-weight: bold;
		color:#fff;
	}
	
	.login_text {
		font-size: 1.1em;
		font-weight: bold;
		color: #fff;
	}
	
	.login_input {
		width: 210px;
		padding: 5px;
		margin: 2px 0 2px 0;
		border: 1px solid #999; 
	}
	
	.error {
		font-weight: bold;
		color: #C30;
	}
</style>
</head>

<body>
<form action="" method="post">
<div class="login_box">
    <span class="login_title">Please Log In</span><br />
    You must log in to see the following content. Contact admin if you are having problem or have forgotten your password.<br /><br />
    <?php $login->error_login(); ?>
    
    <span class="login_text">Username</span><br />
    <input name="username" type="text" class="login_input" /><br />
    <span class="login_text">Password</span><br />
    <input name="password" type="password" class="login_input" /><br /><br />
	<div align="left"><a href="../posts">Go Back</a></div>
	<div align="right"><input name="login" type="submit" value="Login" /></div>
</div>
</form>
</body>
</html>
