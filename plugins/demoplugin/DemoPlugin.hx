package demoplugin;
import Common;
import sugoi.plugin.*;

class DemoPlugin extends PlugIn implements IPlugIn{
	

	public function new() {
		super();
		name = "Demo plugin";
		file = sugoi.tools.Macros.getFilePath();
		//suscribe to events
		App.current.eventDispatcher.add(onEvent);
		
	}
	
	public function onEvent(e:Event) {
		
		switch(e) {

			case Nav(nav,id) :
				
				switch(id) {
					case "demonav":
						nav.push({id:"demolink",name:"Demo plugin link", link:"/demoPlugin",icon:"star"});
				}
			
			
			default :
		}
	}
	

	public function getName() {
		return name;
		
	}
	
	public function getController() {
		return null;
	}
	
	public function isInstalled():Bool {
		
		var a = sys.FileSystem.exists(App.config.PATH + "/www/plugin/" + name);
		var b = sys.FileSystem.exists(App.config.PATH + "/lang/master/tpl/plugin/" + name);
		
		return a && b;
		
	}
	
	
	
	public function install() {
		
		//simlink de hosted/www dans www/plugin/hosted/
		//simlink de tpl/hosted dans fr/tpl/plugin/hosted ( pour que templo puisse compiler )

		
		var pluginDir = file.split("/");
		pluginDir.pop();
		var pluginDir = pluginDir.join("/");
		
		
		//trace("de "+pluginDir+"/www/");
		//trace("vers "+App.config.PATH + "/www/plugin/" + name);
		
		//web root for the plugin
		createSimLink(App.config.PATH + "/www/plugin/" + name, pluginDir + "/www/");
		
		//templates
		createSimLink(App.config.PATH + "/lang/fr/tpl/plugin/" + name, pluginDir + "/lang/fr/tpl/" + name);
		
		
		
	}
	
	
}