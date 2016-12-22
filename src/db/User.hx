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
	}
	
	public override function toString() {
		return name;
	}

	public function isAdmin() {
		return id==1;
	}
	
}