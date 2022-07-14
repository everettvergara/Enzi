import LogType from "../enum/logtype";
import TriggerType from "../enum/triggertype";

export default class Helper {
   static get_timestamp() {
      return new Date().getTime();
   }
   static to_timestamp(date) {
      return new Date(date).getTime();
   }
   static toDate(timestamp) {
      return new Date(timestamp);
   }
   static toLogTypeID(system_setting, net_info) {
      let output = null;

      if (system_setting !== undefined) {
         switch (system_setting.type) {
            case "location":
               output = system_setting.enabled ? LogType.GPS_ON: LogType.GPS_OFF;
               break;
            case "airplane":  
               output = system_setting.enabled ? LogType.AIRPLANE_ON: LogType.AIRPLANE_OFF;
               break;
            case "active":
               output = LogType.APP_FOREGROUND;
               break;
            case "background":
               output = LogType.APP_BACKGROUND;
               break;
            default:
               break
         }
      }

      if (net_info !== undefined) {
         switch (net_info.type) {
            case "none":
               output = LogType.INTERNET_DISABLED; 
               break;
            case "unknown":
               output = LogType.UNKNOWN;
               break;
            case "cellular":
               output = LogType.CELLULAR;
               break;
            case "wifi":
               output = LogType.WIFI_ON;
               break;
            case "ethernet":
               output = LogType.ETHERNET;
               break;
            case "wimax":
               output = LogType.WIMAX;
               break;
            case "vpn":
               output = LogType.VPN;
               break;
            case "other":
               output = LogType.OTHER_CONNECTION;
               break;
            default:
               if (!net_info.isInternetReachable) output = LogType.INTERNET_UNREACHABLE;
               break;
         }
      }
      return output;
   }
   

   static replicate_object(any) {
      return JSON.parse(JSON.stringify(any));
   }

   static toTriggerTypeName(value) {
      return Object.keys(TriggerType).find((x) => TriggerType[x] == value)
   }

   static toLogTypeName(value) {
      return Object.keys(LogType).find((x) => LogType[x] == value)
   }
}