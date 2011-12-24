<?php

App::uses('Helper', 'View');
     //   throw new Exception('lol');
class AppHelper extends Helper
{
    
    function url($url=array(),$full=false,$ext = false)
    {
     //debug($url);
     if($ext)
     {
          return parent::url($url,$full);
     }
     if(is_array($url))
     {
         if(empty($url['plugin']))
        {
            $url['plugin'] = null;
        }
     }
     if(Configure::read('Config.multilanguage'))
     {
        if(is_array($url))
        {
            if(empty($url['plugin']))
            {
                $url['plugin'] = null;
            }
            if(!isset($url['language']))
            {
               $url['language'] = Configure::read('Config.language');
            }
            if(empty($url['controller']) && empty($url['action']))
            {
                //debug($url['language'].'/'.substr($this->params['url']['url'],4));
                if(preg_match('/^[a-z]{3}\/$/',substr($this->params['url']['url'].'/',0,4)) &&
                   in_array(substr($this->params['url']['url'],0,3),Configure::read('Config.languages')))
                {
                    //debug('lol');
                    return parent::url('/'.$url['language'].'/'.substr($this->params['url']['url'],4),$full);
                }
                if(preg_match('/^admin\/[a-z]{3}\/$/',substr($this->params['url']['url'].'/',0,10)) &&
                   in_array(substr($this->params['url']['url'],6,3),Configure::read('Config.languages')))
                {
                    //debug('lol');
                    return parent::url('/admin/'.$url['language'].'/'.substr($this->params['url']['url'],10),$full);
                }
                else{
                    return parent::url('/'.$url['language'].'/'.substr($this->params['url']['url'],0),$full);
                }
               /*foreach($this->params['pass'] as $p)
               {
                    $url[]=$p;
               }*/
            }
            return parent::url($url,$full);
        }
        /*$r = str_replace('/','',preg_replace('[\S]*(\/[a-z]{3}[\/])+[\S]*','$1',$url));
        if(in_array($r,Configure::read('Config.language')) ||
           in_array($r = substr($url,0,3),Configure::read('Config.languages')) ||
           in_array($r = substr($url,-3),Configure::read('Config.languages')))
        {
            
            
        }*/
        /* */
        
      //  if(preg_math('/\./g',$url))
        {
          //  return parent::url($url,$full);
        }
        if(preg_match('/\/img\//',$url))
        {
            return parent::url($url,$full);
        }
        if(preg_match('/\/files\//',$url))
        {
            return parent::url($url,$full);
        }
        //debug(substr($url,0,7).'--'.substr($url,7,3));
        if($url=="/")
        {
               $url.=Configure::read('Config.language');
            return parent::url($url,$full);
        }
        if($url=="/admin/")
        {
               $url.=Configure::read('Config.language');
            return parent::url($url,$full);
        }
         if(substr($url,0,7)=="/admin/")
        {
            if(!preg_match("/^[a-z]{3}\//",substr($url,7,4)))
            
               $url=substr($url,0,7).Configure::read('Config.language').'/'.substr($url,7);
        }
        /* */
        
        if(substr($url,0,7)=='http://')
        {
            return parent::url($url,$full);
        }
        
        
        
        $r = substr($url.'/',0,4);
        if(substr($url,-1)=='/' && in_array($r = substr($url,0,3),Configure::read('Config.languages')))
        {
            return parent::url($url,$full);
        }
        
        
        if(substr($url,0,7)=='/admin/')
        {
          
          if(in_array(substr($url,7,3),Configure::read('Config.languages')))
          {
               return parent::url($url,$full);
          }
        }
        
        $r = substr($url.'/',0,1);
        if($r!='/')
        {
            $r='';
            $url= '/'.$url;
        }
        
        return parent::url($r.Configure::read('Config.language').$url,$full);

    }
    return parent::url($url,$full);
        /**/
        
    }
    
    var $langField = null;
    
    protected function _initInputField($field, $options = array()) {

            if($this->langField===null && !empty($this->_View->langField))
            {
                $this->langField=$this->_View->langField;
            }
		$options = (array)$options;
		if ($field !== null) {
                    if(empty($this->langField))
                    {
                        $this->setEntity($field);
                    }
                    else
                    {
                        $this->setEntity($this->_modelScope.'.'.$this->langField.'.'.$field);
                        if(empty($options['id']))
                        {
                            $options['id']=$this->_modelScope . join('', array_map(array('Inflector', 'camelize'), array($this->langField,$field)));
                        }
                    }
                        
		}
		$options = $this->_name($options);
		$options = $this->value($options);
		$options = $this->domId($options);
		if ($this->tagIsInvalid()) {
			$options = $this->addClass($options, 'form-error');
		}
		return $options;
	}
        
    function domId($options = null, $id = 'id') {
		if (is_array($options) && array_key_exists($id, $options) && $options[$id] === null) {
            unset($options[$id]);
            return $options;
        } elseif (!is_array($options) && $options !== null) {
            $this->setEntity($options);
            return $this->domId();
        }

        $entity = $this->entity();
		$model = array_shift($entity);
                //debug($options);
                if(!empty($options[$id]))
                {
                    $dom=$options[$id];
                }
                else//if(empty($this->langField))
                {
                    $dom = $model . join('', array_map(array('Inflector', 'camelize'), $entity));
                }
              /*  else
                {
                    $dom = $model . join('', array_map(array('Inflector', 'camelize'), array_merge((array)$this->langField,$entity)));
                }*/

        //$dom = $model . join('', array_map(array('Inflector', 'camelize'), $entity));



		if (is_array($options) && !array_key_exists($id, $options)) {
            $options[$id] = $dom;
        } elseif ($options === null) {
            return $dom;
        }
        return $options;
	}
}

?>