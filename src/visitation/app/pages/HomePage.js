import React from 'react';
import FontAwesome from "react-native-vector-icons/FontAwesome";
import DatePicker from 'react-native-date-picker'
import dateFormat, { masks } from "dateformat";
import IconButton from '../components/IconButton';

import {
  ScrollView,
  Text,
  View,
} from 'react-native';
import VisitationController from '../controller/visitation';
import { useFocusEffect } from '@react-navigation/native';

const CoveragePlan = ({ item, navigation }) => {
  const [isOpened, setOpen] = React.useState(true);
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

const HomePage = ({navigation, route}) => {

   let customerData = [
     {
       id: 1, 
       name: "Everett Vergara", 
       address: "Valenzuela City",
       is_visited: true
     },
     {
       id: 2, 
       name: "Rae Pambid", 
       address: "Quezon City",
       is_visited: false
     },
     {
       id: 3, 
       name: "Asher Tutanes", 
       address: "Pasig City",
       is_visited: true
     }
  ]

   const [asofDate, searchByDate] = React.useState(new Date());
 
   const [open, setOpen] = React.useState(false)

   const date_today = dateFormat(new Date(), "yyyy-mm-dd");

  const [visitation_remarks, set_visitation_remarks] = React.useState("-- No visitations for today yet --");
  const [visitation_details, set_visitation_details] = React.useState([]);

   React.useEffect(() => {
    
  }, [route])

  useFocusEffect(React.useCallback(() => {
    VisitationController.get_visitations_by_date(date_today, date_today)
    .then((json) => {
      console.log(json)
      json = json[0];

      if (json) {
        set_visitation_remarks(json.remarks);
        set_visitation_details(json.visitation_details);
      } 
      
    })
  }, []));
 
   return (
     <ScrollView>      
       <Text style={{ fontSize: 14, textAlign: "center", color: "black" }}>
          <Text>Welcome, </Text>
          <Text style={{ fontWeight: 'bold' }}>Benedict</Text>
         
       </Text>
       
       <View style={{ padding: 10 }}>
         <View style={{ flexDirection: 'row', alignItems: 'center' }}>
          {/* <Text style={{ fontWeight: 'bold', textAlign: "center", padding: 5, flex: 1 }} onPress={() => setOpen(true)}>
            <Text style={{ fontSize: 13 }}>VISITATION for{"\n"}</Text>
            <Text style={{ fontSize: 15, color: "blue", textDecorationLine: "underline" }}>{ dateFormat(asofDate, "yyyy mmm d") }</Text>
            <Text>  </Text>
            <FontAwesome name='calendar' color="#0000c0" style={{ fontSize: 15 }}></FontAwesome>
          </Text> */}
                    
          <View style={{ flex: 1 }}>
            <Text style={{ fontWeight: "bold", fontSize: 16 }}>{ date_today }</Text>
            <Text>{ visitation_remarks }</Text>
          </View>

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
         
         <View style={{ margin: 5 }}>
            <View style={{ flexDirection: "row" }}>
               <Text style={{ color: "green", fontWeight: "bold" }}>VISITED</Text>
               <Text style={{ color: "green", textAlign: "right", flex: 1 }}>{ visitation_details.filter(x => x.is_visited).length }</Text>
            </View>
            <View style={{ flexDirection: "row", borderBottomColor: "grey", borderBottomWidth: 1 }}>
               <Text style={{ color: "red", fontWeight: "bold" }}>NOT VISITED</Text>
               <Text style={{ color: "red", textAlign: "right", flex: 1 }}>{ visitation_details.filter(x => !x.is_visited).length }</Text>
            </View>
            <View style={{ flexDirection: "row" }}>
               <Text style={{ color: "black", fontWeight: "bold", fontSize: 16 }}>TOTAL</Text>
               <Text style={{ color: "black", textAlign: "right", flex: 1, fontSize: 16 }}>{ visitation_details.length }</Text>
            </View>
         </View>
         
         
 
         
         {
           visitation_details.map((item) => {
             return <CoveragePlan item={item} navigation={navigation} key={item.id}></CoveragePlan>            
           })
         }
       </View>
     </ScrollView>
   );
}

export default HomePage;