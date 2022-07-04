import React from 'react';
import FontAwesome from "react-native-vector-icons/FontAwesome";
import {
   Text,
   TouchableOpacity
} from 'react-native';

const IconButton = ({ title, onPress, icon, width, iconSize, style }) => {
   if (!iconSize) iconSize = 18;
   if (!style) style = { backgroundColor: "grey", alignItems: 'center', padding: 8, width, borderRadius: 3, flexDirection: "row", color: "white" };
   
   style.flexDirection = "row";
   style.alignItems = "center";
   return (
     <TouchableOpacity style={style} onPress={onPress}>
       <Text style={{ textAlign: 'center', flex: 1, alignItems: 'center' }}>
         
        <Text>
          <FontAwesome
            name={icon}
            size={iconSize}
            style={{ color: style.color }}
          />
        </Text>
        {
         title ? (<Text style={{ fontSize: iconSize, color: "white", flexWrap: "wrap", textAlign: 'center' }}>  {title}</Text>): null
        }
       </Text>
       
       
       
     </TouchableOpacity>
   );
}

export default IconButton;