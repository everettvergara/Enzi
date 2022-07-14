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
import UserController from '../controller/user';
import SystemSettingService from '../service/system_setting';
import Config from '../config/config';
import SyncController from '../controller/sync';

const LoginPage = ({ navigation }) => {

  const [user_code, set_user_code] = React.useState("");
	const [password, set_password] = React.useState("");
	const [logging_in, is_logging_in] = React.useState(false);

    const login = () => {

      is_logging_in(true);

      if (user_code == "" || password == "") {
        alert ("Username or password required");
        is_logging_in(false);
      }
      else {
        UserController.login(user_code, password)
        .then(json => {
          console.log(json, "this is returned by create_token")

          if (json.status == "Failed") {
            is_logging_in(false);
            throw new Error("User login failure");
          }
          else {

            SystemSettingService.is_location_enabled()
              .then((location_enabled) => {
                if (location_enabled) GPSService.init();
              });

            let user_to_login = UserController.get_by_user_code(user_code);

            json.data.is_logged_in = true;
            json.data.full_name = json.data.first_name + " " + json.data.last_name;

            if (user_to_login) {
              UserController.update_log_in(user_code, true, json.token);
            }
            else {
              UserController.insert_current_user(json.data);
            }
              
            Config.current_user = json.data;

            is_logging_in(false);

            SyncController.sync_sys_logs(Config.current_user.api_token)
            .then(() => {

            })
            .catch((e) => {
              console.log(e, "dskojf");
              alert("Failure to synchronize");
            })

            navigation.dispatch(
                StackActions.replace('Main')
            );
          }
        })
        .catch((error) => {
          alert (error.message);
          console.log(error)
          is_logging_in(false);

          
        });
        
      }

      
    }
 
   return (
     <>
       <Image style={{ width: "100%", height: 100, resizeMode: "contain" }} source={require('../assets/images/enzi.png')}>
       </Image>
       <Text style={{ fontWeight: "bold", fontSize: 30, marginVertical: 10, textAlign: "center", color: "black" }}>Field Work</Text>
       <View style={{ padding: 10 }}>
         <TextInput placeholder="Username" onChangeText={set_user_code} style={{ borderBottomColor: "grey", borderBottomWidth: 1 }}></TextInput>
         <TextInput secureTextEntry={true} onChangeText={set_password} placeholder="Password" style={{ borderBottomColor: "grey", borderBottomWidth: 1 }}></TextInput>
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