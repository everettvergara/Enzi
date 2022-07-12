
import ServiceLog from "../../model/TbSysLrLogService";
import DatabaseProvider, { QueryObject } from "../../providers/database";
import ServiceLogDatabaseProvider from "../../providers/database/log/log_service"

export default class ServiceLogController {

   static get_by_log_id(log_id) {
      return ServiceLogDatabaseProvider.get_by_log_id(log_id);
   }

   static get(service_log_id) {
      return ServiceLogDatabaseProvider.get(service_log_id);
   } 

   static insert(log_id, log_type_id, carrier, cellular_generation, strength) {

      let service_log_data = new ServiceLog;
      service_log_data.log_id = log_id;
      service_log_data.type_id = log_type_id;
      service_log_data.carrier = carrier;
      service_log_data.cellular_generation = cellular_generation;
      service_log_data.wifi_strength = strength;

      console.log(service_log_data, "dsklfh")

      ServiceLogDatabaseProvider.insert(service_log_data);
      
      return service_log_data.id;
   }

   static delete(service_log_id) {
      ServiceLogDatabaseProvider.delete(service_log_id);
   }

   static delete_by_log_id(log_id) {
      ServiceLogDatabaseProvider.delete_by_log_id(log_id);
   }
}