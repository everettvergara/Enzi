import Config from "../config/config";
import Helper from "../helpers/helper";
// import CoverageDatabaseProvider from "../providers/database/coverage/coverage";
// import CoverageCustomerDatabaseProvider from "../providers/database/coverage/coverage_customer";
// import CustomerDatabaseProvider from "../providers/database/customer/customer";
import LogDatabaseProvider from "../providers/database/log/log";
import GPSLogDatabaseProvider from "../providers/database/log/log_gps";


export default class TrackerController {

   static async load_tracker(date_from, date_to, token) {

      let tracker_request = await fetch(Config.SERVER_URL + "/visitation/get_tracks_by_date_range?date_from=" + date_from + "&date_to=" + date_to, {
         method: 'GET',
         headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + token
         }
      })
      
      tracker_request = await tracker_request.json();

      if (tracker_request.status == "Failed") throw new Error ("Load Visitations Failed");

      let tracks = [];

      let visitations = tracker_request.data;

      for (let i = 0; i < visitations.length; i++) {
         let visitation = visitations[i];

         let visitation_details = visitation.visitation_details;
         
         let visitation_details_length = visitation_details.length;

         for (let j = 0; j < visitation_details_length; j++) {
            let visitation_detail = visitation_details[j];
            
            let track = {
               id: visitation_detail.id,
               visitation_date: visitation.date,
               name: visitation_detail.name,
               remarks: visitation.remarks,
               date: visitation.date,
               coords: []
            };

            if (visitation_detail.is_visited) {
               track.coords.push({
                  lat: 14,//visitation_detail.visit_gps_lat,
                  lng: 121,//visitation_detail.visit_gps_lng,
                  text: "Visit",
                  address: "Visit Address", // coverage_customer.check_in_gps_address,
                  datetime: visitation_detail.date_visited
               });
            }

            tracks.push(track);

            track = {
               id: visitation_detail.id + 0.001,
               visitation_date: visitation.date,
               name: "In Transit",
               coords: []
            };

            let gps_timestamp_from = Helper.to_timestamp(visitation_detail.date_visited);

            let logs = [];

            if (j < visitation_details_length - 1) {
               let gps_timestamp_to = Helper.to_timestamp(visitation.visitation_details[j + 1].date_visited);
               logs = LogDatabaseProvider.get_by_date_range_sorted_asc(gps_timestamp_from, gps_timestamp_to);
            }
            else {
               logs = LogDatabaseProvider.get_by_date_later_sorted_asc(gps_timestamp_from);
            }

            for (var k = 0; k < logs.length; k++) {
               let gps_logs = GPSLogDatabaseProvider.get_by_log_id(logs[k].id);
               if (gps_logs.length > 0) {
                  gps_logs = gps_logs.map(gps_log => {
                     gps_log.datetime = Helper.toDate(logs[k].log_time);
                     return gps_log;
                  });
                  track.coords = track.coords.concat(gps_logs);
               }
            }

            tracks.push(track);
         }
      }

      return await new Promise((resolve) => resolve(tracks));
   }
}