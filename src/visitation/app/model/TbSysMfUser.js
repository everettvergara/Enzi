
export default class User {

   static schema = {
      name: "tb_sys_mf_user",
      properties: {
         id: { type: "int", default: 0 },
         erp_id: "int?",
         code: "string?",
         first_name: "string?",
         last_name: "string?",
         email: "string?",
         is_active: "bool?",
         api_token: "string?",
         is_logged_in: "bool?"
      },
      primaryKey: "id"
   };

   constructor({
      erp_id, code, first_name, last_name, email, is_active, api_token
   }) {
      this.erp_id = erp_id;
      this.code = code;
      this.first_name = first_name;
      this.last_name = last_name;
      this.email = email;
      this.is_active = is_active;
      this.api_token = api_token;
      this.is_logged_in = true;
   }

   id = 0;
   erp_id = null;
   code = null;
   first_name = null;
   last_name = null;
   email = null;
   is_active = false;
   api_token = null;
   is_logged_in = false;
}