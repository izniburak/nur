<!DOCTYPE html>
<html lang="en">
<head>
<title><?=strip_tags($title)?></title>
<style type="text/css">
    body {background-color:#eee; margin:40px; font:13px/20px normal Helvetica, Arial, sans-serif; color:#4F5155;}
    a {color:#888; background-color:transparent; font-weight:normal;}
    #container {width:70%; margin:10px auto; padding:10px; border:1px solid #ddd; -webkit-box-shadow:0 0 8px #D0D0D0; font-size:19px; background:#fff;}
    h1,h2 {margin:0px 0 25px 0; font-size:27px;}
    div.message {padding:10px 10px; margin:1px auto;}
</style>
</head>
<body>
    <div id="container">
        <div class="message">
            <h1><?=$title?></h1>
            <?=($message)?>
            <br /><br />
            go to <a href="javascript:window.history.back()">back</a> or <a href="<?=Uri::base()?>">home</a>.
        </div>
    </div>
</body>
</html>
