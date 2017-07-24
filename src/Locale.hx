
class Locale
{	
	static public var texts	: sugoi.i18n.GetText;
	
    public static function init(lang:String)
	{
		var file = sys.io.File.getBytes(Sys.programPath()+"/../../"+fileName(lang));
        texts = new sugoi.i18n.GetText();
		texts.readMo(file);
	}
	
	inline static function fileName(lang:String)
	{
		return "lang/texts_" +lang+ ".mo";
	}
}
