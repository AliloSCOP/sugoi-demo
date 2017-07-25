package ;

class View extends sugoi.BaseView
{

	public function new() 
	{
		super();
	}
	
	public function _(literal:String) 
	{
		return Locale.texts.get(literal);
	}
}