package controller;
import db.SampleObject;
import haxe.web.Dispatch;
import sugoi.form.Form;
import Common;

class Main extends sugoi.BaseController {

	@tpl("home.twig")
	function doDefault() {
		view.section = "home";
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
	
	@tpl('translation.twig')
	function doTranslation(){
		view.section = "translation";
	}
	
	function doOkMessage() {
		throw Ok("/", "Everything is allright !" );
	}
	
	function doErrorMessage() {
		throw Error("/", "Oops, something went wrong !" );
	}

	@tpl('twig.twig')
	function doTwig(){

		var colorMap : Map<String,String> = [
			"first"  => "red",
			"second" => "orange",
			"third"  => "green"
		];

		var colorArray = ["red","orange","green"];
		var colorList = Lambda.list(colorArray);
		
		view.colorMap = colorMap;
		view.colorArray = colorArray;
		view.colorList = colorList;


	}
	
	@tpl('plugins.twig')
	function doPlugins(){
		
		//send a navbar event to be catch by the plugin
		var navbar = new Array<Link>();
		navbar.push({id:"firstlink",link:"/plugin",name:"First link"});
		var e = Nav(navbar,"demonav");
		app.eventDispatcher.dispatch(e);
		
		//send the navbar to the view
		view.navbar = e.getParameters()[0];
		
	}
	
	@admin
	function doDb(d:Dispatch) {
		d.parts = []; //disable haxe.web.Dispatch
		sys.db.admin.Admin.handler();
	}
	
	/*public function doDemoPlugin(d:haxe.web.Dispatch) {
		d.dispatch(new demoplugin.controller.Main());
	}*/
}
