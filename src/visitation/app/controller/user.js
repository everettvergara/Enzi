import Config from "../config/config";
import User from "../model/TbSysMfUser";
import UserDatabaseProvider from "../providers/database/user/user";

export default class UserController {

   static async login(user_code, password) {

      var form_data = new FormData();
      form_data.append("user_code", user_code);
      form_data.append("password", password);

      let response = await fetch(Config.SERVER_URL + "/login", {
      //let response = await fetch("http://192.168.0.105:8888/trilanz/create_token.php", {
         method: 'POST',
         headers: {
            'Accept': 'application/json',
            'Content-Type': 'multipart/form-data'
         },
         body: form_data
      });

      return await response.json();
      //return await response.text();
   }

   static insert_current_user(current_user) {
      current_user = new User(current_user);
      current_user.is_logged_in = true;
      UserDatabaseProvider.insert(current_user);
   }

   static update_log_in(user_code, is_logged_in, token) {
      UserDatabaseProvider.update_log_in(user_code, is_logged_in, token);
   }

   static get_logged_in_user() {
      let current_user = UserDatabaseProvider.get_logged_in_user();
      return current_user;
   }

   static get_by_user_code(user_code) {
      let user = UserDatabaseProvider.get_by_user_code(user_code);
      return user;
   }
}