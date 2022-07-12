import ServiceLog from "../../../model/TbSysLrLogService";
import DatabaseProvider, { QueryObject } from "..";

export default class ServiceLogDatabaseProvider {

   static get_all() {
      return DatabaseProvider.get({
         table: ServiceLog.schema.name
      });
   }

   static get_by_log_id(log_id) {
      return DatabaseProvider.instance.retrieve({
         table: ServiceLog.schema.name,
         where: [{
            condition: "log_id == $0",
            value: [log_id]
         }]
      });
   }

   static get(service_log_id) {
      return DatabaseProvider.instance.retrieve({
         table: ServiceLog.schema.name,
         where: [{
            condition: "id == $0",
            value: [service_log_id]
         }]
      })[0];
   }

   static insert(record) {
      DatabaseProvider.execute([{
         table: ServiceLog,
         record: record,
         mode: "create"
      }]);
   }

   static delete(service_log_id) {
      let query_object = new QueryObject;
      let service_log = ServiceLogDatabaseProvider.get(service_log_id);
      query_object.delete(service_log);
      DatabaseProvider.instance.save_to_db(query_object);
   }

   static delete_by_log_id(log_id) {
      let query_object = new QueryObject;
      let service_logs = ServiceLogDatabaseProvider.get_by_log_id(log_id);
      service_logs.forEach(service_log => {
         query_object.delete(service_log);
      });
      DatabaseProvider.instance.save_to_db(query_object);
   }

   static delete_all() {
      let query_object = new QueryObject;
      let service_logs = ServiceLogDatabaseProvider.get_all();
      service_logs.forEach(service_log => {
         query_object.delete(service_log);
      });
      DatabaseProvider.instance.save_to_db();
   }
}