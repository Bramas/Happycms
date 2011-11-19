<?php
//foreach($this as $name=>$t)
{
    //if($name!='viewVars')
    //debug($this->data);
}
/*
if(empty($this->data['Happy']) || empty($this->data['Happy']['lang_form']))
{
    $this->data['Happy']=array('lang_form'=>Configure::read('Config.language'));
}*/
if(empty($this->data['Happy']))
{
    $this->data['Happy']=array();
}
$this->data['Happy']=array_merge(array(
                                       'lang_form'=>Configure::read('Config.language'),
                                       'first_call'=>false
                                       ),(array)$this->data['Happy']);




if(empty($this->data['Happy']['model_name']))
{
    $this->data['Happy']['model_name']='Content';
}

if(!empty($formOptions))
{
    $formOptions=array_merge(array('action'=>'save'),(array)$formOptions);
}
else{
    $formOptions=array('action'=>'save');
}
$formOptions['url']='/admin/'.$ExtensionName.'/'.$formOptions['action'];

if(!empty($file) || ( !empty($formOptions['type']) && $formOptions['type']=='file' ) )
{
    $formOptions['type']='file';
    $this->fileFormLoaded=true;
    if($this->data['Happy']['first_call'])
    {
        
        App::import('Helper','Plupload');
        $this->pupload = new PluploadHelper();
        echo $html->script($this->pupload->script());
        echo $html->script('plupload.field');
            ?>
        <div id="container">
                <div id="filelist"></div>
        </div>
        
        
        <div id="explorer" style="display:none">

        </div>

        <?php
    }
}


$token_input = '<input name="data[_token]" type="hidden" value="'.$this->Session->read('User.token').'">';

$create = $form->create(isset($modelName)?$modelName:$this->data['Happy']['model_name'],$formOptions);

$this->data['Happy']['output']['formOptions']=$formOptions;

$form->langField='';
/*if(empty($this->data['Content']['id']))
{
}*/
//debug($this->data);
if($this->data['Happy']['first_call'])
{
    echo $create.$token_input;
}

echo $form->input('_extension',array('type'=>'hidden','value'=>empty($this->data['Content']['_extension'])?$ExtensionName:$this->data['Content']['_extension']));
echo $form->input('id',array('type'=>'hidden'));
//echo $form->input($this->data['Happy']['lang_form'],array('type'=>'hidden','value'=>'1'));

$form->langField=$this->data['Happy']['lang_form'];


?>