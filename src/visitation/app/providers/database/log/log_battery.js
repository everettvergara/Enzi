import BatteryLog from "../../../model/TbSysLrLogBattery";
import DatabaseProvider, { QueryObject } from "..";

export default class BatteryLogDatabaseProvider {

   static get_all() {
      return DatabaseProvider.get({
         table: BatteryLog.schema.name
      });
   }

   static get_by_log_id(log_id) {
      return DatabaseProvider.instance.retrieve({
         table: BatteryLog.schema.name,
         where: [{
            condition: "log_id == $0",
            value: [log_id]
         }]
      });
   }

   static get(battery_log_id) {

      let logs = DatabaseProvider.instance.retrieve({ 
         table: BatteryLog.schema.name, 
         where: [
            { 
               condition: "id == $0", 
               value: [battery_log_id] 
            },
         ]
      });

      return logs[0];
   }

   static insert(record) {
      let query_object = new QueryObject;
      query_object.create(BatteryLog.schema.name, record);
      DatabaseProvider.instance.save_to_db(query_object);
   }

   static delete(battery_log_id) {
      let query_object = new QueryObject;
      let battery_log = BatteryLogDatabaseProvider.get(battery_log_id);
      query_object.delete(battery_log);
      DatabaseProvider.instance.save_to_db(query_object);
   }

   static delete_by_log_id(log_id) {
      let query_object = new QueryObject;
      let battery_logs = BatteryLogDatabaseProvider.get_by_log_id(log_id);
      battery_logs.forEach(battery_log => {
         query_object.delete(battery_log);
      });
      DatabaseProvider.instance.save_to_db(query_object);
   }

   static delete_all() {
      let query_object = new QueryObject;
      let gps_logs = BatteryLogDatabaseProvider.get_all();
      gps_logs.forEach(gps_log => {
         query_object.delete(gps_log);
      });
      DatabaseProvider.instance.save_to_db();
   }
}