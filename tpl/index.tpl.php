<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns:v="urn:schemas-microsoft-com:vml" xmlns="http://www.w3.org/1999/xhtml"><head>

  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="description" content="The Left Menu 2 column Liquid Layout. Pixel widths. Cross-Browser. Equal Height Columns.">
  <meta name="keywords" content="The Left Menu 2 column Liquid Layout. Pixel widths. Cross-Browser. Equal Height Columns.">
  <meta name="robots" content="index, follow">
    <link type="text/css" rel="stylesheet" href="<? echo $c->baseurl;?>/css/hits.css" />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.js"></script>
    </style>
    <!--[if lt IE 7]>
    <style media="screen" type="text/css">
    .col1 {
      width:100%;
  }
    </style>
    <![endif]-->
    <title>Squid Stats und Admin</title>
</head><body>
<div id="header">
<h1>Squid Verwaltung</h1>
</div>
<div class="page">
    <div class="colright">
        <div class="contentwrap">
            <div class="content" id="content">
                <? echo $v['content']; ?>
                <div id="footer">
                    <p>Layout und Seite (c) 2009-2011 Felix Hirt und Jens Gutermuth. Diese Seite nutzt <a href="http://www.famfamfam.com/lab/icons/silk/">Silk-Icons</a></p>
                </div>
            </div>
        </div>
        <div class="menu">
            <ul>
            <li><a href="log">Log</a></li>
            <li><a href="config">Config</a></li>
            <li><a href="helloworld">Hello World</a></li>
            <li><a href="error404">Error 404</a></li>
            </ul>
            <? echo $v['menu']; ?>
        </div>
    </div>
</div>
<div id="login">
<form>
<h3>Login</h3>
<table style="border: 0">
        <tr><td>User: </td><td><input id="user" type="text" size="15" maxlength="30" value=""/></td></tr>
        <tr><td>Passwort: </td><td><input id="password" type="password" size="15" maxlength="30" value=""/></td></tr>
        <tr><td></td><td><input type="button" id="submit-login" value="Absenden"></input></td></tr>
</table>
</form>
</div>
<div id="overlay"></div>


</body></html>
