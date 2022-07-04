import RNLocation from 'react-native-location';
import TriggerType from '../enum/triggertype';
import DeviceLogController from '../controller/log/log'
import GPSLogController from '../controller/log/log_gps';

export default class GPSService {

   static init () {
      RNLocation.configure({
         distanceFrilter: 10,
         interval: 500,
      })
     
      RNLocation.requestPermission({
         android: {
            detail: "fine",
            rationale: {
               title: "We need to access you location",
               message: "We use your location to show where you are on the map",
               buttonPositive: "OK",
               buttonNegative: "Cancel"
            }
         }
      }).then(granted => {
         if (granted) {
            RNLocation.subscribeToLocationUpdates(locations => {
               console.log("loadeng gps")
               const trigger_type_id = TriggerType.GPS_CHANGE;
               
               locations.forEach(location => {
                  let log_id = DeviceLogController.insert(trigger_type_id);
                  GPSLogController.insert(log_id, location.latitude, location.longitude);
               });
            })
         }
      })
   }
}