package ;
import haxe.Log;

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
		Locale.init(config.LANG);//TODO  use session instead
		log(Locale.texts._("Hello there"));
	}
	
	public static function main() {
		
		#if i18n_parsing
		if( false ) sugoi.i18n.GetText.parse(".", "lang/allTexts.pot");
		#end
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