import DeviceLog from "../../../model/TbSysLrLog";
import DatabaseProvider, { QueryObject } from "..";

export default class LogDatabaseProvider {

   static get_all() {
      return DatabaseProvider.get({
         table: DeviceLog.schema.name
      });
   }

   static get_by_date_later_sorted_asc(date, n) {

      return DatabaseProvider.get({
         table: DeviceLog.schema.name,
         where: [
            { 
               condition: "log_time >= $0", 
               value: [date] 
            },
         ],
         limit: n,
         sort: { 
            field: "log_time",
            sorted: false
         }
      });
   }

   static get_by_date_range(date_from, date_to, n) {

      return DatabaseProvider.get({
         table: DeviceLog.schema.name,
         // where: [
         //    { 
         //       condition: "log_time between $0 and $1", 
         //       value: [date_from, date_to] 
         //    },
         // ],
         limit: n,
         sort: { 
            field: "log_time",
            sorted: true
         }
      });
   }

   static get_by_date_range_sorted_asc(date_from, date_to, n) {
      return DatabaseProvider.get({
         table: DeviceLog.schema.name,
         where: [
            { 
               condition: "log_time >= $0 and log_time <= $1", 
               value: [date_from, date_to] 
            },
         ],
         limit: n,
         sort: { 
            field: "log_time",
            sorted: false
         }
      });
   }

   static get_not_uploaded() {

      return DatabaseProvider.get({
         table: DeviceLog.schema.name,
         where: [
            { 
               condition: "is_uploaded == $0", 
               value: [false] 
            },
         ]
      });
   }

   static get(log_id) {

      let logs = DatabaseProvider.instance.retrieve({ 
         table: DeviceLog.schema.name, 
         where: [
            { 
               condition: "id == $0", 
               value: [log_id] 
            },
         ]
      });

      return logs[0];
   }

   static insert(record) {
      DatabaseProvider.execute([{
         table: DeviceLog,
         record: record,
         mode: "create"
      }]);
   }

   static update_uploaded(log_id, is_uploaded) {
      let query_object = new QueryObject;
      let log = LogDatabaseProvider.get(log_id);
      query_object.update(log, "is_uploaded", is_uploaded);
      DatabaseProvider.instance.save_to_db(query_object);
   }

   static delete(log_id) {
      let query_object = new QueryObject;
      let log = LogDatabaseProvider.get(log_id);
      query_object.delete(log);
      DatabaseProvider.instance.save_to_db(query_object);
   }

   static delete_all() {
      let query_object = new QueryObject;
      let logs = LogDatabaseProvider.get_all();
      logs.forEach(log => {
         query_object.delete(log);
      });
      DatabaseProvider.instance.save_to_db();
   }
}