package controller;

/**
 * User Controller
 * @author fbarbut<francois.barbut@gmail.com>
 */
class User extends sugoi.BaseController
{

	public function new() {
		super();
		view.section = "users";
	}
	
	@tpl('user/default.mtt')
	public function doDefault() {
		
		view.users = db.User.manager.all();
		
	}
	
	
	
	public function doDelete(user:db.User) {
		if (user.isAdmin()) throw Error('/user', 'Can\'t delete an admin user');
		user.lock();
		user.delete();
		throw Ok('/user', 'User deleted');
	}
	
	@tpl('form.mtt')
	public function doEdit(user:db.User) {
		
		var form = sugoi.form.Form.fromSpod(user);
		form.getElement('pass').value = "";
		
		if (form.isValid()) {
			user.lock();
			form.toSpod(user);
			user.pass = haxe.crypto.Md5.encode(App.config.KEY + user.pass);
			user.update();
			throw Ok('/user','User edited successfully');
		}
		
		view.form = form;
		view.title = "Edit " + user.name;
		
	}
	
	
	@tpl('form.mtt')
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
	
	@tpl('user/login.mtt')
	public function doLogin() {
		
		//already logged
		if (App.current.user != null) throw Redirect('/');
		
		//generate a form
		var form = sugoi.form.Form.fromObject( { email:"",pass:"" } );
		
		if (form.isValid()) {
			var pass = haxe.crypto.Md5.encode( App.config.KEY + StringTools.trim(form.getValueOf('pass')) );
			var email = StringTools.trim(form.getValueOf('email'));
			var user = db.User.manager.select( $email == email && $pass == pass);
			if (user == null) {
				throw Error("/user/login", "Invalid email or password");	
			}
			
			//update last login date
			user.ldate = Date.now();
			user.update();
			App.current.session.setUser(user);
			
			throw Ok("/", "Hello " + user.name+" !");
		}
		
		view.form = form;
	}
	
}