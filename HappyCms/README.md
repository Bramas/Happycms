
HappyCMS Documentation
======================

Introduction
------------

 Happy CMS est un un outils entre un CMS est un framwork php MVC. Le but étant de développer avec la facilité d'un framwork mais que le résultat (notament la partie administration) soit intégré facilement dans une interface conventionnée. Il est basé sur le framework CakePHP et conserve tous les conventions de CakePHP. Il est principalement destiné aux développeurs (qui connaissent cakePHP de préférence). Après son installation vous pourrez continuer à développer votre application cakePHP comme d'habitude, et en plus de la gestion de certaines tache récurentes (utilisateurs, menus, pages simples..) vous aurez a disposition plusieurs controllers, models, et un behavior qui permette, en suivant un petit nombre de règles, d'intégré votre controller à HappyCMS. 

 Pour le moment le projet manque un peu d'unité, tout par un peu dans tout les sens, le temps de trouver des conventions.
 Pour le moment aussi le projet ne respect pas les convention cakePHP 2.0 ce qui est dommage.

 Le projet étant encore à ses tout début, il est ouvert à toutes suggestions.

Installation
------------

#### Tools required:
 - CakePHP 2.*

 Pour l'installation il suffit de placer les 3 fichiers (happycms.zip, install.php, unzip.php) sur votre serveur 
et de lancer l'installation SITE_BASE/install.php

 L'installeur ajoute quelques tables et crée deux utilisateurs admin et superadmin.



Example
------------
Voici un exemple rapide pour offrir la possibilité à l'admin de rajouter des pages simples.
Un des principaux avantage de HappyCMS c'est qu'on a pas besoins de toucher à la base de données.


Il nous faut un controller, un model, 2 vues et préciser à HappyCMS que notre extension offre une nouvelle possibilité.

On commence par crée une extension que l'on appel "pages".
`config/extensions.php`

 	Configure::write('Extensions.pages',array(
                                           'name'=>'Pages Simple',
                                           'views'=>array(
                                              'display'=>array(
                                                  'name'=>"Affichage d'une page simple"
                                                  )
                                          )));


 Le code pour le controlleur change très peu d'un controlleur basique n'utilisant pas HappyCMS
`controllers/pages_controller.php`

 	class PagesController extends AppController
 	{
	  	var $uses = array('Page');
		
	  	public function display($id)
		{
			$this->set($this->Page->findById($id));
		}
	  	public function admin_display_edit($id)
		{
			$this->request->data = $this->Page->findById($id);
		}

	  	public function admin_display_new($menu_id)
		{
			//Le menu avec l'id = $menu_id veut afficher une nouvelle page
			//Donc on crée cette page
			$this->Page->create();
			$this->Page->save(	array(
							'Page'=>array(
							'id'=>null,
							'text'=>'Texte par défaut',
							'published'=>1

								)
						));
			//Ensuite on indique au menu l'argument qui devra être envoyé a la fonction display : l'id de la page

			return $this->Page->id;
		}
 	}

Pour le model il faut juste rajouter un Behavior


`models/page.php`

 	class Page extends AppModel
 	{
	  	var $actsAs = array('Content'=>array(
				'extensionName'=>'pages'
						));
		
	}

Pour la vue permettant l'édition d'une page, la différence réside dans l'utilisation d'un élément pour crée le formulaire.

`views/pages/admin_display_edit.ctp`

	<?php
 	echo $this->element('admin_create_form_item');
 	echo $this->Form->input('text');
 	echo $this->element('admin_end_form_item');


Pour la vue dislpay.ctp tout est permis.
 
 
 
 
 
 
 
Copyright and License
------------
 GNU/GPL v3


