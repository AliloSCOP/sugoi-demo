package demoplugin.controller;

/**
 * Demo plugin main controller
 * @author fbarbut
 */
class Main extends sugoi.BaseController
{
	
	@tpl('../../../plugins/demoplugin/lang/master/tpl/default.mtt')
	public function doDefault(){
		
		var t = sugoi.i18n.Locale.texts;		
		view.msg =  t._("This is a translatable message from the demo plugin controller !");
	}
	
}