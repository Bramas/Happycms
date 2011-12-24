<?php

Configure::write('Media.formats',array(
	's' => '100x100',
	'm' => '400x300',
	'l'  => '960x600',
	'formThumb' => '100x100',
    'browserThumb' => '100x100'
));

/*Configure::write('Media.ThumbExtensions',array(
'default'=>'/media/ext/default.jpg',
));*/


Configure::write('Media.Extensions',
array(
'Image'=>array(
    'jpg','JPG',
    'jpeg','JPEG',
    'gif','GIG',
    'png','PNG',
    'bmp','BMP'
    ),
'Archive'=>array(
    'zip',
    'rar',
    '7z',
    'iso'),
'Pdf'=>array(
    'pdf')
));
