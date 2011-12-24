<div id="flags">
    
    <ul>
    <?php
    foreach(Configure::read('Config.languages') as $lang)
    {
        echo '<li class="flag-'.$lang.'">'.$this->Html->link($this->Html->image('flags/'.$lang.'.png'),array('language'=>$lang),array('escape'=>false)).'</li>';
     }
    ?>

    </ul>
    
</div>