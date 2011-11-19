<?php
if(!empty($name))
{
    if(!empty($this->data[$this->data['Happy']['model_name']][$this->data['Happy']['lang_form']][$name]))
    {
        $def=explode('|',$this->data[$this->data['Happy']['model_name']][$this->data['Happy']['lang_form']][$name]);
    }
    if(empty($def[0]))
    {
            $lat=45.783806;
    }
    else
    {
            $lat = $def[0];
    }
    if(empty($def[1]))
    {
            $lng= 3.168182;
    }
    else
    {
            $lng = $def[1];
    }
    if(!isset($def[2]))
    {
            $zoom = 8;
    }
    else
    {
            $zoom = $def[2];
    }
		
		
		?>
                
                <script type="text/javascript"
    src="http://maps.google.com/maps/api/js?sensor=false">
</script>
<br/>
  <div id="map_canvas_<?php echo $form->domId($name); ?>" style="width:350px; height:250px"></div>

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
	var map = new google.maps.Map(document.getElementById("map_canvas_<?php echo $form->domId($name); ?>"),
	    myOptions);
      
      
      var marker = new google.maps.Marker({
	    position: latlng, 
	    map: map,
	    title:"Déplacez-moi",
	    draggable: true,
	});
      function QBUpdateForm(ll)
      {
            $('#<?php echo $form->domId($name); ?>').val(ll.lat()+"|"+ll.lng()+"|"+map.getZoom());
      };
      google.maps.event.addListener(marker, 'dragend', function(event) {
	QBUpdateForm(event.latLng);
      });
       google.maps.event.addListener(map, "idle", function() {
	QBUpdateForm(marker.getPosition());
      });
        function tabsHack(map,marker)
        {
                  return function()
                  {
		    
                                google.maps.event.trigger(map, 'resize');
                                map.setCenter(marker.getPosition());
                  };
        };
                                
    $( "#languages-tabs, .tabs" ).bind( "tabsshow",tabsHack(map,marker));

  });
</script>

<?php
    echo $form->input($name,array('type'=>'hidden'));
    
}