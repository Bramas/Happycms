<?php
/**
 * CakePHP TinyMCE Plugin
 *
 * Copyright 2009 - 2010, Cake Development Corporation
 *                        1785 E. Sahara Avenue, Suite 490-423
 *                        Las Vegas, Nevada 89104
 *
 * Licensed under The LGPL License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2009 - 2010, Cake Development Corporation (http://cakedc.com)
 * @link      http://github.com/CakeDC/TinyMCE
 * @package   plugins.tiny_mce
 * @license   LGPL License (http://www.opensource.org/licenses/lgpl-2.1.php)
 */

/**
 * Short description for class.
 *
 * @package  plugins.tiny_mce.views.helpers
 */

class TinymceHelper extends AppHelper {

/**
 * Other helpers used by FormHelper
 *
 * @var array
 * @access public
 */
	public $helpers = array('Html','Javascript');

/**
 * 
 *
 * @var array
 * @access public
 */
	public $configs = array();

/**
 * 
 *
 * @var array
 * @access protected
 */
	protected $_defaults = array();

/**
 * Adds a new editor to the script block in the head
 *
 * @see http://wiki.moxiecode.com/index.php/TinyMCE:Configuration for a list of keys
 * @param mixed If array camel cased TinyMce Init config keys, if string it checks if a config with that name exists
 * @return void
 * @access public
 */
	public function editor($options = array()) {
		if (is_string($options)) {
			if (isset($this->configs[$options])) {
				$options = $this->configs[$options];
			} else {
				throw new OutOfBoundsException(sprintf(__('Invalid TinyMCE configuration preset %s', true), $options));
			}
		}
		$options = array_merge($this->_defaults, $options);
		$lines = '';
		
		foreach ($options as $option => $value) {
			$lines .= Inflector::underscore($option) . ' : "' . $value . '",' . "\n";
		}
		echo $this->Html->scriptBlock('/*  */
				function	addEditors(){
					      tinyMCE.init({' . "\n" . $lines .
						  ' width : \'100%\'  ,
						  height:\'300px\',
						  language : \'fr\' ,
						plugins : "videos,media,files,images,safari,pagebreak,style,layer,table,advimage,advlink,inlinepopups,searchreplace,contextmenu,paste,directionality,fullscreen",
						relative_urls : false,
						oninit:function()
						{
							$("textarea").addClass("noeditor");
						},
						editor_deselector : "noeditor",
						
theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontsizeselect,|,code,|,fullscreen",
theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,media,|,link,unlink,image",
theme_advanced_buttons3 : "images,files,videos",
file_browser_callback : "myFileBrowser"
					
    
						
});
}

addEditors();

function myFileBrowser (field_name, url, type, win) {

     //alert("Field_Name: " + field_name + "nURL: " + url + "nType: " + type + "nWin: " + win); // debug/testing

    /* If you work with sessions in PHP and your client doesn\'t accept cookies you might need to carry
       the session name and session ID in the request string (can look like this: "?PHPSESSID=88p0n70s9dsknra96qhuk6etm5").
       These lines of code extract the necessary parameters and add them back to the filebrowser URL again. */

    var cmsURL = window.location.toString();    // script URL - use an absolute path!
    if (cmsURL.indexOf("?") < 0) {
        //add the type as the only query parameter
        cmsURL = cmsURL + "?type=" + type;
    }
    else {
        //add the type as an additional query parameter
        // (PHP session ID is now included if there is one at all)
        cmsURL = cmsURL + "&type=" + type;
    }

    tinyMCE.activeEditor.windowManager.open({
        file : " '.$this->Html->url('//js/tiny_mce/plugins/files/images.htm',true).'",
        title : "My File Browser",
        width : 710,  // Your dimensions may differ - toy around with them!
        height : 560,
        resizable : "yes",
        inline : "yes",  // This parameter only has an effect if you use the inlinepopups plugin!
        close_previous : "no"
    }, {
        window : win,
        input : field_name
    });
    return false;
  }

' . "\n", array(
			'inline' => true));
	}

/**
 * beforeRender callback
 *
 * @return void
 * @access public
 */
	public function script() {
		echo $this->Html->script('tiny_mce/tiny_mce');
	}
}
?>