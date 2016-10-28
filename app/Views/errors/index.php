<!DOCTYPE html>
<html lang="en">
<head>
<title>Whoops! Page not found.</title>
<style type="text/css">
	body {background-color: #eee;margin: 40px;font: 13px/20px normal Helvetica, Arial, sans-serif;color: #4F5155;}
	a {color: #888; background-color: transparent; font-weight: normal;}
	#container {width:70%; margin: 10px auto; padding: 10px; border: 1px solid #ddd; -webkit-box-shadow: 0 0 8px #D0D0D0; font-size: 19px; background:#fff;}
	h1, h2 {margin:0px 0 25px 0;font-size:27px;}
	div.message {padding:10px 10px; margin:1px auto;}
</style>
</head>
<body>
	<div id="container">
		<div class="message"><?=($message == '' ? '<h1>Oppss! Page Not Found.</h1> The page you are trying to access is currently unavailable. <br /><br /><a href="javascript:window.history.back()">Go to back</a>' : $message . '<br /><br />Go to <a href="javascript:window.history.back()">back</a> or <a href="'.uri::base().'">home</a>.')?></div>
	</div>
</body>
</html>
