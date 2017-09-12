package ;
import sugoi.i18n.Locale;
import Common;
import sugoi.i18n.GetText;
import sugoi.Web;

class App extends sugoi.BaseApp
{
	public static var current : App = null;
	public static var config = sugoi.BaseApp.config;
	
	//plugin mgmt
	public var eventDispatcher :hxevents.Dispatcher<Event>;	
	public var plugins : Array<sugoi.plugin.IPlugIn>;
	
	public static function main() {
		
		sugoi.BaseApp.main();
	}
	
	/**
	 * Init plugins and event dispatcher just before launching the app
	 */
	override public function mainLoop() {
		eventDispatcher = new hxevents.Dispatcher<Event>();
		plugins = [];
	
		//init plugins
		plugins.push(new demoplugin.DemoPlugin());
	
		super.mainLoop();
	}
	
	public static function log(t:Dynamic) {
		if (config.DEBUG) {
			#if neko
			Web.logMessage(Std.string(t));
			#end
		}
	}
}