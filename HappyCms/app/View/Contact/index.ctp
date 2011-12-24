<div id="contact">
    <div class="row">
      <div class="span8">
        <div class="info">
        <?php
          echo $Content['text'];
          ?>
        </div>
        <div class="googlemap">
                  <?php
          list($lat,$lng,$zoom) = explode('|',$Content['googlemaps']);

          ?>
          <script type="text/javascript"
              src="http://maps.google.com/maps/api/js?sensor=false">
          </script>
          <div id="map_canvas" style="width:350px; height:250px"></div>

          <script type="text/javascript">
            
            jQuery(document).ready(function() {
          	
          	var defaultLng = <?php echo $lng; ?>;
          	var defaultLat = <?php echo $lat; ?>;
          	
          	var latlng = new google.maps.LatLng(defaultLat, defaultLng);
          	var myOptions = {
          	  zoom: <?php echo $zoom; ?>,
          	  center: latlng,
          	  mapTypeId: google.maps.MapTypeId.ROADMAP,
                    mapTypeControl:false,
                    streetViewControl:false
          	};
          	var map = new google.maps.Map(document.getElementById("map_canvas"),
          	    myOptions);
                
                
                var marker = new google.maps.Marker({
          	    position: latlng, 
          	    map: map,
          	    title:"Déplacez-moi",
          	    draggable: true,
          	});
               
                                      

            });
          </script>
      </div>
    </div>
    <div class="span8">
        <?php
        echo $this->Form->create("Contact",
                   array("url" =>
                         array("controller"=>"Contact",
                               "action" => "index")));
        ?>

      
      <?php
      
      echo '<div class="clearfix">';
      echo $this->Form->input("nom",array("label" => __('Votre Nom (ou Organisme)',true))); 
      echo '</div><div class="clearfix">';
      echo $this->Form->input("email",array("label" => __('Votre Email',true))); 
      echo '</div><div class="clearfix">';
      echo $this->Form->input("message",array('type'=>'textarea',"label" => __('Votre Message',true))); 
      echo '</div>';

    echo '<div class="actions">';
      echo $this->Form->submit(__('Envoyer',true),array('class'=>'btn primary'));
      echo '</div>';
      echo $this->Form->end();
        ?>     
    </div>
  </div>
</div>