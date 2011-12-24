<?php

if(file_exists('../Config/extensions.php'))
{
    require_once '../Config/extensions.php';
}
/**
 *   List of Core extensions
 *
 */
Configure::write('Extensions.menus',array(
                                            'name'=>'Menus',
                                            'views'=>array(
                                                'sub_menu'=>array(
                                                    'name'=>'Sous menu',
                                                    'icon'=>array(
                                                        'image'=>'skin.png',
                                                        'position'=>'-199px -89px'
                                                        )
                                                    )
                                            )
                                        ));
Configure::write('Extensions.links',array(
                                            'name'=>'Lien vers une autre page',
                                            'optgroup'=>'Liens'
                                        ));


