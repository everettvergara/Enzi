import Config from "../config/config";

export default class VisitationController {

   static async get_visitations_by_date_range(date_from, date_to, token) {
      return await fetch(Config.SERVER_URL + "/visitation/get_by_date_range?date_from=" + date_from + "&date_to=" + date_to, {
         method: 'GET',
         headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + token
         }
      })
         .then((response) => response.json())
   } 

   static async get_visitation(id, token) {
      return await fetch(Config.SERVER_URL + "/visitation/get?id=" + id, {
         method: 'GET',
         headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + token
         }
      })
         .then((response) => response.json())
   }

   static async get_visitation_entry(id, token) {
      return await fetch(Config.SERVER_URL + "/visitation/get_entry?id=" + id, {
         method: 'GET',
         headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + token
         }
      })
         .then((response) => response.json())
   }

   static async update_visitation_entry(data, token) {
      return await fetch(Config.SERVER_URL + "/visitation/update_entry", {
         method: 'POST',
         headers: {
            'Accept': 'application/json',
            'Content-type': "application/json",
            'Authorization': 'Bearer ' + token
         },
         body: JSON.stringify(data)
      })
         .then((response) => response.text())
   }
}