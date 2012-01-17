<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<rss version="2.0">
    <channel>
   
        <title><?php echo Configure::read('Config.Content.title'); ?></title>
        <link><?php echo $this->Html->url('/',true); ?></link>
        <description><?php echo Configure::read('Config.Content.meta-tag'); ?></description>
       <?php
        $lengthIntro = 100;
       App::uses('Inflector','Utility');
       foreach($Posts as $post)
       {
        $intro = substr(strip_tags($post['Post']['text']),0,$lengthIntro);
     
        /*$k=0;
        while(substr($post['Post']['text'],$lengthIntro+$k,1)!=' ')
        {
           $intro.=substr($post['Post']['text'],$lengthIntro+$k,1);
           $k++;
           if($k>20) break;
        }
        if(strlen($post['Post']['text'])>$lengthIntro)
        {
            $intro.='...';
        }*/

        $link = $this->Html->url(array('controller'=>'posts','action'=>'view',$post['Post']['id'].'-'.Inflector::slug($post['Post']['title'])),true);

           ?>
        <item>
            <title><?php echo $post['Post']['title'] ?></title>
            <link><?php echo $link; ?></link>
            <guid isPermaLink="true"><?php echo $link; ?></guid>
            <description><?php echo $intro; ?></description>
            <?php if(!empty($post['Post']['img'])) echo '<enclosure url="'.$this->Html->url('/files/uploads/posts/'.$post['Post']['img'],true).'" type="image/'.preg_replace('/^.*\.([a-zA-Z0-9]{2,4})$/','$1',$post['Post']['img']).'" />'; ?>
            <pubDate><?php echo date('r',strtotime($post['Post']['created'])); ?></pubDate>
        </item>

           <?php
       }

       ?>
    </channel>
</rss>
