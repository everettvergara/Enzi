import Config from "../config/config";

export default class VisitationController {

   static async get_visitations_by_date(date_from, date_to) {
      return await fetch(Config.SERVER_URL + "/get_visitations_by_date.php?date_from=" + date_from + "&date_to=" + date_to, {
         method: 'GET',
         headers: {
            'Accept': 'application/json'
         }
      })
         .then((response) => response.json())
   }

   static async get_visitation(id) {
      return await fetch(Config.SERVER_URL + "/get_visitation.php?id=" + id, {
         method: 'GET',
         headers: {
            'Accept': 'application/json'
         }
      })
         .then((response) => response.json())
   }

   static async get_visitation_entry(id) {
      return await fetch(Config.SERVER_URL + "/get_visitation_entry.php?id=" + id, {
         method: 'GET',
         headers: {
            'Accept': 'application/json'
         }
      })
         .then((response) => response.json())
   }

   static async update_visitation_entry(data) {
      return await fetch(Config.SERVER_URL + "/update_visitation_entry.php", {
         method: 'POST',
         headers: {
            'Accept': 'application/json',
            'Content-type': "application/json"
         },
         body: JSON.stringify(data)
      })
         .then((response) => response.text())
   }
}