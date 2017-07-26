package controller;
import db.SampleObject;
import haxe.web.Dispatch;
import sugoi.form.Form;



class Main extends sugoi.BaseController {

	@tpl("home.mtt")
	function doDefault() {
		view.section = "home";
		
		//trace(sugoi.i18n.Locale.texts._("Text from code"));
	}	
	
	function doUser(d:Dispatch) {
		//dispatch to a subcontroller 
		d.dispatch(new controller.User());
	}
	
	/**
	 * creates the first user
	 */
	function doInstall() {
		
		if (db.User.manager.get(1) == null) {
			var user = new db.User();
			user.id = 1;
			user.lang = "fr";
			user.email = "admin@localhost";
			user.name = "admin";
			user.pass = haxe.crypto.Md5.encode(App.config.KEY + "admin");
			user.insert();
			app.session.setUser(user);
			throw Ok("/","Admin user created sucessfully");
		}else {
			throw Error("/", "Admin user already exists");
		}
		
		
	}
	
	@tpl('translation.mtt')
	function doTranslation(){
		view.section = "translation";
	}
	
	function doOkMessage() {
		throw Ok("/", "Everything is allright !");
	}
	
	function doErrorMessage() {
		throw Error("/", "Oops, something went wrong !");
	}
	
	@admin
	function doDb(d:Dispatch) {
		d.parts = []; //disable haxe.web.Dispatch
		sys.db.Admin.handler();
	}
	
	
	
}
