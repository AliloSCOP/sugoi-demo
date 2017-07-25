package;
import haxe.macro.Expr;
import haxe.macro.Context;

class Translater
{
    macro public static function parse(path:ExprOf<String>)
    {
		Sys.println("[Translater] Parsing templates...");
        var langs = new sugoi.Config(neko.Web.getCwd()).LANGS;
        Sys.println(langs);

        for( lang in langs ) {
			Sys.println("we translate the templates for language : "+lang);
			Locale.init(lang);
			translateTemplates(lang, "lang/master");
		}

		Sys.println("[Translater] Done.");
		return macro {}
	}

    #if macro
    static public function translateTemplates(lang:String, folder:String)
    {
        Sys.println("translateTemplates");
		//var strReg = ~/_\([ ]*"((\\"|[^"])+)"/ig;
        var strReg = ~/(::_\("([^"]*)"\)::)+/ig;

		for( f in sys.FileSystem.readDirectory(folder) ) {
			// Parse sub folders
			if(sys.FileSystem.isDirectory(folder+"/"+f) ) {
                //create target directory
                var langPath = StringTools.replace(folder+"/"+f, "master", lang);
                sys.FileSystem.createDirectory(langPath);

				translateTemplates(lang, folder+"/"+f);
				continue;
			}
			
			// Ignore non-sourcecode
			var isTemplateFile = f.substr(f.length - 4) == ".mtt";
			
			if( !isTemplateFile )
				continue;
            Sys.println("We are going to check the file "+f);

            //copy the file to the correct new folder
            var filePath = StringTools.replace(folder+"/"+f, "master", lang);
           // if(sys.FileSystem.exists(filePath))
           //     sys.FileSystem.deleteFile(filePath);
           
            var langFile = sys.io.File.write(filePath, false);
			// Read lines
			var c = sys.io.File.getContent(folder+"/"+f);
        

           // var c = sys.io.File.getContent(filePath);
			//on peut peut etre passer tout le fichier direct
            var out = strReg.map(c, function(e) {
                var str = e.matched(2);
                Sys.println("str matched:"+str);
                // Ignore commented strings
                var i = str.indexOf("//");
                if( i >= 0 && i < strReg.matchedPos().pos )
                    return "";
                
                var cleanedStr = str;
                // Translator comment
                var comment : String = null;
                if( cleanedStr.indexOf("||") >= 0 ) {
                    var parts = cleanedStr.split("||");
                    if( parts.length!=2 ) {
                        throw "Malformed translator comment";
                        return "";
                    }
                    comment = StringTools.trim(parts[1]);
                    cleanedStr = cleanedStr.substr(0,cleanedStr.indexOf("||"));
                    cleanedStr = StringTools.rtrim(cleanedStr);
                }

                Sys.println(cleanedStr+' is translated to : '+Locale.texts.get(cleanedStr));
    
                return Locale.texts.get(cleanedStr);
            });

            langFile.writeString(out);
            langFile.flush();
            langFile.close();
		}
    }
    #end
}