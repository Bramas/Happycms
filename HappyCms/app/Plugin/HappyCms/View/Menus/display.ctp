<?php
$base = $this->Html->url('/',true);


$Page['text'] = preg_replace(
                '/(<img[^\n]*src=\")([^\n]*\"[^\n]*>)/',
                '${1}'.$base.'${2}',
                $Page['text']);


echo $Page['text'];
?>