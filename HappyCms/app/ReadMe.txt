/* Documentation tag for Doxygen
 */

/*! \mainpage HappyCMS Documentation
 *
 * \section intro_sec Introduction
 *
 * Happy CMS est un un outils entre un CMS est un framwork php MVC. Le but étant de développer avec la facilité d'un framwork mais que le résultat (notament la partie administration) soit intégré facilement dans une interface existante. Il est basé sur le framework CakePHP et conserve tous les conventions de CakePHP. Il est principalement destiné aux développeurs (qui connaissent cakePHP de préférence). Après son installation vous pourrez continuer à développer votre application cakePHP comme d'habitude, et en plus de la gestion de certaines tache récurentes (utilisateurs, menus, pages simples..) vous aurez à disposition plusieurs controllers, models, et un behavior qui permettent, en suivant un petit nombre de règles, d'intégrer votre extension à HappyCMS. 
 * <BR><BR>
 * Le projet à migré récement sur cakePHP 2.0.
 * <BR><BR>
 * Le projet étant encore à ses tout début, il est ouvert à toutes suggestions.
 *
 * \section install_sec Installation
 *
 * \subsection tools_subsec Tools required:
 * - CakePHP 2.*
 *
 * Pour l'installation il suffit de placer les 3 fichiers (happycms.zip, install.php, unzip.php) sur votre serveur 
 * et de lancer l'installation SITE_BASE/install.php
 * <BR><BR>
 * L'installeur ajoute quelques tables et crée deux utilisateurs admin et superadmin.
 *
 *
 *
 * \section example_sec Exemple
 * Voici un exemple rapide pour offrir la possibilité à l'admin de rajouter des pages simples.
 * <BR>Un des principaux avantage de HappyCMS c'est qu'on a pas besoins de toucher à la base de données.
 * <BR>
 * <BR>
 * Il nous faut un controller, un model, 2 vues et préciser à HappyCMS que notre extension offre une nouvelle possibilité.
 * <BR><BR>
 * On commence par crée une extension que l'on appel "pages".<BR>
 * config/extensions.php
 * \code
 * Configure::write('Extensions.pages',array(
 *                                           'name'=>'Pages Simple',
 *                                           'views'=>array(
 *                                              'display'=>array(
 *                                                  'name'=>"Affichage d'une page simple"
 *                                                  )
 *                                          )));
 * \endcode
 * <BR>
 * Le code pour le controlleur change très peu d'un controlleur basique n'utilisant pas HappyCMS
 * <BR><BR>controllers/pages_controller.php
 *\code
 * class PagesController extends AppController
 * {
 *	  	var $uses = array('Page');
 *		
 *	  	public function display($id)
 *		{
 *			$this->set($this->Page->findById($id));
 *		}
 *	  	public function admin_display_edit($id)
 *		{
 *			$this->request->data = $this->Page->findById($id);
 *		}
 *
 *	  	public function admin_display_new($menu_id)
 *		{
 *			//Le menu avec l'id = $menu_id veut afficher une nouvelle page
 *			//Donc on crée cette page
 *			$this->Page->create();
 *			$this->Page->save(	array(
 *							'Page'=>array(
 *							'id'=>null,
 *							'text'=>'Texte par défaut',
 *							'published'=>1
 *
 *								)
 *						));
 *			//Ensuite on indique au menu l'argument qui devra être envoyé a la fonction display : l'id de la page
 *
 *			return $this->Page->id;
 *		}
 *
 *  function admin_display_delete($params)
 *  {
 *      return parent::admin_delete_($params);
 *      
 *  }
 *
 * }
 * \endcode
 *
 * <BR>Pour le model il faut juste rajouter un Behavior
 * <BR>
 * <BR>
 * models/page.php
 *\code
 * class Page extends AppModel
 * {
 *	  	var $actsAs = array('HappyCms.Content'=>array(
 *				'extensionName'=>'pages'
 *						));
 *		
 * }
 *\endcode
 * <BR>Pour la vue permettant l'édition d'une page, la différence réside dans l'utilisation d'un élément pour créer le formulaire.
 * <BR><BR>
 * views/pages/admin_display_edit.ctp
 * \code
 * <?php
 * echo $this->element('admin_create_form_item');
 * echo $this->Form->input('text');
 * echo $this->element('admin_end_form_item');
 * \endcode
 * <BR><BR>Pour la vue dislpay.ctp tout est permis.
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * \section copyright Copyright and License
 * GNU/Gpl v3
 *
 * <BR><BR>
 *
 */