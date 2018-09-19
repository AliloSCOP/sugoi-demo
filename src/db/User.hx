package db;
import sys.db.Types;

enum UserType {
	Wizzard;
	Warrior;
	Archer;
}

class User extends sys.db.Object
{
	public var id : SId;
	public var name : SString<64>;
	public var email : SString<128>;
	public var pass : SString<128>;
	public var lang : SString<2>;
	public var ldate : SDateTime; //last connexion
	
	public var type : SEnum<UserType>;	
	public var xp : SInt;
	
	public function new() 
	{
		super();
		reset();
	}
	
	function reset()
	{
		ldate = Date.now();
		xp = 0;
		type = UserType.Archer;
		lang = App.config.LANG; 
	}

	public override function toString() {
		return name;
	}

	public function isAdmin() {
		return id == 1;
	}

	public static function isBanned(){		
		var ip = sugoi.Web.getClientIP();
		var badTries:Int = sugoi.db.Cache.get("ip-ban-"+ip);
		if(badTries==null) return false;
		if(badTries>=5) return true;
		return false;

	}

	public static function recordBadLogin(){
		var ip = sugoi.Web.getClientIP();
		var badTries:Int = sugoi.db.Cache.get("ip-ban-"+ip);
		if(badTries==null) badTries = 0;
		sugoi.db.Cache.set("ip-ban-"+ip,badTries+1, 60 * 10);
	}
	
}