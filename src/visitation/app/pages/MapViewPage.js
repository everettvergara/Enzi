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
import WebView from 'react-native-webview';

const MapViewPage = ({ navigation }) => {
 
   return (
      <WebView source={{ uri: 'https://www.google.com/maps/search/?api=1&query=luneta+park+manila' }} />
   )
}

export default MapViewPage;