/**
 * Plugin designed for test prupose. It add a button (that manage an alert) and a select (that allow to insert tags) in the toolbar.
 * This plugin also disable the "f" key in the editarea, and load a CSS and a JS file
 */  
var EditArea_livecss= {
	/**
	 * Get called once this file is loaded (editArea still not initialized)
	 *
	 * @return nothing	 
	 */	 	 	
	lastTimeKeyUp: 0,

	init: function(){	
		//	alert("test init: "+ this._someInternalFunction(2, 3));
		//editArea.load_css(this.baseURL+"css/test.css");
		//editArea.load_script(this.baseURL+"test2.js");
	}
	/**
	 * Returns the HTML code for a specific control string or false if this plugin doesn't have that control.
	 * A control can be a button, select list or any other HTML item to present in the EditArea user interface.
	 * Language variables such as {$lang_somekey} will also be replaced with contents from
	 * the language packs.
	 * 
	 * @param {string} ctrl_name: the name of the control to add	  
	 * @return HTML code for a specific control or false.
	 * @type string	or boolean
	 *	
	,get_control_html: function(ctrl_name){
		switch(ctrl_name){
			case "test_but":
				// Control id, button img, command
				return parent.editAreaLoader.get_button_html('test_but', 'test.gif', 'test_cmd', false, this.baseURL);
			case "test_select":
				html= "<select id='test_select' onchange='javascript:editArea.execCommand(\"test_select_change\")' fileSpecific='no'>"
					+"			<option value='-1'>{$test_select}</option>"
					+"			<option value='h1'>h1</option>"
					+"			<option value='h2'>h2</option>"
					+"			<option value='h3'>h3</option>"
					+"			<option value='h4'>h4</option>"
					+"			<option value='h5'>h5</option>"
					+"			<option value='h6'>h6</option>"
					+"		</select>";
				return html;
		}
		return false;
	}
	/**
	 * Get called once EditArea is fully loaded and initialised
	 *	 
	 * @return nothing
	 *	 	 	
	,onload: function(){ 
		alert("test load");
	}
	
	/**
	 * Is called each time the user touch a keyboard key.
	 *	 
	 * @param (event) e: the keydown event
	 * @return true - pass to next handler in chain, false - stop chain execution
	 * @type boolean	 
	 */
	 ,updateCss: function()
	 {
	 	window.top.parseLiveCss(parent.editAreaLoader.getValue(editArea.id));
	 }
	 ,timeOutCss:function(date,obj)
	 {
	 	return function(){
	 		//alert(obj.lastTimeKeyUp-date);
			if(date==obj.lastTimeKeyUp)
			{
				window.top.parseLiveCss(parent.editAreaLoader.getValue(editArea.id));
			}
	 	}
	 }
	,onkeydown: function(event){
		
		var d = new Date();
		d = d.getTime();

		

		this.lastTimeKeyUp = d;
		if(event.keyCode==13 || event.keyCode==190 || (event.keyCode==107 && event.altKey && event.ctrlKey))
		{
			//var parser = new(less.Parser);
			
			this.updateCss();
			
			//parser.parse($(this).val(), function (err, tree) {
			//	if (err) { return console.error(err) }
			  //  console.log(tree.toCSS());
			  //  $("#liveCssStyle").html(tree.toCSS());
			  //window.opener.liveCssReload(tree.toCSS());
			//});
		}
		else
		{
			setTimeout(this.timeOutCss(d,this),500);
		}
		return true;
	}
	
	/**
	 * Executes a specific command, this function handles plugin commands.
	 *
	 * @param {string} cmd: the name of the command being executed
	 * @param {unknown} param: the parameter of the command	 
	 * @return true - pass to next handler in chain, false - stop chain execution
	 * @type boolean	
	 */
	,execCommand: function(cmd, param){
		return true;
		// Handle commands
		switch(cmd){
			case "test_select_change":
				var val= document.getElementById("test_select").value;
				if(val!=-1)
					parent.editAreaLoader.insertTags(editArea.id, "<"+val+">", "</"+val+">");
				document.getElementById("test_select").options[0].selected=true; 
				return false;
			case "test_cmd":
				alert("user clicked on test_cmd");
				return false;
		}
		// Pass to next handler in chain
		return true;
	}
	
	/**
	 * This is just an internal plugin method, prefix all internal methods with a _ character.
	 * The prefix is needed so they doesn't collide with future EditArea callback functions.
	 *
	 * @param {string} a Some arg1.
	 * @param {string} b Some arg2.
	 * @return Some return.
	 * @type unknown
	 */
	,_someInternalFunction : function(a, b) {
		return a+b;
	}
};

// Adds the plugin class to the list of available EditArea plugins
editArea.add_plugin("livecss", EditArea_livecss);
