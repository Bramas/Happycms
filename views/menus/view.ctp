<?php

foreach($contents as $content)
{
    $content = $content['Content'];
    $layout->blockStart($content['key']);
    
        echo $content['text'];
    
    $layout->blockEnd();
}
?>


<div id="page">
<?php

echo $page['text'];
?>
</div>