<div class="row">
	<div class="offset1 span15">
		<div id="Page" class="content">

		    

		    <?php
		    if(!empty($item->empty)):
		    
		        echo( __("Cette page n'existe pas dans cette langue."));
		        
		    else:
		        echo($item['text']);
		       
		        endif
		    
		    ?>


		</div>
	</div>
</div>