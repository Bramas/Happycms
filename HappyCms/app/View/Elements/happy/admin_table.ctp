<?php

if(empty($data))
{
    $data=$this->request->data;
}
if(empty($editUrl))
{
    $editUrl=array(
            'controller'=>'contents',
            'action'=>'item_edit',
            $ExtensionName,
            'admin'=>true
            );
}
$editUrl = $this->Html->url($editUrl,true);
if(empty($alias))
{
    if(empty($this->request->data['Happy']['model_name']))
    {
        $alias='Content';
    }
    else
    {
        $alias=$this->request->data['Happy']['model_name'];
    }
}


if(!empty($columns) && !empty($data))
{
    echo '<table>';
    
    
    echo '<tr>';
    foreach($columns as $name=>$label)
    {
        echo '<th>'.$label.'</th>';
    }
    echo '<th style="width:80px">Actions</th>';
    if(Configure::read('Config.multilanguage'))
    {
        echo '<th>Langages</th>';
    }
    
    echo '</tr>';
    
    foreach($data as $row)
    {
        echo '<tr>';
        if(empty($row[$alias]))
        {
            continue;
        }
        
        foreach($columns as $name=>$label)
        {
            $out='';
            if(empty($row[$alias][$name]))
            {
                if(substr(strtolower($name),0,7)=='categor' 
                        && isset($row['Category']))
                {
                    if(empty($row['Category'] ))
                    {
                        $out='Aucune catégorie';
                    }
                    else
                    {
                        $i=0;
                        $out='<span class="qtip" title="';
                        foreach($row['Category'] as $cat)
                        {
                            $i++;
                            $out.=$cat['title'].'<br/>';
                        }
                        $out = substr($out,0,-3);
                        $out.='">'.$i.' catégorie'.($i==1?'':'s').'</span>';
                    }
                }
                else
                {
                    $out='[vide]';
                }
            }
            else{
                $out=$row[$alias][$name];
            }
            echo '<td>'.
           $out
            .'</td>';
        }
        
        echo '<td><span class="actions"><span class="action edit">'.
        
            $this->Html->link('edit',$editUrl.'/'.$row[$alias]['id'])

        .'</span><span class="action delete">'.
        $this->Html->link('X',array(
            'controller'=>$ExtensionName,
            'action'=>'to_trash',
            $row[$alias]['id'],
            'admin'=>true
            ))
        .'</span></span></td>';
        
        if(Configure::read('Config.multilanguage'))
        {
        
            echo '<td>';
                $span_lang='<span class="flags">';
                foreach(Configure::read('Config.languages') as $l)
                {
                    $url['language']=$l;
                    if(!empty($row[$model_name][$l]))
                    {
                        $span_lang.=$this->Html->image($this->Html->url('/img/flags/'.$l.'.png',true)).' ';
                    
                    }
                }
                $span_lang.='</span>';
                
            echo $span_lang.'</td>';
        }
        echo '</tr>';
        
    }
    
    
    
    
    echo '</table>';
    
}