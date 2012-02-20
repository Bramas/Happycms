<div class="row" id="Post">

    
    <div class="span11 offset1">
            <?php
				echo '<div class="head-image">'.$this->Html->image('/files/uploads/posts/'.$Post['img'].'_600x150').'</div>';
                echo $Post['text'];
            
            ?>
            <h3>Commentaires</h3>

		<div class="Comments">
	        <?php 

	        App::uses('FormHelper','View/Helper');
	        $this->From = new FormHelper($this);
	        ob_start();
	        
	        ?>
	        <div class="addComment">
	            <?php 
			if($User['real'])
	        {

	            echo $this->From->create('Comment',array('class'=>'add-comment'));
	            echo $this->Form->input('Comment.message',array('type'=>'textarea','labe'=>'Votre message : ','rows'=>'3','cols'=>'100'));
	            echo $this->Form->submit('Envoyer');
	        }
	        else
	        {
	        	echo 'Vous devez vous connecter pour envoyer un commentaire - '.$this->Html->link('se connecter',array('controller'=>'users','action'=>'login'));
	        }
	             ?>

	             <div class="clear"></div>
	             </form>
	        </div>
	        <?php


	            $addComment = ob_get_clean();
	            $allowedDelete = requestAllowed('posts','admin_comments_delete',true,$User);
				if(count($Comment))
	            {
	            	echo $addComment;

		            foreach($Comment as $comment)
		            {
		                echo '<div class="comment">'; 

		                echo '<div class="avatar">'.$this->Html->image((empty($comment['User']['avatar'])?'/files/uploads/users/anonymous.jpg':'/files/uploads/users/'.$comment['User']['avatar']).'_100x100').'</div>';
		                echo '<div class="user">'.$this->Html->link($comment['User']['username'],array('controller'=>'users','action'=>'view',$comment['User']['id'].'-'.$comment['User']['username'])).'</div>';
		                echo '<div class="date">Il y à '.humanTiming(strtotime($comment['created'])).'</div>';
		                
	                    if($allowedDelete) 
	                    {
	                        echo '<div class="action delete">'.$this->Html->link('Supprimer',
	                        array(
		                        'controller'=>'posts',
	                       	 	'action'=>'comments_delete',
	                       	 	'admin'=>true,
	                       	 	'_token'=>$this->Session->read('User.token'),
	                       	 	$comment['id'])).'</div>';
	                    }
		                echo '<div class="message">'.$comment['message'].'</div>';
		                echo '<div class="clear"></div></div>'; 
		            }
		        }
		        else
		        {
		        	//echo '<div class="no-comment">Aucun commentaire</div>';
		        }
	            echo '<div class="comment myNextCom" style="display:none">'; 

	                echo '<div class="avatar">'.$this->Html->image((empty($User['avatar'])?'/files/uploads/users/anonymous.jpg':'/files/uploads/users/'.$User['avatar']).'_100x100').'</div>';
	                echo '<div class="user">'.$this->Html->link($User['username'],array('controller'=>'users','action'=>'view',$User['id'].'-'.$User['username'])).'</div>';
	                echo '<div class="date"> à l\'instant</div>';
	                
	                echo '<div class="message"></div>';
	                echo '<div class="clear"></div></div>'; 
	            echo '<div class="clear"></div>
        </div>';

	            echo $addComment;

	        ?>
       	<script type="text/javascript">

       	$(function(){
       		$('form.add-comment').submit(function(e)
       		{
       			e.preventDefault();
       			$.ajax({
       				url:'<?php echo $this->Html->url(
       					array('controller'=>'posts','action'=>'addComment')
	       				) ?>',
	       			type:"post",
	       			data:{
	       				"data[Comment][fre][message]":$(this).find('#CommentMessage').val(),
	       				"data[Comment][fre][post_id]":<?php echo $Post['id'] ?>
	       			},
	       			context:this,
	       			dataType:'json',
	       			success:function(d)
	       			{
	       				if(d.result)
	       				{
	       					nextCom = $('.Comments .comment.myNextCom').clone();
	       					nextCom.find('.message').html($(this).find('#CommentMessage').val());
	       					$('.Comments').append(nextCom);
	       					nextCom.removeClass('myNextCom').slideDown('slow');
	       					//$('.Comments .no-comment').slideUp('slow');
	       				}
	       				else
	       				{
	       					alert('le message n\'a pas pu être envoyé');
	       				}
                        $('.addComment .wait').remove();
                        $('form.add-comment').slideDown('slow');
	       			}

       			});
                $(this).slideUp('slow');
                var w = $('<div class="wait">Chargement...</div>');
                w.hide();
                $(this).after(w);
                w.slideDown('slow');


       		});

       	})

       	</script>

    </div>
    <div class="span4">
            <?php echo $this->element('list_actus'); ?>
    </div>  
</div>



