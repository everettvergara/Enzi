
export default class GPSLog {
   static schema = {
      name: "tb_sys_lr_log_gps",
      properties: {
        log_id: { type: "int", indexed: true },
        id: "int",
        lat: "double",
        lng: "double",
        address: "string?"
      },
      primaryKey: "id"
   };

   log_id = null;
   id = null;
   lat = null;
   lng = null;
   address = null;
}