<?php

echo $form->input('_token',array('type'=>'hidden','name'=>'data[_token]','value'=>$this->Session->read('User.token')));