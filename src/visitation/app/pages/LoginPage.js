import {
   Text,
   Button,
   TextInput,
   Image,
   View,
 } from 'react-native';

import React from 'react';
import { StackActions } from '@react-navigation/native';
import GPSService from '../service/gps';

const LoginPage = ({ navigation }) => {
    const login = () => {
      GPSService.init();
      navigation.dispatch(
          StackActions.replace('Main')
      );
    }
 
   return (
     <>
       <Image style={{ width: "100%", height: 100, resizeMode: "contain" }} source={require('../assets/images/enzi.png')}>
       </Image>
       <Text style={{ fontWeight: "bold", fontSize: 30, marginVertical: 10, textAlign: "center", color: "black" }}>Field Work</Text>
       <View style={{ padding: 10 }}>
         <TextInput placeholder="Username" style={{ borderBottomColor: "grey", borderBottomWidth: 1 }}></TextInput>
         <TextInput secureTextEntry={true}  placeholder="Password" style={{ borderBottomColor: "grey", borderBottomWidth: 1 }}></TextInput>
         <View style={{ marginTop: 10 }}>
           <Button title="Login"  
            onPress={ () => login() }
           ></Button>
         </View>
       </View>
     </>
   )
}

export default LoginPage;