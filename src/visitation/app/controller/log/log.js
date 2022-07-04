
import Helper from "../../helpers/helper";
import DeviceLog from "../../model/TbSysLrLog";
import LogDatabaseProvider from "../../providers/database/log/log";
import BatteryLogDatabaseProvider from "../../providers/database/log/log_battery";
import ServiceLogDatabaseProvider from "../../providers/database/log/log_service";
import GPSLogDatabaseProvider from "../../providers/database/log/log_gps";

export default class DeviceLogController {

   static get_by_date_range(date_from, date_to, n) {
      let logs = LogDatabaseProvider.get_by_date_range(date_from, date_to, n);
      return logs;
   }

   static get_logs(date_from, date_to) {

      let logs = LogDatabaseProvider.get_by_date_range(date_from, date_to, 10);

      logs = logs.map((log) => {
         log.battery_log = BatteryLogDatabaseProvider.get_by_log_id(log.id);
         if (log.battery_log.length > 0) {
            log.battery_log = log.battery_log[0];
         }
         log.service_logs = ServiceLogDatabaseProvider.get_by_log_id(log.id);
         log.gps_log = GPSLogDatabaseProvider.get_by_log_id(log.id);
         if (log.gps_log.length > 0) {
            log.gps_log = log.gps_log[0];
         }
         return log;
       })

      return logs;
   } 

   static get(log_id) {
      return LogDatabaseProvider.get(log_id);
   } 

   static insert(trigger_type_id) {

      let log_data = new DeviceLog;
      log_data.log_time = Helper.get_timestamp();
      log_data.is_uploaded = false;
      log_data.trigger_type_id = trigger_type_id;
      LogDatabaseProvider.insert(log_data);

      return log_data.id;
   }

   static update_uploaded(log_id, is_uploaded) {
      LogDatabaseProvider.update_uploaded(log_id, is_uploaded)
   }

   static delete(log_id) {
      LogDatabaseProvider.delete(log_id);
   }

   static delete_all() {
      BatteryLogDatabaseProvider.delete_all();
      GPSLogDatabaseProvider.delete_all();
      ServiceLogDatabaseProvider.delete_all();
      LogDatabaseProvider.delete_all();
   }
}