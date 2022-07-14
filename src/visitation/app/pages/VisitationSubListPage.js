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
  TouchableOpacity,
} from 'react-native';
import VisitationController from '../controller/visitation';
import { useFocusEffect } from '@react-navigation/native';
import Config from '../config/config';
import DraggableFlatList, { ScaleDecorator } from 'react-native-draggable-flatlist';
import Helper from '../helpers/helper';
// import OrderPage from './OrderPage';

const CoveragePlan = ({ item, navigation, onLongPress }) => {
  const [isOpened, setOpen] = React.useState(true);
  return (
    <TouchableOpacity onLongPress={onLongPress}>
      <View key={item.id} style={{ borderBottomColor: 'grey', flexDirection: "row", alignItems: "center", borderBottomWidth: 1, padding: 4 }}>
        <FontAwesome name='arrows' size={12} style={{ marginRight: 10 }}></FontAwesome>
        <View style={{ flex: 1 }}>
          <Text style={{ fontWeight: 'bold', color: item.is_visited?"green":"red", fontSize: 12 }}>{item.name}</Text>
          <Text style={{ fontSize: 12 }}>{item.address}</Text>
        </View>
        <IconButton icon="pencil" onPress={() => { navigation.push('Visitation Entry', { visitation_detail_id: item.id });  }} iconSize={10} width={30}></IconButton>
      </View>
    </TouchableOpacity>
    
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

	const update_sequence = (data, from, to) => {
		console.log(from, to);
  
		let old_data = Helper.replicate_object(visitation_details);
		set_visitation_details(data);
  
		VisitationController.update_sequence(visitation_id, (from + 1), (to + 1), Config.current_user.api_token)
		.then((json) => {
		  if (json.status == "Failed") { throw new Error("Update Sequence Failed") }
		  set_visitation_details(data);
		})
		.catch((e) => {
		  alert("Error: " + e);
		  set_visitation_details(old_data);
		});
	 }

   const list_header = () => {
    return (
      <>
        <View style={{ marginLeft: 5, flexDirection: "row", alignItems: "center", marginBottom: 10 }}>                    
          <View style={{ flex: 1 }}>
            <Text style={{ fontWeight: "bold", fontSize: 16 }}>{ visitation_date }</Text>
            <Text>{ visitation_remarks }</Text>
          </View>
        </View>
         <View style={{ flexDirection: 'row', alignItems: 'center' }}>
          
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
      </>
    );
   };

   return (
    <DraggableFlatList
			data={visitation_details}
			style={{ margin: 10 }}
			renderItem={({ item, drag }) => {
			return (<ScaleDecorator>
				<CoveragePlan item={item} onLongPress={drag} navigation={navigation}></CoveragePlan>
			</ScaleDecorator>)
			}}
			onDragEnd={({ data, from, to }) => {
				update_sequence(data, from, to);
			}}
			keyExtractor={(item) => item.id}
			ListHeaderComponent={list_header}
		>

	  </DraggableFlatList>
   );
}

export default VisitationSubListPage;