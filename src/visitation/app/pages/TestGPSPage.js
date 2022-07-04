import React from 'react';
import FontAwesome from "react-native-vector-icons/FontAwesome";
import IconButton from '../components/IconButton';
import Helper from '../helpers/helper';

import {
  Text,
  TextInput,
  FlatList,
  Image,
  View,
  ScrollView
} from 'react-native';


import dateFormat, { masks } from "dateformat";
import DatePickerPlus from '../components/DatePicker';
import LogController from '../controller/log/log';
import SyncController from '../controller/sync';
// import DatePicker from 'react-native-date-picker'

const TestGPSPage = ({ navigation, route }) => {

   const [lat, setLat] = React.useState(null);
   const [lng, setLng] = React.useState(null);

   const [list, setList] = React.useState(LogController.get_logs());

   const [date_from, set_date_from] = React.useState(new Date());
   const [date_to, set_date_to] = React.useState(new Date());

   const save = () => {
      setList(LogController.get_logs());
   }

   const clear_all = () => {
      LogController.delete_all();
      setList(LogController.get_logs());
   }

   const sync = () => {
      SyncController.upload_sys_logs();
   }

   const search = () => {
      console.log(date_from, date_to);
   }

   return(
     <ScrollView>
         <View style={{ padding: 10 }}>
            <View>
               <Text style={{ fontSize: 10 }}>Latitude</Text>
               <TextInput onChangeText={(lat) => {
                  setLat(parseFloat(lat));
               }} style={{ padding: 0, fontSize: 15, color: "black", borderBottomColor: "grey", borderBottomWidth: 1 }}></TextInput>
            </View>
            <View style={{ marginVertical: 6 }}>
               <Text style={{ fontSize: 10 }}>Longitude</Text>
               <TextInput onChangeText={(lng) => {
                  setLng(parseFloat(lng));
               }} style={{ padding: 0, fontSize: 15, color: "black", borderBottomColor: "grey", borderBottomWidth: 1 }}></TextInput>
            </View>
            <View style={{ marginVertical: 6 }}>
               <Text style={{ fontSize: 10 }}>Date From</Text>
               <DatePickerPlus mode="date" value={date_from} pickerStyle={ {borderBottomColor: "grey", borderBottomWidth: 1} }>
               </DatePickerPlus>
            </View>
            <View style={{ marginVertical: 6 }}>
               <Text style={{ fontSize: 10 }}>Date To</Text>
               <DatePickerPlus mode="date" value={date_to} pickerStyle={ {borderBottomColor: "grey", borderBottomWidth: 1} }>
               </DatePickerPlus>
            </View>
         </View>
      <IconButton onPress={search} iconSize={12} style={{ flex: 1, margin: 5, backgroundColor: "#0f7fff", borderRadius: 2, padding: 5, marginHorizontal: 3 }} title="Search" icon="search"></IconButton>
       <IconButton onPress={save} iconSize={12} style={{ flex: 1, margin: 5, backgroundColor: "#0f7fff", borderRadius: 2, padding: 5, marginHorizontal: 3 }} title="Save" icon="save"></IconButton>
       <IconButton onPress={clear_all} iconSize={12} style={{ flex: 1, margin: 5, backgroundColor: "#0f7fff", borderRadius: 2, padding: 5, marginHorizontal: 3 }} title="Clear All" icon="close"></IconButton>
       <IconButton onPress={sync} iconSize={12} style={{ flex: 1, margin: 5, backgroundColor: "#0f7fff", borderRadius: 2, padding: 5, marginHorizontal: 3 }} title="Sync" icon="close"></IconButton>
         <View>
         {
           
            list.map((log) => {
               return (
                  <View key={log.id} style={{ padding: 10, borderBottomColor: "black", borderBottomWidth: 1 }}>
                     <Text style={{ fontWeight: 'bold' }}>{ log.id }</Text>
                     <Text>Date: { dateFormat(Helper.toDate(log.log_time), "yyyy mmm d hh:MM TT") }</Text>
                     <Text>Trigger Type: { Helper.toTriggerTypeName(log.trigger_type_id) }</Text>
                     <Text>Battery Level: { log.battery_log.battery_level }</Text>
                     <Text>Lat: { log.gps_log.lat }</Text>
                     <Text>Lng: { log.gps_log.lng }</Text>
                     
                     {
                        log.service_logs.map((service_log) => {
                           return (
                              <View key={service_log.id} style={{ borderBottomColor: "grey", borderBottomWidth: 1 }}>
                                 <Text>Log Type: { Helper.toLogTypeName(service_log.type_id) }</Text>
                                 <Text>Carrier: { service_log.carrier }</Text>
                                 <Text>Cellular Generation: { service_log.cellular_generation }</Text>
                                 <Text>Wifi Strength: { service_log.wifi_strength }</Text>
                              </View>
                           );
                        })
                     }

                        
                  </View>
               )
            })
         }
         </View>
      </ScrollView>
   )
}

export default TestGPSPage;