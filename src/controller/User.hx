package controller;

/**
 * User Controller
 * @author fbarbut<francois.barbut@gmail.com>
 */
class User extends sugoi.BaseController
{
	var t: sugoi.i18n.GetText;

	public function new() {
		super();
		view.section = "users";
		t = sugoi.i18n.Locale.texts;
	}
	
	@tpl('user/default.twig')
	public function doDefault() {
		view.users = db.User.manager.all();
	}
	
	public function doDelete(user:db.User) {
		if (user.isAdmin()) throw Error('/user', 'Can\'t delete an admin user');
		user.lock();
		user.delete();
		throw Ok('/user', 'User deleted');
	}
	
	@tpl('form.twig')
	public function doEdit(user:db.User) {
		
		var form = sugoi.form.Form.fromSpod(user);
		form.removeElementByName('pass');
		form.removeElementByName('ldate');
		
		if (form.isValid()) {
			user.lock();
			form.toSpod(user);
			user.update();
			throw Ok('/user','User edited successfully');
		}
		
		view.form = form;
		view.title = "Edit " + user.name;
	}
	
	@tpl('form.twig')
	public function doInsert() {
		var user = new db.User();
		var form = sugoi.form.Form.fromSpod(user);
		
		if (form.isValid()) {
			form.toSpod(user);
			user.pass = haxe.crypto.Md5.encode(App.config.KEY + user.pass);
			user.insert();
			throw Ok('/user','User inserted successfully');
		}
		
		view.form = form;
		view.title = "Insert a user";
	}
	
	@tpl('user/login.twig')
	public function doLogin() {

		//Already logged ?
		if (App.current.user != null) throw Ok('/','You already signed in');
		
		//Generate a form
		var form = sugoi.form.Form.fromObject( { email:"",pass:"" } );
		
		if (form.isValid()) {

			//IP Banned ?
			if(db.User.isBanned()) throw Error("/user/login",t._("Since you failed to login more than 4 times, your IP address has been banned for 10 minutes."));		

			var pass = haxe.crypto.Md5.encode( App.config.KEY + StringTools.trim(form.getValueOf('pass')) );
			var email = StringTools.trim(form.getValueOf('email'));
			var user = db.User.manager.select( $email == email && $pass == pass);
			if (user == null) {
				db.User.recordBadLogin();
				sys.db.Manager.cnx.commit();
				throw Error("/user/login", t._("Invalid email or password") );	
			}else{
				//update last login date
				user.ldate = Date.now();
				user.update();
				App.current.session.setUser(user);
				
				throw Ok("/", "Hello " + user.name+" !");
			}
			
			
		}
		
		view.form = form;
	}
}