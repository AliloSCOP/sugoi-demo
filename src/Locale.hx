
class Locale
{	
	static public var texts	: sugoi.i18n.GetText;
	
    public static function init(lang:String)
	{
		#if macro
		var file = sys.io.File.getBytes(neko.Web.getCwd()+fileName(lang));
		#else
		App.log("loading "+fileName(lang));
		var file = sys.io.File.getBytes(Sys.programPath()+"/../../"+fileName(lang));
		#end
        texts = new sugoi.i18n.GetText();
		texts.readMo(file);
	}
	
	inline static function fileName(lang:String)
	{
		return "lang/texts_" +lang+ ".mo";
	}
}
