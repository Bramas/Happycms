<?php
$z_i = 0;
//debug(Configure::read('Extensions'));//.'.'.$node['Menu']['view']));
function displayNode($nodes,$place='NULL')
    {
	global $z_i;
	$z_i++;
	
        App::import('Helper', 'Html'); // loadHelper('Html'); in CakePHP 1.1.x.x
        $html = new HtmlHelper();
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
	    $item = current($node);
            $item['Content']=json_decode($node['Content'][$lang]['params']);
           
            
            
            echo '<li id="menu-'.$item['id'].'" menu_id="'.$item['id'].'" class="menu-item-id-'.$item['item_id'].' '.trim($class).'" ><div>';
	    
	    if(empty($node['Menu']['extension']))
	    {
		$url=array('controller'=>'menus',
			   'action'=>'empty_module',
			   $item['id']);
	    }
	    else{
		$url=array('controller'=>'contents',
                           'action'=>'item_edit',
			   'menus',
			   $item['item_id']);
	    }
            
	    $span_lang='<span class="flags">';
            foreach(Configure::read('Config.languages') as $l)
            {
                $url['language']=$l;

            	$temp=json_decode($node['Content'][$l]['params'],true);

                $content = '';
            	if(Configure::read('Config.multilanguage'))
            	{
                	$content = $html->image($html->url('/img/flags/'.$l.'.png',true));
                }

                if(empty($node['Content'][$l]['id']))
                {
                    $content.='<span class="no-lang"> </span>';
                }elseif(empty($temp['published']))
                {
                    $content.='<span lang="'.$l.'" menu_id="'.$item['item_id'].'" class="togglePublished unpublished"> </span>';
                }
                else
                {
                	$content.='<span lang="'.$l.'" menu_id="'.$item['item_id'].'" class="togglePublished published"> </span>';
                }

                $span_lang.=$html->link(
	                $content
	                ,$url,array('escape'=>false,'class'=>$l))
	               ;
                unset($url['language']);
            }
            $span_lang.='</span>';
            
            $title = (empty($item['Content']->title)?__('[Titre]',true):$item['Content']->title);
	    if(empty($node['Content'][$lang]['id']))
	    {
		$title='<span class="warning">Attention</span>'.__('Non disponnible dans cette langue',true);
	    }
            $style = '';
            

            if(($temp = Configure::read('Extensions.'.$node['Menu']['extension'].'.views.'.$node['Menu']['view'].'.icon')))
            {
            	if(is_array($temp))
            	{
            		if(!empty($temp['image']) && $temp['image']!='none')
            		{
	            		$style.="background-image:url('".$html->url('/img/'.$temp['image'])."');";
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
            		$style.="background-image:url('".$html->url('/img/'.$temp)."');";
            	}
            	
            }

            

            echo '<div class="hline"></div><div class="node-expand"></div><div class="icon" style="'.$style.'"></div>'.
            '<span>'.
            ($item['parent_id']?$html->link($title,$url,array('class'=>'page-link','escape'=>false)):$item['title']);
            
	    echo $span_lang;

        if(!empty($item['item_id'])) 
        {
	        echo '<span class="actions">'.
		    /*<span class="action-edit">'.
			$html->link('edit',array('controller'=>'menus','action'=>'edit','admin'=>true,$item['item_id'])).
		    '</span>'.*/
	            /*<span class="action-moveup">'.
			$html->link('^',array('controller'=>'menus','action'=>'moveup','admin'=>true,$item['id'])).
		    '</span><span class="action-movedown">'.
			$html->link('v',array('controller'=>'menus','action'=>'movedown','admin'=>true,$item['id'])).
		    '</span>*/
		    /*'<span class="action-unpublish qtip" title="Cacher la page">'.$html->link('unpublish',array(
		    		'controller'=>'menus',
		    		'action'=>'tooglePublished',
		    		'admin'=>true,
		    		$item['id']

			    )).
		    '</span>'.*/
	            '<span class="action-delete qtip" title="Supprimer la Page (toutes les langues)">'.
		    $html->link('X',array('controller'=>'menus','action'=>'to_trash','admin'=>true,$item['item_id']),array(),"Voulez-vous vraiment supprimer définitivement cette page?").
		    '</span>'.

		    '</span>';
		}
		echo '</span></div>';
	    displayNode($node['children'],$item['id']);
	    echo '</li>';
            
        }
        echo '</ul>';
        
    }
    //debug();
    
    
?>

<div id="menus" class="tree">
    
    
    
	<?php
			$menus = current($menus);
			//debug($menus);
			displayNode($menus['children']);
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
                                
                                
                                
                                
				/*
				 $( sortableSelector ).sortable({
					connectWith: sortableSelector,
					placeholder: "state-receiver",
					cancel: ".ui-state-disabled",
					handle:'span',
					scroll:false,
					tolerance:'intersect',
					revert:true,
					stop: function(event, ui)
					{
						
						if(ui.item.nextAll().length==0)
						{
							ui.item.parent().children('li').removeClass('end');
							ui.item.addClass('end');
						}
						$('.tree .empty').hide();
						$('.tree').removeClass('onMove');
					},
					update: function(event, ui)
					{
						if(done) return;
						
						$('.tree').addClass('disabled');
						$( sortableSelector ).sortable("option", "disabled", true );
						
						done=true;
						
						
						ui.item.parent().parent().removeClass('leaf');
						ui.item.parent().removeClass('empty');
						ui.item.parent().parent().addClass('expand');
						$('.tree .empty').hide();
						if(ui.item.nextAll().length==0)
						{
							ui.item.parent().children('li').removeClass('end');
							ui.item.addClass('end');
						}
						
						
						var move=0;
						
						if(current_parent==ui.item.parent().attr('menu_id'))
						{
							move=ui.item.nextAll().length-current_length;
						}
						else{
							move=ui.item.nextAll().length;
						}
						$.post('<?php echo $html->url(array('controller'=>'menus','action'=>'move','admin'=>true)); ?>',
						{
							"data[Menu][id]":ui.item.attr('menu_id'),
							"data[Menu][parent_id]":ui.item.parent().attr('menu_id'),
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
							if(ui.item.parent().children('li').length>2)
							{
								ui.item.parent().children('li').slice(-3,-2).addClass('end');
							}
							else{
								ui.item.parent().addClass('empty');
								ui.item.parent().parent().addClass('leaf');
							}
						}
						
						current_length= ui.item.nextAll().length-1;
						current_parent= ui.item.parent().attr('menu_id');
						done=false;
						$('.tree .empty').show();
						$('.tree').addClass('onMove');
						//$('.tree ul').append('<li class="receiver"></li>');
						
					}
				});
			/* /
				
				$( '.tree ul ul li' ).append('<div class="receiver"></div>');
				
				//$('.tree .receiver').hide();
				$(sortableSelector+' li.node').draggable( {
					revert: "invalid",
					start:function( event, ui )
					{
						$(this).removeClass('expand');
						//$('.tree .empty').show();
					},
					cursorAt: { left: 0, top:0 },
					drag:function( event, ui )
					{
						
					}
					
				});
				
				$( ".receiver" ).droppable({
					activeClass: "state-active",
					hoverClass: "state-hover",
					drop: function( event, ui ) {
						//$('.tree .empty').hide();
						var t = ui.draggable.detach();
						$(this).parent().after(t);
						t.css('top',0);
						t.css('left',0);
						$(this).parent().parent().removeClass('empty');
						$(this).parent().parent().parent().removeClass('leaf');
						$(this).parent().parent().parent().addClass('expand');
					}
				});
				$( ".node" ).droppable({
					activeClass: "state-active",
					hoverClass: "state-hover",
					disabled:false,
					tolerance:'pointer',
					drop: function( event, ui ) {
							alert($(this).find('span').html());
					}
				});
				/*$( ".node" ).mouseover(function(){
					
					$( ".node" ).droppable("option","disabled",true);
					$(this).droppable("option","disabled",false);
					
				});
				
				// */
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
                                                    
                                                   /*
						     alert('parent_id:'+ui.item.parent().parent().attr('menu_id')+
							  '\n          id:'+ui.item.attr('menu_id')+
							  '\n     move:'+move);
                                                   /*/
                                                   location.href = '<?php echo $html->url(array('controller'=>'menus','action'=>'add_new','admin'=>true)); ?>/'+ui.item.parent().parent().attr('menu_id')+'/'+move;

                                               
                                                   /*$.post('<?php echo $html->url(array('controller'=>'menus','action'=>'move','admin'=>true)); ?>',
                                                    {
                                                            "data[Menu][id]":ui.item.attr('menu_id'),
                                                            "data[Menu][parent_id]":ui.item.parent().parent().attr('menu_id'),
                                                            "data[Move]":move,
                                                    },function(j)
                                                    {
                                                            if(j.result)
                                                            {
                                                                location.reload(true);
                                                            }
                                                            else{
                                                                    $('.tree').html("Une erreur s'est produit, veuillez recharger la page");
                                                            }
                                                            
                                                    },
                                                    "json"
                                                    ); /* */
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
						
						$.post('<?php echo $html->url(array('controller'=>'menus','action'=>'move','admin'=>true)); ?>',
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