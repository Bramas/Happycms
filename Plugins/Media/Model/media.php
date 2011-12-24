<?php
class Media extends AppModel{
	
	public $validate = array(
		'url' => array(
			'rule' 		 => '/^.*\.(jpg|gif|png|jpeg)$/',
			'allowEmpty' => true,
			'message'	 => "Le fichier n'est pas une image valide"
		)
	);

	public function afterFind($data){
		foreach($data as $k=>$d){
			if(isset($d['Media']['url']) && isset($d['Media']['type']) && $d['Media']['type'] == 'image'){
				$filename = implode('.',array_slice(explode('.',$d['Media']['url']),0,-1));
				foreach(Configure::read('Media.formats') as $kk=>$vv){
					$d['Media']['url'.$kk] = $filename.'_'.$kk.'.jpg';
				}
			}
			$data[$k] = $d;
		}
		return $data;
	}
}