import SystemSetting from "react-native-system-setting";
import DeviceLogController from "../controller/log/log";
import BatteryLogController from "../controller/log/log_battery";
import ServiceLogController from "../controller/log/log_service";
import TriggerType from "../enum/triggertype";
import Helper from "../helpers/helper";

export default class SystemSettingService {
   
   static init() {
      // check if gps and airplane is enabled on application startup
      SystemSetting.isLocationEnabled().then(location_enabled => {
         const log_type_id = Helper.toLogTypeID({ type: "location", enabled: location_enabled });
         const trigger_type_id = TriggerType.APP_STARTUP;
         let log_id = DeviceLogController.insert(trigger_type_id);
         BatteryLogController.insert(log_id);
         ServiceLogController.insert(log_id, log_type_id);
      });
      SystemSetting.isAirplaneEnabled().then(airplane_mode_enabled => {
         const log_type_id = Helper.toLogTypeID({ type: "airplane", enabled: airplane_mode_enabled });
         const trigger_type_id = TriggerType.APP_STARTUP;
         let log_id = DeviceLogController.insert(trigger_type_id);
         BatteryLogController.insert(log_id);
         ServiceLogController.insert(log_id, log_type_id);
      });

      SystemSetting.addLocationListener((location_enabled) => {
         const log_type_id = Helper.toLogTypeID({ type: "location", enabled: location_enabled });
         const trigger_type_id = TriggerType.SYSTEM_SETTING_CHANGE;
         let log_id = DeviceLogController.insert(trigger_type_id);
         BatteryLogController.insert(log_id);
         ServiceLogController.insert(log_id, log_type_id);
       });
       SystemSetting.addAirplaneListener((airplane_mode_enabled) => {
         const log_type_id = Helper.toLogTypeID({ type: "airplane", enabled: airplane_mode_enabled });
         const trigger_type_id = TriggerType.SYSTEM_SETTING_CHANGE;
         let log_id = DeviceLogController.insert(trigger_type_id);
         BatteryLogController.insert(log_id);
         ServiceLogController.insert(log_id, log_type_id);
       });
   }
}