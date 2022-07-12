import GPSLog from "../../../model/TbSysLrLogGPS";
import DatabaseProvider, { QueryObject } from "..";

export default class GPSLogDatabaseProvider {

   static get_all() {
      return DatabaseProvider.get({
         table: GPSLog.schema.name
      });
   }

   static get_by_log_id(log_id) {
      return DatabaseProvider.get({
         table: GPSLog.schema.name,
         where: [{
            condition: "log_id == $0",
            value: [log_id]
         }]
      });
   }

   static get(gps_log_id) {

      let logs = DatabaseProvider.get({ 
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
      DatabaseProvider.execute([{
         table: GPSLog,
         record: record,
         mode: "create"
      }]);
   }

   static update_address(id, address) {
      DatabaseProvider.execute([{
         table: GPSLog,
         record: { id: id, address: address },
         mode: "update"
      }]);
   }

   static delete(id) {
      DatabaseProvider.execute([{
         table: GPSLog,
         record: { id: id },
         mode: "delete"
      }]);
   }

   static delete_by_log_id(log_id) {
      let query_objects = [];

      let gps_logs = GPSLogDatabaseProvider.get_by_log_id(log_id);
      gps_logs.forEach(gps_log => {
         query_objects.push({
            table: GPSLog,
            record: { id: gps_log.id },
            mode: "delete"
         });
      });
      DatabaseProvider.execute(query_objects);
   }

   static delete_all() {
      let query_objects = [];

      let gps_logs = GPSLogDatabaseProvider.get_all();
      gps_logs.forEach(gps_log => {
         query_objects.push({
            table: GPSLog,
            record: { id: gps_log.id },
            mode: "delete"
         });
      });
      DatabaseProvider.execute(query_objects);
   }
}