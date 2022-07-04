export default class BatteryLog {

   static schema = {
      name: "tb_sys_lr_log_battery",
      properties: {
        log_id: { type: "int", indexed: true },
        id: "int",
        battery_level: "float"
      },
      primaryKey: "id"
   };

   log_id = null;
   id = null;
   battery_level = null;
}