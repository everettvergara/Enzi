import React from 'react';
import { NavigationContainer } from '@react-navigation/native';
import { createNativeStackNavigator } from '@react-navigation/native-stack';
import FontAwesome from "react-native-vector-icons/FontAwesome";
import DatePicker from 'react-native-date-picker'
import dateFormat, { masks } from "dateformat";
import IconButton from '../components/IconButton';




import {
   SafeAreaView,
   ScrollView,
   StatusBar,
   StyleSheet,
   Text,
   Switch,
   Button,
   TextInput,
   FlatList,
   TouchableOpacity,
   Image,
   useColorScheme,
   View,
} from 'react-native';
import VisitationController from '../controller/visitation';
import Config from '../config/config';
// import Dropdown from '../components/Dropdown';


const VisitationListPage = ({ navigation }) => {

   const [dateFrom, setDateFrom] = React.useState(new Date());
   const [openedDateFrom, openDateFrom] = React.useState(false);
   const [dateTo, setDateTo] = React.useState(new Date());
   const [openedDateTo, openDateTo] = React.useState(false);

   const [visitations, set_visitations] = React.useState([]);

   React.useEffect(() => {
      search_visitations();
   }, []);

   const search_visitations = () => {
      // let date_from = dateFormat(dateFrom, "yyyy-mm-dd");
      // let date_to = dateFormat(dateTo, "yyyy-mm-dd");

      VisitationController.get_visitations_by_date_range(dateFormat(dateFrom, "yyyy-mm-dd"), dateFormat(dateTo, "yyyy-mm-dd"), Config.current_user.api_token)
      .then((json) => {
         var data = json.data;
         set_visitations(data);
      })
   }
 
   return ( <ScrollView>
      
      <View style={{ flexDirection: "row", padding: 10 }}>
         <View style={{ flex: 1 }}>
            <View style={{ flexDirection: "row" }}>
               <View style={{ flex: 1, padding: 5 }}>
                  <Text style={{ fontSize: 10 }}>Date From</Text>
                  <View style={{ fontSize: 15, borderBottomColor: "grey", borderBottomWidth: 1, flexDirection: "row" }}>
                     <Text onPress={() => openDateFrom(true)} style={{ flex: 1, color: "black" }}>{ dateFormat(dateFrom, "yyyy mmm d") }</Text>
                     <FontAwesome name='calendar' color="#0000c0" style={{ fontSize: 15 }}></FontAwesome>
                  </View>
               </View>
               <View style={{ flex: 1, padding: 5 }} onPress={() => openDateTo(true)}>
                  <Text style={{ fontSize: 10 }}>Date To</Text>
                  <View style={{ fontSize: 15, borderBottomColor: "grey", borderBottomWidth: 1, flexDirection: "row" }}>
                     <Text onPress={() => openDateTo(true)} style={{ flex: 1, color: "black" }}>{ dateFormat(dateTo, "yyyy mmm d") }</Text>
                     <FontAwesome name='calendar' color="#0000c0" style={{ fontSize: 15 }}></FontAwesome>
                  </View>
               </View>
            </View>
         </View>
         <View>
            <IconButton onPress={search_visitations} iconSize={20} style={{ margin: 5, backgroundColor: "#0f7fff", borderRadius: 2, padding: 5, marginHorizontal: 3, width: 40, height: 40, color: "white" }} title="Search" icon="search"></IconButton>
         </View>
         <DatePicker
            modal
            mode="date"
            open={openedDateFrom}
            date={dateFrom}
            onConfirm={(date) => {
               openDateFrom(false)
               setDateFrom(date)
            }}
            onCancel={() => {
               openDateFrom(false)
            }}
         ></DatePicker>
         <DatePicker
            modal
            mode="date"
            open={openedDateTo}
            date={dateTo}
            onConfirm={(date) => {
               openDateTo(false)
               setDateTo(date)
            }}
            onCancel={() => {
               openDateTo(false)
            }}
         ></DatePicker>
      </View>

         

      <View style={{ padding: 5 }}>
         {
            visitations.map((o) => {
               return (
                  <View key={o.id} style={{ marginLeft: 5, borderBottomColor: "#ddd", borderBottomWidth: 1, padding: 3, flexDirection: "row", alignItems: "center" }}>                    
                     <View style={{ flex: 1 }}>
                        <Text style={{ fontWeight: "bold", fontSize: 16 }}>{ o.date }</Text>
                        <Text>{ o.remarks }</Text>
                     </View>
                     <View>
                        <IconButton iconSize={14} onPress={() => navigation.navigate('Visitation Sub List', { visitation_id: o.id }) } icon="eye" style={{ width: 30, color: "white", margin: 5, backgroundColor: "#0f7fff", borderRadius: 2, padding: 5, marginHorizontal: 3 }}></IconButton>
                     </View>
                  </View>
               );
            })
         }
      </View>
   </ScrollView>)
}

export default VisitationListPage;