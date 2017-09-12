package ;

import sugoi.Web;

class App extends sugoi.BaseApp
{
	public static var current : App = null;
	public static var config = sugoi.BaseApp.config;
	
	public static function main() {
		sugoi.BaseApp.main();
	}
	
	public static function log(t:Dynamic) {
		if (config.DEBUG) {
			#if neko
			Web.logMessage(Std.string(t));
			#end
		}
	}
}