const LogType = {
   GPS_ON: 1,
   GPS_OFF:  2,
   INTERNET_DISABLED:  3, // internet connection disabled
   NO_SIGNAL:  4,
   INTERNET_UNREACHABLE:  5, // internet connection enabled but without internet
   AIRPLANE_ON:  6,
   AIRPLANE_OFF:  7,
   SIGNAL:  8,
   APP_FOREGROUND:  9,
   APP_BACKGROUND:  10,
   UNKNOWN: 11,
   CELLULAR: 12,
   WIFI_ON: 13,
   ETHERNET: 14,
   WIMAX: 15,
   VPN: 16,
   OTHER_CONNECTION: 17,
   // LOCATION_PERMISSION_ENABLED: 18,
   // LOCATION_PERMISSION_DISABLED: 19
}

export default LogType;