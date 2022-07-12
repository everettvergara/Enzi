
import Realm from "realm";

import DeviceLog from "../../model/TbSysLrLog";
import GPSLog from "../../model/TbSysLrLogGPS";
import BatteryLog from "../../model/TbSysLrLogBattery";
import ServiceLog from "../../model/TbSysLrLogService";
import Config from "../../config/config";
import User from "../../model/TbSysMfUser";

export default class DatabaseProvider {

  static realm = null;

  static _instance = null;

  static get instance() {
    if (DatabaseProvider._instance == null) DatabaseProvider._instance = new DatabaseProvider();
    return DatabaseProvider._instance;
  }

  async load_database() {

    const table_pk_ids = {
      name: "table_pk_ids",
      properties: {
        id: "int",
        table_name: "string",
        max_id: { type: "int", default: 0 }
      },
      primaryKey: "id"
    };

    let classes = [
      DeviceLog,
      GPSLog,
      BatteryLog,
      ServiceLog,
      User
    ];

    let schemata = classes.map((c) => c.schema);
    schemata.push(table_pk_ids);
  
    // add schema to database
    DatabaseProvider.realm = await Realm.open({
      path: Config.DATABASE,
      schema: schemata,
      schemaVersion: 20
    });

    if (DatabaseProvider.realm.objects("table_pk_ids").length == 0)
      DatabaseProvider.realm.write(() => {
        for (let i = 0; i < classes.length; i++) {
          const record = {
            id: i + 1,
            table_name: classes[i].schema.name,
            max_id: 0
          };
          DatabaseProvider.realm.create("table_pk_ids", record);
        }
      });
  }

  static process_query(query) {

    let table = query.table, record = query.record, mode = query.mode;

    let relationships = table.relationships ? table.relationships: [];

    const process_rel = () => {
      for (let i = 0; i < relationships.length; ++i) {
        const relationship_table = table.schema.properties[relationships[i]].replace("[]", "");
        let related_table_pk_id = DatabaseProvider.get_last_id(relationship_table);

        let related_records = record[relationships[i]] ? record[relationships[i]]: [];

        for (let j = 0; j < related_records.length; ++j) {
          if (!related_records[j].id) {
            related_records[j].id = ++related_table_pk_id.max_id;
          }
        }
      }
    }

    if (mode == "create")  {
      let last_id = DatabaseProvider.get_last_id(table.schema.name);
      record.id = ++last_id.max_id;
      process_rel(); 
    }
    else if (mode == "update") {
      process_rel(); 
    }

    let active_record = DatabaseProvider.realm.create(table.schema.name, record, "all");

    if (mode == "delete") {
      DatabaseProvider.realm.delete(active_record);
      active_record = null;
    } 
  }

  static execute(queries) {
    DatabaseProvider.realm.write(() => {
      try {
        queries.forEach((query) => {
          DatabaseProvider.process_query(query);
        });
      } 
      catch (error) {
        console.log("error: ", error)
      }
    })
  }

  static get_last_id(table) {
    let last_id = DatabaseProvider.realm.objects("table_pk_ids").filtered("table_name == $0", table)[0];
    return last_id;
  }

  static get({ table, where, limit, sort }) {
    let object = DatabaseProvider.realm.objects(table);
    if (where)
      where.forEach((w) => {
        object = object.filtered(w.condition, ...w.value);
      })
    if (sort)
      object = object.sorted(sort.field, sort.sorted);
    if (limit)
      object = object.filtered("id == id limit(" + limit + ")");
    
    return object;
  }
}