

export default class DeviceLog {

   static schema = {
      name: "tb_sys_lr_log",
      properties: {
        id: "int",
        log_time: { type: "int", indexed: true },
        is_uploaded: { type: "bool", default: false },
        trigger_type_id: "int"
      },
      primaryKey: "id"
   };

   id = null;
   log_time = null;
   is_uploaded = false;
   trigger_type_id = null;
}