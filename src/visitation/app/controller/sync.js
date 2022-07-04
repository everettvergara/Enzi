import DatabaseProvider, { QueryObject } from "../providers/database";

import BatteryLogController from "./log/log_battery";
import ServiceLogController from "./log/log_service";
import GPSLogController from "./log/log_gps";
import LogDatabaseProvider from "../providers/database/log/log";
import BatteryLogDatabaseProvider from "../providers/database/log/log_battery";
import ServiceLogDatabaseProvider from "../providers/database/log/log_service";
import GPSLogDatabaseProvider from "../providers/database/log/log_gps";

export default class SyncController {

   static upload_sys_logs() {

      let logs = LogDatabaseProvider.get_not_uploaded();

      logs = logs.map((log) => {
         log.battery_logs = BatteryLogDatabaseProvider.get_by_log_id(log.id);
         log.service_logs = ServiceLogDatabaseProvider.get_by_log_id(log.id);
         log.gps_logs = GPSLogDatabaseProvider.get_by_log_id(log.id);
         return log;
      });

      return fetch('https://enzi.com/api/v1/insert_logs', {
         method: 'POST',
         headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json'
         },
         body: JSON.stringify(logs)
      });
   }
}