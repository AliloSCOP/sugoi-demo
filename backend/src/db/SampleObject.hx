package db;
import sys.db.Object;
import sys.db.Types;

/**
 * SPOD Object for testing forms
 * @author fbarbut
 */
class SampleObject extends Object
{
	public var id:SId;
	public var name:SString<32>;
	public var xp : SInt;
	
}