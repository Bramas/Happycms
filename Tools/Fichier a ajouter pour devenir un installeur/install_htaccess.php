<?php

function createHtaccess($rewriteBase='/')
{
$htaccess_layout = '
<IfModule mod_rewrite.c>
	RewriteEngine on
   	%s
</IfModule>';

$htaccess_root = 
'
   RewriteRule    ^$ app/webroot/    [L]
   RewriteRule    (.*) app/webroot/$1 [L]
';
$htaccess_app = 
'
    RewriteRule    ^$    webroot/    [L]
    RewriteRule    (.*) webroot/$1    [L]
';

$htaccess_webroot = 
'
	RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    
    RewriteRule ^files\/uploads\/(.*)\/([^\/]*)\.(png|gif|jpg|jpeg|JPG|JPEG)_([0-9]{1,4})x([0-9]{1,4})$ thumb2.php?folder=$1&filename=$2&ext=$3&width=$4&height=$5 [QSA,L]
    
    RewriteRule ^media\/(.*)\/([^\/]*)\.(png|gif|jpg|jpeg|JPG|JPEG)_([0-9]{1,4})x([0-9]{1,4})$ thumb.php?folder=$1&filename=$2&ext=$3&width=$4&height=$5 [QSA,L]
    
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]
';


$htaccess_install = 
'
    RewriteRule    ^install.php$ install.php    [L]
    RewriteRule    ^$ app/webroot/    [L]
    RewriteRule    (.*) app/webroot/$1 [L]
';

	if(!empty($rewriteBase))
	{
		$rewriteBase = 'RewriteBase '.$rewriteBase.'
		';
	}
	else
	{
		$rewriteBase=null;
	}
	$htaccess_install = sprintf($htaccess_layout,$rewriteBase.$htaccess_install);
	$handle = fopen(".htaccess", "w");
	fwrite($handle, $htaccess_install);
	fclose($handle);

	$htaccess_root = sprintf($htaccess_layout,$rewriteBase.$htaccess_root);
	$handle = fopen("_.htaccess", "w");
	fwrite($handle, $htaccess_root);
	fclose($handle);

	$htaccess_app = sprintf($htaccess_layout,$rewriteBase.$htaccess_app);
	$handle = fopen("app/.htaccess", "w");
	fwrite($handle, $htaccess_app);
	fclose($handle);

	$htaccess_webroot = sprintf($htaccess_layout,$rewriteBase.$htaccess_webroot);
	$handle = fopen("app/webroot/.htaccess", "w");
	fwrite($handle, $htaccess_webroot);
	fclose($handle);
	
}
createHtaccess('');
