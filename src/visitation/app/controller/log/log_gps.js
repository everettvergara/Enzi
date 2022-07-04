
import GPSLog from "../../model/TbSysLrLogGPS";
import DatabaseProvider, { QueryObject } from "../../providers/database";
import GPSLogDatabaseProvider from "../../providers/database/log/log_gps";

export default class GPSLogController {

   static get_by_log_id(log_id) {
      return GPSLogDatabaseProvider.get_by_log_id(log_id);
   }

   static get(gps_log_id) {
      return GPSLogDatabaseProvider.get(gps_log_id);
   } 

   static insert(log_id, lat, lng) {
      let gps_log_data = new GPSLog;
      gps_log_data.log_id = log_id;
      gps_log_data.lat = lat;
      gps_log_data.lng = lng;
      GPSLogDatabaseProvider.insert(gps_log_data);
      return gps_log_data.id;
   }

   static update_address(gps_id, address) {
      GPSLogDatabaseProvider.update_address(gps_id, address);
   }

   static delete(gps_id) {
      GPSLogDatabaseProvider.delete(gps_id);
   }
  
   static delete_by_log_id(log_id) {
      GPSLogDatabaseProvider.delete_by_log_id(log_id);
   }
}