import React from 'react';
import FontAwesome from "react-native-vector-icons/FontAwesome";
import IconButton from '../components/IconButton';

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
import VisitationController from '../controller/visitation';
import DatePicker from 'react-native-date-picker';
// import DatePicker from 'react-native-date-picker'

const VisitationPage = ({ navigation, route }) => {

   const [customer_name, set_customer_name] = React.useState("");
   const [account_no, set_account_no] = React.useState("");
   const [batch_code, set_batch_code] = React.useState("");
   const [landline_no, set_landline_no] = React.useState("");
   const [mobile_nos, set_mobile_nos] = React.useState("");
   const [la, set_la] = React.useState("");
   const [visited_by, set_visited_by] = React.useState("");
   const [date_visited, set_date_visited] = React.useState(new Date());

   const [right_party_printed_name, set_right_party_printed_name] = React.useState("");
   const [right_party_time, set_right_party_time] = React.useState(new Date());
   const [right_party_mobile_no, set_right_party_mobile_no] = React.useState("");
   const [right_party_landline_no, set_right_party_landline_no] = React.useState("");
   const [right_party_email_add, set_right_party_email_add] = React.useState("");
   const [right_party_rfd, set_right_party_rfd] = React.useState("");
   const [right_party_ptp_date, set_right_party_ptp_date] = React.useState(new Date());
   const [right_party_ptp_amount, set_right_party_ptp_amount] = React.useState("0");
   const [right_party_best_time_to_call, set_right_party_best_time_to_call] = React.useState(new Date());

   const [third_party_printed_name, set_third_party_printed_name] = React.useState("");
   const [third_party_relationship, set_third_party_relationship] = React.useState("");
   const [third_party_mobile_number, set_third_party_mobile_number] = React.useState("");
   const [third_party_landline_no, set_third_party_landline_no] = React.useState("");
   const [third_party_whereabouts, set_third_party_whereabouts] = React.useState("");
   const [third_party_work, set_third_party_work] = React.useState("");
   const [third_party_work_address, set_third_party_work_address] = React.useState("");

   const [negative_reason, set_negative_reason] = React.useState("");
   const [negative_source_of_information, set_negative_source_of_information] = React.useState("");
   const [negative_time, set_negative_time] = React.useState(new Date());

   const [is_date_visited_opened, open_date_visited] = React.useState(false);
   const [is_right_party_time_opened, open_right_party_time] = React.useState(false);
   const [is_right_party_ptp_date_opened, open_right_party_ptp_date] = React.useState(false);
   const [is_right_party_best_time_to_call_opened, open_right_party_best_time_to_call] = React.useState(false);
   const [is_negative_time_opened, open_negative_time] = React.useState(false);

   React.useEffect(() => {
      VisitationController.get_visitation_entry(route.params.visitation_detail_id)
        .then((json) => {

            set_customer_name(json.name);
            set_account_no(json.account_no);
            set_batch_code(json.batch_code);
            set_landline_no(json.landline_no);
            set_mobile_nos(json.mobile_nos);
            set_la(json.LA);
            set_visited_by(json.visited_by);
            set_date_visited(json.date_visited ? new Date(json.date_visited): new Date());

            if (json.right_party != false) {
               setTabActive(0);
               set_right_party_printed_name(json.right_party.printed_name);
               set_right_party_time(new Date(json.right_party.time));
               set_right_party_mobile_no(json.right_party.mobile_no);
               set_right_party_landline_no(json.right_party.landline_no);
               set_right_party_email_add(json.right_party.email_add);
               set_right_party_rfd(json.right_party.rfd);
               set_right_party_ptp_date(new Date(json.right_party.ptp_date));
               set_right_party_ptp_amount(json.right_party.ptp_amount.toString());
               set_right_party_best_time_to_call(new Date(json.right_party.best_time_to_call));
            }
            else if (json.third_party != false) {
               setTabActive(1);
               set_third_party_printed_name(json.right_party.printed_name);
               set_third_party_relationship(new Date(json.right_party.time));
               set_third_party_mobile_number(json.right_party.mobile_no);
               set_third_party_landline_no(json.right_party.landline_no);
               set_third_party_whereabouts(json.right_party.email_add);
               set_third_party_work(json.right_party.rfd);
               set_third_party_work_address(new Date(json.right_party.ptp_date));
            }
            else if (json.negative != false) {
               setTabActive(2);
               set_negative_reason(json.negative.reason);
               set_negative_source_of_information(json.negative.source_of_information);
               set_negative_time(new Date(json.negative.time));
            }
        })
   }, [route])
 
   const [activeTab, setTabActive] = React.useState(0);

   const save = () => {
      const data = {
         id: route.params.visitation_detail_id,
         date_visited: dateFormat(date_visited, "yyyy-mm-dd"),
         is_visited: true,
         right_party: activeTab == 0 ? {
            printed_name: right_party_printed_name,
            time: dateFormat(right_party_time, "yyyy-mm-dd HH:MM"),
            mobile_no: right_party_mobile_no,
            landline_no: right_party_landline_no,
            email_add: right_party_email_add,
            rfd: right_party_rfd,
            ptp_date: dateFormat(right_party_ptp_date, "yyyy-mm-dd"),
            ptp_amount: parseFloat(right_party_ptp_amount),
            best_time_to_call: dateFormat(right_party_best_time_to_call, "yyyy-mm-dd HH:MM"),
         } : false,
         third_party: activeTab == 1 ? {
            printed_name: third_party_printed_name,
            relationship: third_party_relationship,
            mobile_number: third_party_mobile_number,
            landline_no: third_party_landline_no,
            whereabouts: third_party_whereabouts,
            work: third_party_work,
            work_address: third_party_work_address
         } : false,
         negative: activeTab == 2 ? {
            reason: negative_reason,
            source_of_information: negative_source_of_information,
            time: dateFormat(negative_time, "yyyy-mm-dd HH:MM"),
         } : false,
         batch_code: batch_code,
         landline_no: landline_no,
         mobile_nos: mobile_nos,
         LA: la,
         visited_by: visited_by
      }

      VisitationController.update_visitation_entry(data)
      .then((t) => {
         console.log(t)
         navigation.pop();
      })
      .catch((e) => console.log(e));
   }
 
   return(
     <ScrollView>
         <View style={{ padding: 10 }}>

            <DatePicker
               modal
               mode="date"
               open={is_date_visited_opened}
               date={date_visited}
               onConfirm={(date) => {
                  set_date_visited(date)
                  open_date_visited(false)
               }}
               onCancel={() => {
                  open_date_visited(false)
               }}
            ></DatePicker>
            <DatePicker
               modal
               mode="time"
               open={is_right_party_time_opened}
               date={right_party_time}
               onConfirm={(date) => {
                  set_right_party_time(date)
                  open_right_party_time(false)
               }}
               onCancel={() => {
                  open_right_party_time(false)
               }}
            ></DatePicker>
            <DatePicker
               modal
               mode="date"
               open={is_right_party_ptp_date_opened}
               date={right_party_ptp_date}
               onConfirm={(date) => {
                  set_right_party_ptp_date(date)
                  open_right_party_ptp_date(false)
               }}
               onCancel={() => {
                  open_right_party_ptp_date(false)
               }}
            ></DatePicker>
            <DatePicker
               modal
               mode="time"
               open={is_right_party_best_time_to_call_opened}
               date={right_party_best_time_to_call}
               onConfirm={(date) => {
                  set_right_party_best_time_to_call(date)
                  open_right_party_best_time_to_call(false)
               }}
               onCancel={() => {
                  open_right_party_best_time_to_call(false)
               }}
            ></DatePicker>
            <DatePicker
               modal
               mode="time"
               open={is_negative_time_opened}
               date={negative_time}
               onConfirm={(date) => {
                  set_negative_time(date)
                  open_negative_time(false)
               }}
               onCancel={() => {
                  open_negative_time(false)
               }}
            ></DatePicker>


            
            <View style={{ marginVertical: 6 }}>
               <Text style={{ fontWeight: "bold", textAlign: 'center', fontSize: 16 }}>{ customer_name }</Text>
               <Text style={{ fontSize: 16, textAlign: 'center' }}>{ account_no }</Text>
            </View>
            <View style={{ marginVertical: 6 }} onPress={() => open_date_visited(true)}>
               <Text style={{ fontSize: 10 }}>Date Visited</Text>
               <View style={{ fontSize: 15, borderBottomColor: "grey", borderBottomWidth: 1, flexDirection: "row" }}>
                  <Text onPress={() => open_date_visited(true)} style={{ flex: 1, color: "black" }}>{ dateFormat(date_visited, "yyyy mmm d") }</Text>
                  <FontAwesome name='calendar' color="#0000c0" style={{ fontSize: 15 }}></FontAwesome>
               </View>
            </View>
            {/* <View style={{ marginVertical: 6 }}>
               <Text style={{ fontSize: 10 }}>Status</Text>
               <Text style={{ fontSize: 15, color: "black", borderBottomColor: "grey", borderBottomWidth: 1 }}>Uploaded</Text>
            </View> */}
         </View>

         <View style={{ padding: 10 }}>
            <View style={{ flexDirection: "row" }}>
               <Text onPress={() => { setTabActive(0) }} style={[{ textAlign: "center", fontSize: 14, fontWeight: "bold", padding: 3, flex: 1 }, activeTab == 0 ? { borderRadius: 4, backgroundColor: "#ddd" }: {}]}>Right Party</Text>
               <Text onPress={() => { setTabActive(1) }} style={[{ textAlign: "center", fontSize: 14, fontWeight: "bold", padding: 3, flex: 1 }, activeTab == 1 ? { borderRadius: 4, backgroundColor: "#ddd" }: {}]}>3rd Party</Text>
               <Text onPress={() => { setTabActive(2) }} style={[{ textAlign: "center", fontSize: 14, fontWeight: "bold", padding: 3, flex: 1 }, activeTab == 2 ? { borderRadius: 4, backgroundColor: "#ddd" }: {}]}>Negative</Text>
            </View>

            <View style={{ display: activeTab == 0 ? "flex": "none" }}>

               <View style={{ marginVertical: 6 }}>
                  <Text style={{ fontSize: 10 }}>Printed Name / Signature</Text>
                  <TextInput value={right_party_printed_name} onChangeText={set_right_party_printed_name} multiline={true} numberOfLines={4} textAlignVertical='bottom' style={{ maxHeight: 150, padding: 0, fontSize: 15, color: "black", borderBottomColor: "grey", borderBottomWidth: 1 }}></TextInput>
               </View>
               <View style={{ marginVertical: 6 }} onPress={() => (true)}>
                  <Text style={{ fontSize: 10 }}>Time</Text>
                  <View style={{ fontSize: 15, borderBottomColor: "grey", borderBottomWidth: 1, flexDirection: "row" }}>
                     <Text onPress={() => open_right_party_time(true)} style={{ flex: 1, color: "black" }}>{ console.log(right_party_time, "sdflkj") } { dateFormat(right_party_time, "hh:MM TT") }</Text>
                     <FontAwesome name='calendar' color="#0000c0" style={{ fontSize: 15 }}></FontAwesome>
                  </View>
               </View>
               <View style={{ marginVertical: 6 }}>
                  <Text style={{ fontSize: 10 }}>Mobile Number</Text>
                  <TextInput value={right_party_mobile_no} onChangeText={set_right_party_mobile_no} style={{ padding: 0, fontSize: 15, color: "black", borderBottomColor: "grey", borderBottomWidth: 1 }}></TextInput>
               </View>
               <View style={{ marginVertical: 6 }}>
                  <Text style={{ fontSize: 10 }}>Landline</Text>
                  <TextInput value={right_party_landline_no} onChangeText={set_right_party_landline_no} style={{ padding: 0, fontSize: 15, color: "black", borderBottomColor: "grey", borderBottomWidth: 1 }}></TextInput>
               </View>
               <View style={{ marginVertical: 6 }}>
                  <Text style={{ fontSize: 10 }}>Email</Text>
                  <TextInput value={right_party_email_add} onChangeText={set_right_party_email_add} style={{ padding: 0, fontSize: 15, color: "black", borderBottomColor: "grey", borderBottomWidth: 1 }}></TextInput>
               </View>
               <View style={{ marginVertical: 6 }}>
                  <Text style={{ fontSize: 10 }}>RFD</Text>
                  <TextInput value={right_party_rfd} onChangeText={set_right_party_rfd} style={{ padding: 0, fontSize: 15, color: "black", borderBottomColor: "grey", borderBottomWidth: 1 }}></TextInput>
               </View>
               <View style={{ marginVertical: 6 }}>
                  <Text style={{ fontSize: 10 }}>PTP Date</Text>
                  <View style={{ fontSize: 15, borderBottomColor: "grey", borderBottomWidth: 1, flexDirection: "row" }}>
                     <Text onPress={() => open_right_party_ptp_date(true)} style={{ flex: 1, color: "black" }}>{ dateFormat(right_party_ptp_date, "yyyy mmm d") }</Text>
                     <FontAwesome name='calendar' color="#0000c0" style={{ fontSize: 15 }}></FontAwesome>
                  </View>
               </View>
               <View style={{ marginVertical: 6 }}>
                  <Text style={{ fontSize: 10 }}>PTP Amount</Text>
                  <TextInput value={right_party_ptp_amount} onChangeText={(text) => set_right_party_ptp_amount(text)} style={{ padding: 0, fontSize: 15, color: "black", borderBottomColor: "grey", borderBottomWidth: 1 }}></TextInput>
               </View>
               <View style={{ marginVertical: 6 }}>
                  <Text style={{ fontSize: 10 }}>Best Time to Call</Text>
                  <View style={{ fontSize: 15, borderBottomColor: "grey", borderBottomWidth: 1, flexDirection: "row" }}>
                     <Text onPress={() => open_right_party_best_time_to_call(true)} style={{ flex: 1, color: "black" }}>{ dateFormat(right_party_best_time_to_call, "hh:MM TT") }</Text>
                     <FontAwesome name='calendar' color="#0000c0" style={{ fontSize: 15 }}></FontAwesome>
                  </View>
               </View>
            </View>

            <View style={{ display: activeTab == 1 ? "flex": "none" }}>
               <View style={{ marginVertical: 6 }}>
                  <Text style={{ fontSize: 10 }}>Printed Name / Signature</Text>
                  <TextInput value={third_party_printed_name} onChangeText={set_third_party_printed_name} multiline={true} numberOfLines={4} textAlignVertical='bottom' style={{ maxHeight: 150, padding: 0, fontSize: 15, color: "black", borderBottomColor: "grey", borderBottomWidth: 1 }}></TextInput>
               </View>
               <View style={{ marginVertical: 6 }}>
                  <Text style={{ fontSize: 10 }}>Relationship to Addressee</Text>
                  <TextInput value={third_party_relationship} onChangeText={set_third_party_relationship} style={{ padding: 0, fontSize: 15, color: "black", borderBottomColor: "grey", borderBottomWidth: 1 }}></TextInput>
               </View>
               <View style={{ marginVertical: 6 }}>
                  <Text style={{ fontSize: 10 }}>Mobile Number</Text>
                  <TextInput value={third_party_mobile_number} onChangeText={set_third_party_mobile_number} style={{ padding: 0, fontSize: 15, color: "black", borderBottomColor: "grey", borderBottomWidth: 1 }}></TextInput>
               </View>
               <View style={{ marginVertical: 6 }}>
                  <Text style={{ fontSize: 10 }}>Landline</Text>
                  <TextInput value={third_party_landline_no} onChangeText={set_third_party_landline_no} style={{ padding: 0, fontSize: 15, color: "black", borderBottomColor: "grey", borderBottomWidth: 1 }}></TextInput>
               </View>
               <View style={{ marginVertical: 6 }}>
                  <Text style={{ fontSize: 10 }}>Client's Whereabouts</Text>
                  <TextInput value={third_party_whereabouts} onChangeText={set_third_party_whereabouts} style={{ padding: 0, fontSize: 15, color: "black", borderBottomColor: "grey", borderBottomWidth: 1 }}></TextInput>
               </View>
               <View style={{ marginVertical: 6 }}>
                  <Text style={{ fontSize: 10 }}>Work/Business</Text>
                  <TextInput value={third_party_work} onChangeText={set_third_party_work} style={{ padding: 0, fontSize: 15, color: "black", borderBottomColor: "grey", borderBottomWidth: 1 }}></TextInput>
               </View>
               <View style={{ marginVertical: 6 }}>
                  <Text style={{ fontSize: 10 }}>Where</Text>
                  <TextInput value={third_party_work_address} onChangeText={set_third_party_work_address} style={{ padding: 0, fontSize: 15, color: "black", borderBottomColor: "grey", borderBottomWidth: 1 }}></TextInput>
               </View>
            </View>

            <View style={{ display: activeTab == 2 ? "flex": "none" }}>
               <View>
                  <Text style={{ fontSize: 10 }}>Why</Text>
                  <TextInput value={negative_reason} onChangeText={set_negative_reason} style={{ padding: 0, fontSize: 15, color: "black", borderBottomColor: "grey", borderBottomWidth: 1 }}></TextInput>
               </View>
               <View style={{ marginVertical: 6 }}>
                  <Text style={{ fontSize: 10 }}>Source of Information</Text>
                  <TextInput  value={negative_source_of_information} onChangeText={set_negative_source_of_information}style={{ padding: 0, fontSize: 15, color: "black", borderBottomColor: "grey", borderBottomWidth: 1 }}></TextInput>
               </View>
               <View style={{ marginVertical: 6 }}>
                  <Text style={{ fontSize: 10 }}>Time</Text>
                  <View style={{ fontSize: 15, borderBottomColor: "grey", borderBottomWidth: 1, flexDirection: "row" }}>
                     <Text onPress={() => open_negative_time(true)} style={{ flex: 1, color: "black" }}>{ dateFormat(negative_time, "hh:MM TT") }</Text>
                     <FontAwesome name='calendar' color="#0000c0" style={{ fontSize: 15 }}></FontAwesome>
                  </View>
               </View>
            </View>
         </View>

         <View style={{ padding: 10 }}>
            <View>
               <Text style={{ fontSize: 10 }}>Batch Code</Text>
               <TextInput value={batch_code} onChangeText={set_batch_code} style={{ padding: 0, fontSize: 15, color: "black", borderBottomColor: "grey", borderBottomWidth: 1 }}></TextInput>
            </View>
            <View style={{ marginVertical: 6 }}>
               <Text style={{ fontSize: 10 }}>Landline</Text>
               <TextInput value={landline_no} onChangeText={set_landline_no} style={{ padding: 0, fontSize: 15, color: "black", borderBottomColor: "grey", borderBottomWidth: 1 }}></TextInput>
            </View>
            <View>
               <Text style={{ fontSize: 10 }}>Mobile Number/s</Text>
               <TextInput value={mobile_nos} onChangeText={set_mobile_nos} style={{ padding: 0, fontSize: 15, color: "black", borderBottomColor: "grey", borderBottomWidth: 1 }}></TextInput>
            </View>
            <View style={{ marginVertical: 6 }}>
               <Text style={{ fontSize: 10 }}>LA</Text>
               <TextInput value={la} onChangeText={set_la} style={{ padding: 0, fontSize: 15, color: "black", borderBottomColor: "grey", borderBottomWidth: 1 }}></TextInput>
            </View>
            <View style={{ marginVertical: 6 }}>
               <Text style={{ fontSize: 10 }}>Visited By</Text>
               <TextInput value={visited_by} onChangeText={set_visited_by} style={{ padding: 0, fontSize: 15, color: "black", borderBottomColor: "grey", borderBottomWidth: 1 }}></TextInput>
            </View>
         </View>
       <IconButton onPress={save} iconSize={12} style={{ flex: 1, margin: 5, backgroundColor: "#0f7fff", borderRadius: 2, padding: 5, marginHorizontal: 3 }} title="Save" icon="save"></IconButton>
     </ScrollView>
   )
}

export default VisitationPage;