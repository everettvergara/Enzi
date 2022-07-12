
import DatabaseProvider from "../providers/database";

export default class MainController {

   static load_database() {
      DatabaseProvider.instance.load_database();
   }
}