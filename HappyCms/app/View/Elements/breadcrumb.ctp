<ul class="breadcrumb">
<?php 
$breadcrumbs = '';
$divider = '<span class="divider">»</span>';
$dividerRegex = '<span class="divider">»<\/span>';

$breadcrumbs .= '<li>'.$this->Html->link('Accueil','/').$divider.'</li>';
//debug($breadcrumps);
if(!empty($breadcrumps))
{

            $breadcrumbs .= '<li>'.$breadcrumps.'</li>';

}
elseif(!empty($menuPath))
{
	$idx=0;
	foreach($menuPath as $menuPathItem)
    {
		$idx++;
    	if(($temp=$this->Happy->getMenu($menuPathItem['Menu']['id']))!==false)
    	{
    		if(count($menuPath)==$idx)
    		{
    			$breadcrumbs .= '<li>'.$temp['Content']['title'].$divider.'</li>';
    		}
    		else
    		{
    			$breadcrumbs .= '<li>'.$temp['link'].$divider.'</li>';
    		}
    		

    	}
    }
}
    

$breadcrumbs = preg_replace('/'.$dividerRegex.'<\/li>$/','</li>',$breadcrumbs);
echo $breadcrumbs;

 ?>



</div>