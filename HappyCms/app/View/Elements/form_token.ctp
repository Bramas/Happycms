<?php

echo $this->Form->input('_token',array('type'=>'hidden','name'=>'data[_token]','value'=>$this->Session->read('User.token')));