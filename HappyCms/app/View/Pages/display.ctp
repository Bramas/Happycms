<div id="Page">

    

    <?php
    if(!empty($item->empty)):
    
        echo( __("Cette page n'existe pas dans cette langue."));
        
    else:
        echo($item['text']);
       
        endif
    
    ?>


</div>