<?php

header('Content-type: text/html; charset=UTF-8'); 

?>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8"/>
	<title>Installation de Happy-CMS</title>
	<style type="text/css">
body
{
	padding:0;
	margin:0;
	background:#cccccc;
}
.header
{
	margin:auto;
	width:700px;
	background:#dddddd;
	padding:30px;
    -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.15);
       -moz-box-shadow: 0 1px 2px rgba(0,0,0,.15);
            box-shadow: 0 1px 2px rgba(0,0,0,.15);
}
.container
{
	margin:auto;
	width:700px;
	background:#eeeeee;
	padding:30px;
	-webkit-border-radius: 0 0 6px 6px;
       -moz-border-radius: 0 0 6px 6px;
            border-radius: 0 0 6px 6px;
    -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.15);
       -moz-box-shadow: 0 1px 2px rgba(0,0,0,.15);
            box-shadow: 0 1px 2px rgba(0,0,0,.15);
}

.input label
{
	display: inline-block;
    padding: 10px 20px 10px 0;
    text-align: right;
    width: 200px;
}
.input input
{
	 height: 30px;
    padding: 6px;
    width: 150px;
}


	</style>
</head>
<body>
	<div class="header">
		<h2>Installation de HappyCMS </h2><small>Etape <?php echo $step ?></small>
	</div>
	<div class="container">
		<?php

		echo $content_for_layout;

		?>
	</div>
</body>
</html>