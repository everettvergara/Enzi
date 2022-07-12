/**
 * Sample React Native App
 * https://github.com/facebook/react-native
 *
 * @format
 * @flow strict-local
 */

import React from 'react';
import LoginPage from './pages/LoginPage';
import {
  Image,
  LogBox,
  Text,
  View
} from 'react-native';

import { createDrawerNavigator,
  DrawerContentScrollView,
  DrawerItemList,
  DrawerItem, } from '@react-navigation/drawer';

import { NavigationContainer } from '@react-navigation/native';
import { createNativeStackNavigator } from '@react-navigation/native-stack';

import HomePage from './pages/HomePage';
import VisitationListPage from './pages/VisitationListPage';
import VisitationSubListPage from './pages/VisitationSubListPage';
import VisitationPage from './pages/VisitationPage';
import TrackerPage from './pages/TrackerPage';
import TestGPSPage from './pages/TestGPSPage';

import { StackActions } from '@react-navigation/native';
import { getHeaderTitle } from '@react-navigation/elements';
import IconButton from './components/IconButton';

const Stack = createNativeStackNavigator();
const Drawer = createDrawerNavigator();

import MainController from './controller/main';
import SystemSettingService from './service/system_setting';
import AppStateService from './service/app_state';
import NetInfoService from './service/net_info';
import { TouchableHighlight } from 'react-native-gesture-handler';
import MapViewPage from './pages/MapViewPage';
import UserController from './controller/user';
import GPSService from './service/gps';
import Config from './config/config';

try {
  MainController.load_database();
  SystemSettingService.init();
  AppStateService.init();
  NetInfoService.init();
}
catch (e) {
  console.log(e)
}

LogBox.ignoreLogs(['new NativeEventEmitter']); // Ignore log notification by message

const App = () => {

  return (
    <NavigationContainer>
      <Stack.Navigator screenOptions={{ presentation: "modal" }}>
        {/* <Stack.Screen name="Login" options={{ headerShown: false }} component={LoginPage}></Stack.Screen>
        <Stack.Screen name="Main" component={TZDrawer} options={{ headerShown: false }}>
        </Stack.Screen> */}
        <Stack.Screen name="Log In / Main" options={{ headerShown: false }} component={LoginMainNavigation}></Stack.Screen>
        <Stack.Screen name="Visitation Entry" component={VisitationPage}>
        </Stack.Screen>
        <Stack.Screen name="Map View" component={MapViewPage}>
        </Stack.Screen>
      </Stack.Navigator>
    </NavigationContainer>
  )
};

const LoginMainNavigation = ({ navigation }) => {

	let current_user = UserController.get_logged_in_user();

	React.useEffect(() => {

		if (current_user) {

			SystemSettingService.is_location_enabled()
        .then((location_enabled) => {
          if (location_enabled) GPSService.init();
        });
      
      Config.current_user.full_name = current_user.first_name + " " + current_user.last_name;
      Config.current_user = current_user;

      // will do synchronization later
      //SyncController.sync(Config.current_user.code, Config.current_user.device_imei, Config.current_user.api_token);

      navigation.dispatch(
        StackActions.replace('Main')
      );
		}
	}, []);

  return (<Stack.Navigator initialRouteName="Login">
    <Stack.Screen name="Login" options={{ headerShown: false }} component={LoginPage}></Stack.Screen>
    <Stack.Screen name="Main" component={TZDrawer} options={{ headerShown: false }}>
    </Stack.Screen>
  </Stack.Navigator>)
}

const TZDrawer = ({ navigation }) => {

  const screenOptions = { 
    header: ({ navigation, route, options }) => {
      const title = getHeaderTitle(options, route.name);
      return (
        <View style={[{ flexDirection: 'row', alignItems: 'center' }, options.headerStyle]}>
          <TouchableHighlight onPress={() => {
            navigation.dispatch(
              StackActions.replace("Main")
            )
          }}>
            <Image style={{ height: 40, width: 40, resizeMode: "contain" }} source={require('./assets/images/enzi.png')}>
            </Image>
          </TouchableHighlight>
          <Text onPress={() => {
            navigation.dispatch(
              StackActions.replace("Main")
            )
          }} style={{ fontWeight: "bold", flex: 1, fontSize: 20, marginLeft: 10, color: "black" }}>{ getHeaderTitle(options, route.name) }</Text>
          <IconButton onPress={ () => navigation.toggleDrawer() } iconSize={15} icon="bars" style={{ borderColor: "grey", borderRadius: 2, borderWidth: 1, width: 30, height: 30, color: "grey" }}>
          </IconButton>
        </View>
      )
    },
    headerStyle: {
      padding: 10
    }
  }

  const logout = () => {
    GPSService.disable();
    // will do the revocation of access token later
    UserController.update_log_in(Config.current_user.code, false, "", Config.current_user.is_manager);
    navigation.dispatch(
      StackActions.replace('Login')
    );
  }

  const CustomDrawerContent = (props) => {
    return (
      <DrawerContentScrollView {...props}>
        <DrawerItemList {...props} />
        <DrawerItem label="Log Out" onPress={() => logout()} />
      </DrawerContentScrollView>
    );
  }

  

  return (<Drawer.Navigator initialRouteName="Home" drawerContent={ (props) => <CustomDrawerContent {...props}></CustomDrawerContent> } screenOptions={screenOptions} >
    <Drawer.Screen name="Home" component={HomePage} />
    <Drawer.Screen name="Tracker" component={TrackerPage}  />
    <Drawer.Screen name="Visitation" component={VisitationListPage} />
    <Drawer.Screen name="Visitation Sub List" options={{ title: "Visitation", drawerItemStyle: {display: "none" }}} component={VisitationSubListPage} />
    <Drawer.Screen name="Test GPS" component={TestGPSPage} />
    <Drawer.Screen name="Settings" component={VisitationListPage} />
  </Drawer.Navigator>)
};

export default App;
