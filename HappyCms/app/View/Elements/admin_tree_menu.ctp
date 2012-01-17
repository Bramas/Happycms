<?php 

$z_i = 0;
//debug(Configure::read('Extensions'));//.'.'.$node['Menu']['view']));
function displayNode($htmlHelper,$nodes,$place='NULL')
    {
	global $z_i;
	$z_i++;
	
        //App::uses('HtmlHelper', 'View/Helper'); // loadHelper('Html'); in CakePHP 1.1.x.x
        //$html = new HtmlHelper();
        if(empty($nodes))
        {
		
		echo '<ul style="z-index:'.$z_i.'" menu_id="'.$place.'" class="sortable empty"></ul>';
            return;
        }
        
        echo '<ul style="z-index:'.$z_i.'" menu_id="'.$place.'" class="sortable">';
		$i=0;
        foreach($nodes as $node)
        {
		    $i++;
		    $class="node ";
		    if($i==count($nodes))
		    {
				$class.="end ";
		    }
		    if(empty($node['children']))
		    {
				$class.="leaf ";
		    }
		    $lang=Configure::read('Config.language');
            $menu=$node['Menu'];
          
            
            
            echo '<li id="menu-'.$menu['id'].'" menu_id="'.$menu['id'].'" class="menu-item-id-'.$menu['id'].' '.trim($class).'" ><div>';
	    
		    if(empty($menu['extension']))
		    {
				$url=array(
					'controller'=>'menus',
				   	'action'=>'empty_module',
				   	$menu['id']
				);
		    }
		    else{
				$url=array(
					'controller'=>'contents',
	                'action'=>'item_edit',
				   	'menus',
				   	$menu['id']
				);
		    }
            
	    	$span_lang='<span class="flags">';
            foreach(Configure::read('Config.languages') as $l)
            {
                $url['language']=$l;

            	$temp=$menu[$l];

                $content = '';
            	if(Configure::read('Config.multilanguage'))
            	{
                	$content = $htmlHelper->image($htmlHelper->url('/img/flags/'.$l.'.png',true));
                }

                if(empty($temp['id']))
                {
                    $content.='<span class="no-lang"> </span>';
                }elseif(empty($temp['published']))
                {
                    $content.='<span lang="'.$l.'" menu_id="'.$menu['id'].'" class="togglePublished unpublished"> </span>';
                }
                else
                {
                	$content.='<span lang="'.$l.'" menu_id="'.$menu['id'].'" class="togglePublished published"> </span>';
                }

                $span_lang.=$htmlHelper->link($content,$url,array('escape'=>false,'class'=>$l));
                unset($url['language']);
            }
            $span_lang.='</span>';
            
            $title = (empty($menu['title'])?__('[Titre]',true):$menu['title']);
		    if(empty($menu[$lang]['id']))
		    {
				$title='<span class="warning">Attention</span>'.__('Non disponnible dans cette langue',true);
		    }
            $style = '';
            

            if(($temp = Configure::read('Extensions.'.$menu['extension'].'.views.'.$menu['view'].'.icon')))
            {
            	if(is_array($temp))
            	{
            		if(!empty($temp['image']) && $temp['image']!='none')
            		{
	            		$style.="background-image:url('".$htmlHelper->url($temp['image'])."');";
	            	}
	            	elseif(isset($temp['image']))
	            	{
	            		$style.="background-image:none;";
	            	}

					if(!empty($temp['position']))
            		{
	            		$style.="background-position:".$temp['position'].";";
	            	}

            	}
            	else
            	{
            		$style.="background-image:url('".$htmlHelper->url('/img/'.$temp)."');";
            	}
            	
            }

            

            echo '<div class="hline"></div><div class="node-expand"></div><div class="icon" style="'.$style.'"></div>'.
            '<span>'.
            ($menu['parent_id']?$htmlHelper->link($title,$url,array('class'=>'page-link','escape'=>false)):$menu['title']);
            
	    echo $span_lang;

        if(!empty($menu['id'])) 
        {
	        echo '<span class="actions">'.
		    
	            '<span class="action-delete qtip" title="Supprimer la Page (toutes les langues)">'.
		    $htmlHelper->link('X',array('controller'=>'menus','action'=>'to_trash','admin'=>true,$menu['id']),array(),"Voulez-vous vraiment supprimer définitivement cette page?").
		    '</span>'.

		    '</span>';
		}
		echo '</span></div>';
	    displayNode($htmlHelper,$node['children'],$menu['id']);
	    echo '</li>';
            
        }
        echo '</ul>';
        
    }
    //debug();
    
    
?>

<div id="menus" class="tree">
    
    
    
	<?php
			$menus = $menus[0]['children'];
			//debug($menus);
			displayNode($this->Html,$menus);
			echo $this->Html->link('nouveau menu racine',array('controller'=>'menus','action'=>'add_new','admin'=>true,1,0));
		?>



		</div>
		<script type="text/javascript">
		
		$('.tree ul li .node-expand').click(function(){
		    $(this).parent().parent().toggleClass('expand');
		});
		
		//$('.tree>ul>li>ul>li').toggleClass('expand');
		$('.tree>ul>li').toggleClass('expand');

		var c = $('.tree>ul>li .current');

		c.toggleClass('expand');
		while(c.parent().parent().length>0)
		{
			c=c.parent().parent();
			c.toggleClass('expand');
		}
		
		$('.tree a').each(function(){
		
		if($(this).attr('href')=='<?php echo $this->here; ?>')
		{
			$(this).parent().parent().addClass('current');
			$(this).parent().parents('li').addClass('expand');
		}
			
		});
		
		
		</script>

		<script>
                
                $('.tree>.sortable>li>.sortable').append('<li title="Placez-moi à l\'emplacement de la nouvelle page" class="add-page no-nest qtip"><div><div class="icon"></div><span>Nouvelle page</span></div></li>');
		
			$(function() {
				var sortableSelector = '.sortable .sortable';
				var done=false;
				var current_parent=-1;
				var current_length=-1;
                                
				$('.tree>ul.sortable>li>ul.sortable.empty').removeClass('empty');
                                
                                
                                
                                
				
                var last_ui;
                $('.tree>.sortable>li>.sortable').nestedSortable({
					disableNesting: 'no-nest',
					forcePlaceholderSize: true,
					handle: 'div',
					helper:	'clone',
					items: 'li',
					listType: 'ul',
					maxLevels: 2,
					opacity: .6,
					placeholder: 'placeholder',
					revert: 250,
					tabSize: 25,
                    distance: 15,
					tolerance: 'pointer',
					toleranceElement: '> div',
					stop:function(event,ui)
					{
						ui.item.attr('style','');
						
						if(ui.item.nextAll('li.node').length==0)
						{
							ui.item.parent().children('li.node').removeClass('end');
							ui.item.addClass('end');
						}
						$('.tree .empty').hide();
						$('.tree').removeClass('onMove');
                                                if(ui.item.hasClass('add-page'))
                                                {
                                                    
                                                    ui.item.parent().parent().removeClass('leaf');
                                                    ui.item.parent().removeClass('empty');
                                                    ui.item.parent().parent().addClass('expand');
                                                    
                                                    current_length++;
                                                    
                                                    var move=ui.item.nextAll('li.node').length;
                                                    
                                                   
                                                   location.href = '<?php echo $this->Html->url(array('controller'=>'menus','action'=>'add_new','admin'=>true)); ?>/'+ui.item.parent().parent().attr('menu_id')+'/'+move;

                                               
                                                   
                                                }
					},
					update:function(event,ui)
					{
                                            
						if(done) return;
						
						$('.tree').addClass('disabled');
						$( sortableSelector ).sortable("option", "disabled", true );
						
						done=true;
                                                
						if(ui.item.hasClass('add-page')) return;
						
						ui.item.parent().parent().removeClass('leaf');
						ui.item.parent().removeClass('empty');
						ui.item.parent().parent().addClass('expand');
						
						
						var move=0;
						
						if(current_parent==ui.item.parent().parent().attr('menu_id'))
						{
							move=ui.item.nextAll('li.node').length-current_length;
						}
						else{
							move=ui.item.nextAll('li.node').length;
						}
						
						$.post('<?php echo $this->Html->url(array('controller'=>'menus','action'=>'move','admin'=>true)); ?>',
						{
							"data[Menu][id]":ui.item.attr('menu_id'),
							"data[Menu][parent_id]":ui.item.parent().parent().attr('menu_id'),
							"data[Move]":move,
						},function(j)
						{
							if(j.result)
							{
								$('.tree').removeClass('disabled');
								$(sortableSelector).sortable("option","disabled", false );
							}
							else{
								$('.tree').html("Une erreur s'est produit, veuillez recharger la page");
							}
							
						},
						"json"
						);
						
					},
					start: function(event, ui)
					{
					
						if(ui.item.hasClass('end'))
						{
							ui.item.removeClass('end');
							//alert(ui.item.parent().attr('menu_id'));
							if(ui.item.parent().children('li.node').length>3)
							{
								
								ui.item.parent().children('li.node').slice(-3,-2).addClass('end');
							}
							else{
								ui.item.parent().addClass('empty');
								ui.item.parent().parent().addClass('leaf');
							}
						}
						current_length= ui.item.nextAll('li.node').length-1;
						current_parent= ui.item.parent().attr('menu_id');
						done=false;
						$('.tree .empty').show();
						
						$('.tree').addClass('onMove');
						//$('.tree ul').append('<li class="receiver"></li>');
						
					}
					
				});
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
			});
		</script>
