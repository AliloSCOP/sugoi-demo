package ;
import i18n.Locale;
import i18n.Translater;
import i18n.GetText;

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
		#if (i18n_generation)
		if( false ) Translater.parse("lang/master");
		#end

		Locale.init(config.LANG);//TODO  use session instead
		log(Locale.texts._("Hello there, text from hx file"));
	}
	
	public static function main() {
		
		#if i18n_parsing
		if( false ) GetText.parse(["src", "lang/master"], "lang/allTexts.pot");
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