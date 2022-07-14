
import LogDatabaseProvider from "../providers/database/log/log";
import BatteryLogDatabaseProvider from "../providers/database/log/log_battery";
import ServiceLogDatabaseProvider from "../providers/database/log/log_service";
import GPSLogDatabaseProvider from "../providers/database/log/log_gps";
import Config from "../config/config";

export default class SyncController {

   static async sync_sys_logs(token) {

      let logs = LogDatabaseProvider.get_not_uploaded();

      logs = logs.map((log) => {
         log.battery_logs = BatteryLogDatabaseProvider.get_by_log_id(log.id);
         log.service_logs = ServiceLogDatabaseProvider.get_by_log_id(log.id);
         log.gps_logs = GPSLogDatabaseProvider.get_by_log_id(log.id);
         return log;
      });

      let params = {
         data: logs
      };

      return await fetch(Config.SERVER_URL + "/mobile_services/sync_syslogs", {
         method: 'POST',
         headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + token
         },
         body: JSON.stringify(params)
      })
      .then((response) => response.text())
   }
}