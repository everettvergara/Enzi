
import DatabaseProvider from "..";
import User from "../../../model/TbSysMfUser";

export default class UserDatabaseProvider {
   
   static get_by_user_code(user_code) {
      return DatabaseProvider.get({
         table: User.schema.name,
         where: [
            {
               condition: "code == $0",
               value: [user_code]
            }
         ],
         limit: 1
      })[0];
   }

   static get_logged_in_user() {
      return DatabaseProvider.get({
         table: User.schema.name,
         where: [
            {
               condition: "is_logged_in == $0",
               value: [true]
            }
         ],
         limit: 1
      })[0];
   }
   
   static insert(record) {
      DatabaseProvider.execute([{
         table: User,
         record: record,
         mode: "create"
      }]);
   }

   static update_log_in(user_code, is_logged_in, token) {
      let current_user = UserDatabaseProvider.get_by_user_code(user_code);
      DatabaseProvider.execute([{
         table: User,
         record: { id: current_user.id, is_logged_in: is_logged_in, api_token: is_logged_in ? token: "" },
         mode: "update"
      }]);
   }
}