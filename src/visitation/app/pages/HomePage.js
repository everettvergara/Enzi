import React from 'react';
import FontAwesome from "react-native-vector-icons/FontAwesome";
import DatePicker from 'react-native-date-picker'
import dateFormat, { masks } from "dateformat";
import IconButton from '../components/IconButton';
import Helper from '../helpers/helper';

import {
  SafeAreaView,
  ScrollView,
  Text,
  TouchableOpacity,
  View,
} from 'react-native';
import VisitationController from '../controller/visitation';
import { useFocusEffect } from '@react-navigation/native';
import Config from '../config/config';

import Draggable from 'react-native-draggable';
import DraggableFlatList, { ScaleDecorator } from 'react-native-draggable-flatlist'
import { FlatList } from 'react-native-gesture-handler';

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

const HomePage = ({navigation, route}) => {

   const [asofDate, searchByDate] = React.useState(new Date());
 
   const [open, setOpen] = React.useState(false)

   const date_today = dateFormat(new Date(), "yyyy-mm-dd");

   const [visitation_id, set_visitation_id] = React.useState(0);
  const [visitation_remarks, set_visitation_remarks] = React.useState("-- No visitations for today yet --");
  const [visitation_details, set_visitation_details] = React.useState([]);

  const [full_name, set_full_name] = React.useState("");

  React.useEffect(() => {
    Config.current_user.full_name = Config.current_user.first_name + " " + Config.current_user.last_name;
    set_full_name(Config.current_user.full_name);
  }, [route])

  useFocusEffect(React.useCallback(() => {
    console.log(Config.current_user.api_token)
    VisitationController.get_visitations_by_date_range(date_today, date_today, Config.current_user.api_token)
    .then((json) => {

      if (json.data.length == 0) return;

      data = json.data[0];

      console.log(data, "s")
     
      // json = json[0];

      // if (json) {
      //   set_visitation_remarks(json.remarks);
      //   set_visitation_details(json.visitation_details);
      // }  
      set_visitation_id(data.id);
      set_visitation_remarks(data.remarks);
      // let vds = [];
      // let vd = Helper.replicate_object(data.visitation_details);
      // for (let index = 0; index < 6; index++) {
      //   vds = vds.concat(vd);
      // }
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
        	<Text style={{ fontSize: 14, textAlign: "center", color: "black" }}>
				<Text>Welcome, </Text>
				<Text style={{ fontWeight: 'bold' }}>{ full_name }</Text>
			</Text>
			<View style={{ flexDirection: 'row', alignItems: 'center' }}>      
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
      </>
    )
  }
 
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
			// ListFooterComponent={() => <Text></Text>}
		>

	  </DraggableFlatList>
   );
}

export default HomePage;