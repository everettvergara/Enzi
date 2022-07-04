import { AppState } from 'react-native';
import DeviceLogController from '../controller/log/log';
import BatteryLogController from '../controller/log/log_battery';
import ServiceLogController from '../controller/log/log_service';
import TriggerType from '../enum/triggertype';
import Helper from '../helpers/helper';

export default class AppStateService {

   static init() {
      AppState.addEventListener('change', (state) => {
         const log_type_id = Helper.toLogTypeID({ type: state });
         const trigger_type_id = TriggerType.APP_STATE_CHANGE;
         let log_id = DeviceLogController.insert(trigger_type_id);
         BatteryLogController.insert(log_id);
         ServiceLogController.insert(log_id, log_type_id);
      })
   }
}