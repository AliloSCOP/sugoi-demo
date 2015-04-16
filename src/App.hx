package ;

#if neko
import neko.Web;
#else
import php.Web;
#end

class App extends sugoi.BaseApp
{
	public static var current : App = null;
	public static var config = sugoi.BaseApp.config;
	
	public function new() 
	{
		super();
	}
	
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