<?php
class AppError extends ErrorHandler {
	//var $layout='error';
    function happycms_error($params) {

        debug(array('Error : '=>$params));
        exit();
 // $this->controller->set('file', $params['file']);
 //$this->layout='error';
  //$this->_outputMessage('happycms_error');
}
	

}	
?>
