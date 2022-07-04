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
import DatePicker from 'react-native-date-picker'

const DatePickerPlus = ({ pickerStyle, textStyle, value, format, mode }) => {

   const [date, setDate] = React.useState(value ? value: new Date());
   const [open, setOpen] = React.useState(false);

   return (
      <View style={[{ flexDirection: "row", alignItems: "center" }, pickerStyle]}>
         <Text onPress={() => setOpen(true)} style={[textStyle ? textStyle: { color: "black" }, { flex: 1 }]}>{ dateFormat(date, format ? format: "yyyy mmm d") }</Text>
         <FontAwesome onPress={() => setOpen(true)}  name='calendar' color="#0000c0" style={{ fontSize: 15 }}></FontAwesome>
         <DatePicker
            modal
            mode={mode}
            open={open}
            date={date}
            onConfirm={(date) => {
               setOpen(false)
               setDate(date)
            }}
            onCancel={() => {
               setOpen(false)
            }}
         ></DatePicker>
      </View>
   )
}

export default DatePickerPlus;