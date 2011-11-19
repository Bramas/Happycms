<?php
/**
 *   List of extensions
 *
 */
Configure::write('Extensions',array(
    
                                        'pages'=>array(
                                            'name'=>'Pages Simple',
                                            'views'=>array(
                                                'display'=>array(
                                                    'name'=>"Affichage d'une page simple"
                                                    )
                                            )
                                        ),
                                        'menus'=>array(
                                            'name'=>'Menus'
                                           , 'views'=>array(
                                                'sub_menu'=>array(
                                                    'name'=>'Sous menu',
                                                    'icon'=>array(
                                                        'image'=>'skin.png',
                                                        'position'=>'-199px -89px'
                                                        )
                                                    )
                                            )
                                        ),
                                        'home'=>array(
                                            'name'=>"Page d'accueil",
                                            'optgroup'=>'pages'
                                        ),
                                        'contact'=>array(
                                            'name'=>"Formulaire de contact",
                                        ),
                                        'links'=>array(
                                            'name'=>'Lien vers une autre page',
                                            'optgroup'=>'Liens'
                                        ),

                                        'events'=>array(
                                            'name'=>'Agenda',
                                            'menu'=>array(
                                                'title'=>'Agenda',
                                            )
                                        ),

                                        'posts'=>array(
                                            'name'=>'Actualités',
                                            'menu'=>array(
                                                'title'=>'Actualités'
                                            )
                                        )
                        ));

$debug_extension=true;
