
import DatabaseProvider, { QueryObject } from "../../providers/database";
import { getBatteryLevel } from "react-native-device-info";
import BatteryLog from "../../model/TbSysLrLogBattery";
import BatteryLogDatabaseProvider from "../../providers/database/log/log_battery";

export default class BatteryLogController {

   static get_by_log_id(log_id) {
      return BatteryLogDatabaseProvider.get_by_log_id(log_id);
   }

   static get(battery_log_id) {
      return BatteryLogDatabaseProvider.get(battery_log_id);
   } 

   static async insert(log_id) {

      const battery_level = await getBatteryLevel();

      let battery_log_data = new BatteryLog;
      battery_log_data.log_id = log_id;
      battery_log_data.battery_level = parseInt((battery_level * 100).toFixed(2));
      BatteryLogDatabaseProvider.insert(battery_log_data);
      return battery_log_data.id;
   }

   static delete(battery_id) {
      BatteryLogDatabaseProvider.delete(battery_id);
   }

   static delete_by_log_id(log_id) {
      BatteryLogDatabaseProvider.delete_by_log_id(log_id);
   }
}