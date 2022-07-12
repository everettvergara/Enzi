import React from 'react';
import FontAwesome from "react-native-vector-icons/FontAwesome";
import DatePicker from 'react-native-date-picker'
import dateFormat, { masks } from "dateformat";
import IconButton from '../components/IconButton';

import { createNativeStackNavigator } from '@react-navigation/native-stack';

import {
  ScrollView,
  Text,
  Switch,
  Image,
  View,
} from 'react-native';
import VisitationController from '../controller/visitation';
import { useFocusEffect } from '@react-navigation/native';
import Config from '../config/config';
// import OrderPage from './OrderPage';

const CoveragePlan = ({ item, navigation }) => {
  const [isOpened, setOpen] = React.useState(true);
  console.log(item, "dko")
  return (
    <View key={item.id} style={{ borderBottomColor: 'grey', flexDirection: "row", alignItems: "center", borderBottomWidth: 1, padding: 4 }}>
      <FontAwesome name='arrows' size={12} style={{ marginRight: 10 }}></FontAwesome>
      <View style={{ flex: 1 }}>
        <Text style={{ fontWeight: 'bold', color: item.is_visited?"green":"red", fontSize: 12 }}>{item.name}</Text>
        <Text style={{ fontSize: 12 }}>{item.address}</Text>
      </View>
      <IconButton icon="pencil" onPress={() => { navigation.push('Visitation Entry', { visitation_detail_id: item.id });  }} iconSize={10} width={30}></IconButton>
    </View>
  )
}



const VisitationSubListPage = ({navigation, route}) => {


  const [visitation_remarks, set_visitation_remarks] = React.useState("");
  const [visitation_id, set_visitation_id] = React.useState(null);
  const [visitation_date, set_visitation_date] = React.useState(null);
  const [visitation_details, set_visitation_details] = React.useState([]);

   const [asofDate, searchByDate] = React.useState(new Date());
   const [open, setOpen] = React.useState(false)

   React.useEffect(() => {
      
   }, [route]);

   useFocusEffect(React.useCallback(() => {
      VisitationController.get_visitation(route.params.visitation_id, Config.current_user.api_token)
      .then((json) => {
        var data = json.data;
        console.log(data)
        set_visitation_id(data.id);
        set_visitation_date(data.date);
        set_visitation_remarks(data.remarks);
        set_visitation_details(data.visitation_details);
      })
   }, []));
 
   return (
     <ScrollView>
       <View style={{ padding: 10 }}>

        <View style={{ marginLeft: 5, flexDirection: "row", alignItems: "center", marginBottom: 10 }}>                    
          <View style={{ flex: 1 }}>
            <Text style={{ fontWeight: "bold", fontSize: 16 }}>{ visitation_date }</Text>
            <Text>{ visitation_remarks }</Text>
          </View>
        </View>
         <View style={{ flexDirection: 'row', alignItems: 'center' }}>
          
          {/* <View style={{ flex: 1, padding: 5 }} onPress={() => setOpen(true)}>
            <Text style={{ fontSize: 10 }}>Search Customers by Date</Text>
            <View style={{ fontSize: 15, borderBottomColor: "grey", borderBottomWidth: 1, flexDirection: "row" }}>
               <Text onPress={() => setOpen(true)} style={{ flex: 1, color: "black" }}>{ dateFormat(asofDate, "yyyy mmm d hh:MM") }</Text>
               <FontAwesome name='calendar' color="#0000c0" style={{ fontSize: 15 }}></FontAwesome>
            </View>
          </View> */}

          <DatePicker
            modal
            mode="date"
            open={open}
            date={asofDate}
            onConfirm={(date) => {
              setOpen(false)
              searchByDate(date)
            }}
            onCancel={() => {
              setOpen(false)
            }}
          ></DatePicker>
         </View>
         
         {/* <View style={{ margin: 5 }}>
            <View style={{ flexDirection: "row" }}>
               <Text style={{ color: "green", fontWeight: "bold" }}>VISITED</Text>
               <Text style={{ color: "green", textAlign: "right", flex: 1 }}>32</Text>
            </View>
            <View style={{ flexDirection: "row", borderBottomColor: "grey", borderBottomWidth: 1 }}>
               <Text style={{ color: "red", fontWeight: "bold" }}>NOT VISITED</Text>
               <Text style={{ color: "red", textAlign: "right", flex: 1 }}>20</Text>
            </View>
            <View style={{ flexDirection: "row" }}>
               <Text style={{ color: "black", fontWeight: "bold", fontSize: 16 }}>TOTAL</Text>
               <Text style={{ color: "black", textAlign: "right", flex: 1, fontSize: 16 }}>52</Text>
            </View>
         </View> */}
         
         
 
         
         {
           visitation_details.map((item) => {
             return <CoveragePlan item={item} navigation={navigation} key={item.id}></CoveragePlan>            
           })
         }
       </View>
     </ScrollView>
   );
}

export default VisitationSubListPage;