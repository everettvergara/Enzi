
import Realm from "realm";

import DeviceLog from "../../model/TbSysLrLog";
import GPSLog from "../../model/TbSysLrLogGPS";
import BatteryLog from "../../model/TbSysLrLogBattery";
import ServiceLog from "../../model/TbSysLrLogService";

export class QueryObject {

  queries = [];

  create(table, record) {
    this.queries.push({
      type: "create",
      table: table,
      record: record
    })
  }

  update(object, property, value) {
    this.queries.push({
      type: "update",
      object: object,
      property: property,
      value: value
    })
  }

  delete(object) {
    this.queries.push({
      type: "delete",
      object: object
    })
  }
}

export default class DatabaseProvider {

  static realm = null;

  static _instance = null;

  static get instance() {
    if (DatabaseProvider._instance == null) DatabaseProvider._instance = new DatabaseProvider();
    return DatabaseProvider._instance;
  }

  async load_database() {

    let classes = [
      DeviceLog,
      GPSLog,
      BatteryLog,
      ServiceLog
    ];

    // let visitation = {
    //   name: "tb_scm_tr_schedule_visitation",
    //   properties: {
    //     schedule_id: "int?",
    //     id: "int",
    //     date_visited: "date",
    //     is_uploaded: { type: "bool", default: false },
    //     customer_id: "int",
    //     batch_code: "string?",
    //     landline_no: "string?",
    //     mobile_no: "string?",
    //     la: "string?",
    //     visited_by: "string?"
    //   }
    // }

    // let visitation_right_party = {
    //   name: "tb_scm_tr_schedule_visitation_right_party",
    //   properties: {
    //     schedule_visitation_id: "int?",
    //     id: "int",
    //     printed_name: "string",
    //     signature: "string",
    //     time: "date",
    //     mobile_no: "string?",
    //     landline_no: "string?",
    //     email_add: "string?",
    //     rfd: "string?",
    //     ptp_date: "string?",
    //     ptp_amount: "float",
    //     best_time_to_call: "date?"
    //   }
    // }

    // let visitation_third_party = {
    //   name: "tb_scm_tr_schedule_visitation_third_party",
    //   properties: {
    //     schedule_visitation_id: "int?",
    //     id: "int",
    //     printed_name: "string",
    //     signature: "string",
    //     relationship_to_addressee: "string?",
    //     mobile_no: "string?",
    //     landline_no: "string?",
    //     client_whereabouts: "string?",
    //     work: "string?",
    //     place: "string?"
    //   }
    // }

    // let visitation_negative_party = {
    //   name: "tb_scm_tr_schedule_visitation_negative_party",
    //   properties: {
    //     schedule_visitation_id: "int?",
    //     id: "int",
    //     reason: "string",
    //     source_of_information: "string",
    //     time: "date"
    //   }
    // }
  
    // add schema to database
    DatabaseProvider.realm = await Realm.open({
      path: "enzi",
      schema: classes.map((c) => c.schema),
      schemaVersion: 11
    });

    // classes.forEach((c) => {
    //   c.get = ({ where, limit, sort }) => {
    //     let object = DatabaseProvider.realm.objects(c.schema.name);
    //     if (where)
    //       where.forEach((w) => {
    //         object = object.filtered(w.condition, ...w.value);
    //       })
    //     if (sort)
    //       object = object.sorted(sort.field, sort.sorted);
    //     if (limit)
    //       object = object.filtered("id == id limit(" + limit + ")");
        
    //     return object;
    //   }
    //   c.insert = (record) => {
    //     let query_object = new QueryObject;
    //     query_object.create(c.schema.name, record);
    //     this.save_to_db(query_object);
    //   }
    //   c.update = () => {}
    //   c.remove = () => {}
    // })
  }

  save_to_db(query_object) {
    DatabaseProvider.realm.write(() => {
      try {
        query_object.queries.forEach((query) => {
          switch (query.type) {
            case "create":
              let id = DatabaseProvider.realm.objects(query.table).max("id");
              if (id === undefined) id = 1;
              else id++;
              query.record.id = id;
              DatabaseProvider.realm.create(query.table, query.record);
              break;

            case "update":
              query.object[query.object.property] = query.object.value;
              break;

            case "delete":
              DatabaseProvider.realm.delete(query.object);
              query.object = null;
              break;
            default:
              break;
          }
        });
        
      } catch (error) {
        console.log("error: ", error)
      }
    });
  }
  
  retrieve ({ table, where, limit, sort }) {
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

  get_last_id(table) {
    let last_id = DatabaseProvider.realm.objects(table).max('id');
    
    if (!last_id) {
      last_id = 0;
    }

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