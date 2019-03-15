/**
	Here are defined common data structures for the whole project.
	This code is compiled on the server side (php or neko) and client side (javascript or flash)
**/
	
/**
 * Events that plugins may catch
 */
enum Event {
	Nav(nav:Array<Link>,id:String);	//a navigation is displayed
}

/**
 * Links in navbars for plugins
 */
typedef Link = {
	id:String,
	link:String,
	name:String,
	?icon:String,
}