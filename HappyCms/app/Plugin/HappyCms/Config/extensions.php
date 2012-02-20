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
                                                    'name'=>'Sous menu (contient d\'autres menus)',
                                                    'menuIcon'=>array(
                                                        'image'=>'/HappyCms/img/skin.png',
                                                        'position'=>'-199px -89px'
                                                        ),
                                                    'mainIcon'=>'/HappyCms/img/navigate.png'
                                                    ),

                                                'top_menu'=>array(
                                                    'enabled'=>false,
                                                    'name'=>'Menu Racine)',
                                                    'menuIcon'=>array(
                                                        'image'=>'/HappyCms/img/skin.png',
                                                        'position'=>'-199px -72px'
                                                        ),
                                                    'mainIcon'=>'/HappyCms/img/navigate.png'
                                                    )
                                            )
                                        ));
Configure::write('Extensions.links',array(
                                            'name'=>'Lien vers une autre page',
                                            'optgroup'=>'Liens'
                                        ));
Configure::write('Extensions.users',array(
                                            'name'=>'Utilisateurs',
                                            'views'=>array(
                                                'register'=>array(
                                                    'name'=>'Creation d\'un compte',
                                                    'mainIcon'=>'/HappyCms/img/user_add.png'
                                                )),
                                            'optgroup'=>'Utilisateur'
                                        ));



