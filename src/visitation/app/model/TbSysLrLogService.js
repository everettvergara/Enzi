

export default class ServiceLog {

   static schema = {
      name: "tb_sys_lr_log_service",
      properties: {
        log_id: { type: "int", indexed: true },
        id: "int",
        type_id: "int",
        cellular_generation: "string?",
        carrier: "string?",
        wifi_strength: "float?"
      },
      primaryKey: "id"
   };

   log_id = null;
   id = null;
   type_id = null;
   cellular_generation = null;
   carrier = null;
   wifi_strength = null;
}