package db;
import sys.db.Types;

class User extends sys.db.Object
{

	public var id : SId;
	public var name : SString<64>;
	public var email : SString<128>;
	public var pass : SString<128>;
	public var lang : SString<2>;
	public var ldate : SDateTime; //last connexion
	public function new() 
	{
		super();
	}
	
	public override function toString() {
		return name;
	}

	public function isAdmin() {
		return id==1;
	}
	
}