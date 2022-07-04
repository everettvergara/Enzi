import GPSLog from "../../../model/TbSysLrLogGPS";
import DatabaseProvider, { QueryObject } from "..";

export default class GPSLogDatabaseProvider {

   static get_all() {
      return DatabaseProvider.get({
         table: GPSLog.schema.name
      });
   }

   static get_by_log_id(log_id) {
      return DatabaseProvider.instance.retrieve({
         table: GPSLog.schema.name,
         where: [{
            condition: "log_id == $0",
            value: [log_id]
         }]
      });
   }

   static get(gps_log_id) {

      let logs = DatabaseProvider.instance.retrieve({ 
         table: GPSLog.schema.name, 
         where: [
            { 
               condition: "id == $0", 
               value: [gps_log_id] 
            },
         ]
      });

      return logs[0];
   }

   static insert(record) {
      let query_object = new QueryObject;
      query_object.create(GPSLog.schema.name, record);
      DatabaseProvider.instance.save_to_db(query_object);
   }

   static update_address(gps_log_id, address) {
      let query_object = new QueryObject;
      let gps_log = GPSLogDatabaseProvider.get(gps_log_id)
      query_object.update(gps_log, "address", address);
      DatabaseProvider.instance.save_to_db(query_object);
   }

   static delete(gps_log_id) {
      let query_object = new QueryObject;
      let gps_log = GPSLogDatabaseProvider.get(gps_log_id)
      query_object.delete(gps_log);
      DatabaseProvider.instance.save_to_db(query_object);
   }

   static delete_by_log_id(log_id) {
      let query_object = new QueryObject;
      let gps_logs = GPSLogDatabaseProvider.get_by_log_id(log_id);
      gps_logs.forEach(gps_log => {
         query_object.delete(gps_log);
      });
      DatabaseProvider.instance.save_to_db(query_object);
   }

   static delete_all() {
      let query_object = new QueryObject;
      let gps_logs = GPSLogDatabaseProvider.get_all();
      gps_logs.forEach(gps_log => {
         query_object.delete(gps_log);
      });
      DatabaseProvider.instance.save_to_db();
   }
}