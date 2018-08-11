<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>nur - simple PHP framework</title>
    <style>
        body { margin:0; font-family:sans-serif; text-align:center; color:#333; }
        a { text-decoration:underline; color:#000; }
        a:hover { text-decoration:none; }
        h1 { font-size: 72px; margin-bottom:0; }
        h2 { font-size: 28px; color:#333; margin-bottom:40px; }
        h3 { font-size: 19px; color:#888; font-weight:normal; margin-bottom:40px; }
        h4 { font-size: 18px; color:#000; font-weight:normal; margin-bottom:50px; }
        h5 { font-size: 14px; color:#bbb; font-weight:normal; }
        h5 > a { color:#999; text-decoration:none; }
        h5 > a:hover { text-decoration:underline; }
        .welcome { width:650px; margin-top:14%; margin-left:auto; margin-right:auto; }
        .blank { display:inline-block; padding:0 5px; }
    </style>
</head>
<body>
    <div class="welcome">
        <h1>nur</h1>
        <h2>simple PHP framework</h2>
        <h3>framework version: {{ NUR_VERSION }}<br />current PHP version: {{ PHP_VERSION }}</h3>
        <h4>
            <a href="https://github.com/izniburak/nur">view on github</a> <span class="blank">|</span>
            <a href="https://github.com/izniburak/nur#docs">documentation</a>
        </h4>
        <h5>creator, maintainer<br/> <a href="https://github.com/izniburak/" title="izni burak demirtas">izniburak</a></h5>
    </div>
</body>
</html>
