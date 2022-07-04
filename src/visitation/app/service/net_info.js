import NetInfo from '@react-native-community/netinfo' ;
import DeviceLogController from '../controller/log/log';
import BatteryLogController from '../controller/log/log_battery';
import ServiceLogController from '../controller/log/log_service';
import TriggerType from '../enum/triggertype';
import Helper from '../helpers/helper';

export default class NetInfoService {
   
   static init() {

      const unsubscribe = NetInfo.addEventListener(state => {
         const log_type_id = Helper.toLogTypeID(undefined, state);
         const carrier = state.details.carrier;
         const cellular_generation = state.details.cellularGeneration;
         const strength = state.details.strength;
         const trigger_type_id = TriggerType.NET_INFO_CHANGE;
         let log_id = DeviceLogController.insert(trigger_type_id);
         BatteryLogController.insert(log_id);
         ServiceLogController.insert(log_id, log_type_id, carrier, cellular_generation, strength);
         if (!state.isInternetReachable && state.isConnected) {
           log_id = DeviceLogController.insert(trigger_type_id);
           BatteryLogController.insert(log_id);
           ServiceLogController.insert(log_id, LogType.INTERNET_UNREACHABLE);
         }
      });
   }
}