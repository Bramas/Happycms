<?php

/** Configure your extension
*  <BR>
*       This information is used in the admin side when the admin create a new page and choose what kind of extension
*   the new page will display. Moreover you can set the icon of the page (displayed in the admin tree menu)
*
*   \example
*<BR><BR>
*   Custom example:
*   <BR>
*   if you have an EventsController with views index and view (to list all events and see an event in details)
*   \code
*   'events'=>array(
*       'name'=>'Events manager',
*       'views'=>array(
*           'index'=>array(
*               'name'=>'List all the events',
*               'icon'=>array(
*                   'image'=>'skin.png',
*                   'position'=>'-199px -89px' //you can set background position if you use sprite
*                   )
*               ),
*           'view'=>'Display an event in details' //Or you can just set the name lile this
*           ),
*       
*       // ------------ other params
* 
*       'menu'=>array(
*           'title'=>'Manage your events'   // This will add a link into the left menu of the admin panel
*           ),                              // that link to /admin/events/menu_index/
*       'optgroup'=>'Events'   // You can set this if you what to use a different name in the list of extension
*                              // or if you what to group this extension with other extension
*       )
*   \endcode
*<BR><BR>
*   An other extension for your CalendarController
*<BR><BR>
*\code
*   'calendar'=>array(
*       'name'=>'Calendar',
*       'views'=>array(
*           'display'=>'Display the calendar'
*           ),
*       'optgroup'=>'Events'            // Here we see how we can use 'optgroup'
*       )
*       \endcode
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
                                        'contact'=>array(
                                            'name'=>"Formulaire de contact",
                                        ),
                                        'posts'=>array(
                                            'name'=>'Actualités',
                                            'menu'=>array(
                                                'title'=>'Actualités'
                                            )
                                        ),
                                        'home'=>array(
                                            'name'=>'Page d\'accueil'
                                        ),
                                        'galleries'=>array(
                                            'name'=>'Galerie de photos',
                                            'views'=>array(
                                                'index'=>'Liste des Galeries'
                                            ),
                                            'menu'=>array(

                                                'title'=>'Galeries photos'

                                            ))
                        ));

/** if this is set to true, then when it will check the if all your extensions are in the database,
*   and add it if necessary
*
*/
$refresh_extension=false;