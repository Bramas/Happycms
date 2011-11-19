<- Choisissez une page

<?php
			
	$url = "http://linksite.fr/graph/googleAnalytics/secret:HYBZ4pG459szpr0678OVpvJUUF1WQM9aGK1tsEmwMxAnTpml7VuBQDG8JmRV39Fxt6IXaAlX72Tx3f5t";
	$ch = curl_init();

	//set the url, number of POST vars, POST data
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

	//execute post
	if(!($result = curl_exec($ch))===false)
	{
				
		curl_close($ch);
		$result=json_decode($result,true);
		if(!empty($result['result']))
		{
			$result = $result['data'];
	
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Date');
        data.addColumn('number', 'Visites');
        
        <?php

        echo 'data.addRows('.count($result['last_30_days']).');';

        $idx = 0;
        foreach($result['last_30_days'] as $row)
        {
        	
        	echo 	'data.setValue('.$idx.', 0, "'.preg_replace('/^([0-9]{4})([0-9]{2})([0-9]{2})$/','$3-$2',$row['ga:date']).'");'.
        			'data.setValue('.$idx.', 1, '.$row['ga:visits'].');';
        			$idx++;
        }

        ?>

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, {width: 800, height: 240, title: 'Visites des 30 derniers jours ( total : <?php echo $result['thisMonth'] ?> )'});
      }
    </script>

<div id="googleAnalytics">

<div id="chart_div"></div>

</div>
<?php

		}
	}
	else
	{
		curl_close($ch);
	}

?>