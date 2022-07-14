import React from 'react';
import FontAwesome from "react-native-vector-icons/FontAwesome";
import DatePicker from 'react-native-date-picker'
import dateFormat, { masks } from "dateformat";
import IconButton from '../components/IconButton';

import {
   ScrollView,
   Text,
   Switch,
   Image,
   View,
   SafeAreaView,
 } from 'react-native';
import { useFocusEffect } from '@react-navigation/native';
import TrackerController from '../controller/tracker';
import Config from '../config/config';

const TrackerPage = ({ navigation }) => {

  const [user, setUser] = React.useState('');

  const [dateFrom, setDateFrom] = React.useState(new Date());
  const [openedDateFrom, openDateFrom] = React.useState(false);
  const [dateTo, setDateTo] = React.useState(new Date());
  const [openedDateTo, openDateTo] = React.useState(false);
  const [toggleCheckBox, setToggleCheckBox] = React.useState(false);

  const [trackerdata, set_trackerdata] = React.useState([]);

  useFocusEffect(React.useCallback(() => {
    load_tracker();
  }, []));

  const load_tracker = () => {
    TrackerController.load_tracker(dateFormat(dateFrom, "yyyy-mm-dd"), dateFormat(dateTo, "yyyy-mm-dd"), Config.current_user.api_token)
    .then(d => {
      console.log(d);
      set_trackerdata(d);
    })
    .catch(e => console.log(e));
  };

  const data = [
    {
      id: 1,
      date: '2022-01-01',
      customers: [
        {
          id: 1,
          name: "Philip Morris",
          visited_time: "1:00 AM",
          geolocated_visit_address: "Malanday, Valenzuela",
          coords: [
            {
              id: 1,
              lat: 14.2393945,
              lng: 121.395758,
              timestamp: "12:00 AM",
              address: "Malanday, Valenzuela"
            },
            {
              id: 2,
              lat: 14.234234,
              lng: 121.51983,
              timestamp: "12:30 AM",
              address: "Brgy. 14, Caloocan City"
            },
            {
              id: 3,
              lat: 14.2985741,
              lng: 121.93495,
              timestamp: "1:00 AM",
              address: "Monumento, Caloocan City"
            },
          ]
        },
        {
          id: 2,
          name: "Gaius Julius Caesar",
          visited_time: "3:00 AM",
          geolocated_visit_address: "Monumento, Caloocan",
          coords: [
            {
              id: 4,
              lat: 14.93972815,
              lng: 121,
              timestamp: "2:00 AM",
              address: "Monumento, Caloocan City"
            },
            {
              id: 5,
              lat: 14.38437,
              lng: 121.397322,
              timestamp: "2:30 AM",
              address: "Blumentritt, Maynila"
            },
            {
              id: 6,
              lat: 14,
              lng: 121,
              timestamp: "3:00 AM",
              address: "Sta. Mesa, Manila"
            },
          ]
        },
        {
          id: 3,
          name: "Dmitry Sukhoyev",
          visited_time: "5:00 AM",
          geolocated_visit_address: "Sta. Mesa, Maynila",
          coords: [
            {
              id: 7,
              lat: 14.283872,
              lng: 121.38374,
              timestamp: "4:00 AM",
              address: "Sta. Mesa, Maynila"
            },
            {
              id: 8,
              lat: 14.383722,
              lng: 121.197501,
              timestamp: "4:30 AM",
              address: "Legarda-Recto, Maynila"
            },
            {
              id: 9,
              lat: 14.3287201,
              lng: 121.010183,
              timestamp: "5:00 AM",
              address: "Pureza St. Maynila"
            },
          ]
        }
      ]
    },
    {
      id: 2,
      date: '2022-01-02',
      customers: [
        {
          id: 4,
          name: "Kim Yeonji",
          visited_time: "7:00 AM",
          geolocated_visit_address: "Matandang Balara, Quezon City",
          coords: [
            {
              id: 10,
              lat: 14.218821,
              lng: 121.3838,
              timestamp: "6:00 AM",
              address: "Matandang Balara, Quezon City"
            },
            {
              id: 11,
              lat: 14.89282,
              lng: 121.9919,
              timestamp: "6:30 AM",
              address: "SM Fairview, QC"
            },
            {
              id: 12,
              lat: 14.90981,
              lng: 121.93922,
              timestamp: "7:00 AM",
              address: "Pangarap, Caloocan City"
            },
          ]
        },
        {
          id: 5,
          name: "Candace Greater",
          visited_time: "9:00 AM",
          geolocated_visit_address: "Pangarap, Caloocan City",
          coords: [
            {
              id: 12,
              lat: 14.881,
              lng: 121.383,
              timestamp: "8:00 AM",
              address: "Pangarap, Caloocan City"
            },
            {
              id: 13,
              lat: 14.010,
              lng: 121.992,
              timestamp: "8:30 AM",
              address: "Ortigas Pasig"
            },
            {
              id: 14,
              lat: 14.989181,
              lng: 121.9282,
              timestamp: "9:00 AM",
              address: "Alabang, Muntinlupa"
            },
          ]
        },
        {
          id: 6,
          name: "Julius Salangsang",
          visited_time: "11:00 AM",
          geolocated_visit_address: "Alabang, Muntinlupa",
          coords: [
            {
              id: 15,
              lat: 14.938282,
              lng: 121.938322,
              timestamp: "10:00 AM",
              address: "Alabang, Muntinlupa"
            },
            {
              id: 16,
              lat: 14.983822,
              lng: 121.988733,
              timestamp: "10:30 AM",
              address: "Ortigas Pasig"
            },
            {
              id: 17,
              lat: 14.883922,
              lng: 121.908918,
              timestamp: "11:00 AM",
              address: "Cainta Rizal"
            },
          ]
        }
      ]
    },
    {
      id: 3,
      date: '2022-01-03',
      customers: [
        {
          id: 7,
          name: "Somsrey Phan",
          visited_time: "1:00 PM",
          geolocated_visit_address: "Cainta, Rizal",
          coords: [
            {
              id: 18,
              lat: 14.9832,
              lng: 121.98181,
              timestamp: "11:00 AM",
              address: "Cainta Rizal"
            },
            {
              id: 19,
              lat: 14.89301,
              lng: 121.83722,
              timestamp: "11:30 AM",
              address: "Ortigas Pasig"
            },
            {
              id: 20,
              lat: 14.983872,
              lng: 121.93829,
              timestamp: "12:00 PM",
              address: "BGC Taguig"
            },
          ]
        },
        {
          id: 8,
          name: "Nguyen Spring",
          check_out_time: "3:00 PM",
          geolocated_check_out_address: "SJDm Bulacna",
          coords: [
            {
              id: 21,
              lat: 14.893822,
              lng: 121.39202,
              timestamp: "3:00 PM",
              address: "SJDM Bulacan"
            },
            {
              id: 22,
              lat: 14.39223,
              lng: 121.19892,
              timestamp: "3:00 PM",
              address: "Marikina"
            },
            {
              id: 23,
              lat: 14.39829,
              lng: 121.3922,
              timestamp: "4:00 PM",
              address: "Taguig"
            },
          ]
        },
        {
          id: 9,
          name: "Conrado Tutro",
          visited_time: "4:00 PM",
          geolocated_visit_address: "Taguig",
          coords: [
            {
              id: 24,
              lat: 14.2342,
              lng: 121.211,
              timestamp: "4:00 PM",
              address: "Taguig"
            },
            {
              id: 25,
              lat: 14.322,
              lng: 121.9911,
              timestamp: "4:30 PM",
              address: "Pateros"
            },
            {
              id: 26,
              lat: 14.93892,
              lng: 121.3494,
              timestamp: "5:00 PM",
              address: "Skyway"
            },
          ]
        }
      ]
    }
  ];

  const TrackerDataDetailRow = (({ coord }) => {
    return (
      <View>
        <View style={{ paddingVertical: 5 }}>
          <View style={{ flexDirection: 'row', paddingVertical: 5 }}>
            <View style={{flex: 1}}>
              {
                coord.text ? <Text>{ coord.text }</Text>: <></>
              }
              <Text>
              {
                "(" + coord.lat + ", " + coord.lng + ")"
              }
              </Text>
              {
                coord.address ? <Text>{ coord.address }</Text> : <></>
              }
              
            </View>
            <Text style={{ width: 80, textAlign: 'right', textDecorationLine: "underline", color: "blue" }} onPress={() => navigation.navigate("Map View")}>{ dateFormat(coord.datetime, "hh:MM TT") }</Text>
          </View>
        </View>
      </View>
      
    );
  })

  const TrackerDataRow = ({ trackerdatum }) => {
    const [collapsed, setCollapsed] = React.useState(true);

    return (
      <View style={{ padding: 5, paddingVertical: 10 }}>
        <View style={{ flexDirection: "row", alignItems: 'center' }}>
          <View style={{ flex: 5 }}>
            <Text style={{ fontWeight: "bold", fontSize: 16 }}>{ dateFormat(trackerdatum.date, 'yyyy-mm-dd') }</Text>
            {
              trackerdatum.remarks && trackerdatum.remarks != "" ? 
                <Text style={{ fontSize: 16 }}>{ trackerdatum.remarks }</Text>: <></>
            }
            <Text style={{ fontSize: 16 }}>{ trackerdatum.name }</Text>
          </View>
          <View style={{ marginLeft: 15 }} >
            <FontAwesome size={20} onPress={ () => { setCollapsed(!collapsed) }} name={ collapsed?"chevron-up":"chevron-down"}></FontAwesome>
          </View>
        </View>
        <View style={{ display: collapsed ? "flex": "none" }}>
        {
          trackerdatum.coords ? trackerdatum.coords.map((coord, i) => {
            return <TrackerDataDetailRow coord={coord} key={i}></TrackerDataDetailRow>
          }): <></>
        }
        </View>
      </View>
    );
  }

  return (
    <SafeAreaView style={{ flexDirection: "column", flex: 1 }}>
      <View style={{ padding: 10, flexDirection: "row" }}>
        <View style={{flex: 1}}>
          <View style={{ flexDirection: "row" }}>
            <View style={{ flex: 1, padding: 5 }}>
              <Text style={{ fontSize: 10 }}>Date From</Text>
              <View style={{ fontSize: 15, borderBottomColor: "grey", borderBottomWidth: 1, flexDirection: "row" }}>
                <Text onPress={() => openDateFrom(true)} style={{ flex: 1, color: "black" }}>{ dateFormat(dateFrom, "yyyy mmm d") }</Text>
                <FontAwesome name='calendar' onPress={() => openDateFrom(true)} color="#0000c0" style={{ fontSize: 15 }}></FontAwesome>
              </View>
            </View>
            <View style={{ flex: 1, padding: 5 }}>
              <Text style={{ fontSize: 10 }}>Date To</Text>
              <View style={{ fontSize: 15, borderBottomColor: "grey", borderBottomWidth: 1, flexDirection: "row" }}>
                <Text onPress={() => openDateTo(true)} style={{ flex: 1, color: "black" }}>{ dateFormat(dateTo, "yyyy mmm d") }</Text>
                <FontAwesome name='calendar' onPress={() => openDateTo(true)} color="#0000c0" style={{ fontSize: 15 }}></FontAwesome>
              </View>
            </View>
          </View>
        </View>

        <View>
          <IconButton iconSize={20} onPress={() => {
            load_tracker();
          }} style={{ margin: 5, backgroundColor: "#0f7fff", borderRadius: 2, padding: 5, marginHorizontal: 3, width: 40, height: 40, color: "white" }} title="Search" icon="search"></IconButton>
        </View>

        <DatePicker
          modal
          mode="date"
          open={openedDateFrom}
          date={dateFrom}
          onConfirm={(date) => {
            openDateFrom(false)
            setDateFrom(date)
          }}
          onCancel={() => {
            openDateFrom(false)
          }}
         ></DatePicker>

        <DatePicker
          modal
          mode="date"
          open={openedDateTo}
          date={dateTo}
          onConfirm={(date) => {
            openDateTo(false)
            setDateTo(date)
          }}
          onCancel={() => {
            openDateTo(false)
          }}
        ></DatePicker>
      </View>
      <ScrollView style={{ padding: 10, flex: 1 }}>
      {
        trackerdata.map((trackerdatum) => {
          return (
            <TrackerDataRow trackerdatum={trackerdatum} key={trackerdatum.id}>
            </TrackerDataRow>
          );
        })
      }
      </ScrollView>
    </SafeAreaView>
  );

  return (
    <ScrollView>

      <View style={{ padding: 10, borderBottomColor: "grey", flexDirection: "row", borderBottomWidth: 1 }}>
        <View style={{flex: 1}}>
          <View style={{ flexDirection: "row" }}>
            <View style={{ flex: 1, padding: 5 }}>
              <Text style={{ fontSize: 10 }}>Date From</Text>
              <View style={{ fontSize: 15, borderBottomColor: "grey", borderBottomWidth: 1, flexDirection: "row" }}>
                <Text onPress={() => openDateFrom(true)} style={{ flex: 1, color: "black" }}>{ dateFormat(dateFrom, "yyyy mmm d") }</Text>
                <FontAwesome name='calendar' onPress={() => openDateFrom(true)} color="#0000c0" style={{ fontSize: 15 }}></FontAwesome>
              </View>
            </View>
            <View style={{ flex: 1, padding: 5 }}>
              <Text style={{ fontSize: 10 }}>Date To</Text>
              <View style={{ fontSize: 15, borderBottomColor: "grey", borderBottomWidth: 1, flexDirection: "row" }}>
                <Text onPress={() => openDateTo(true)} style={{ flex: 1, color: "black" }}>{ dateFormat(dateTo, "yyyy mmm d") }</Text>
                <FontAwesome name='calendar' onPress={() => openDateTo(true)} color="#0000c0" style={{ fontSize: 15 }}></FontAwesome>
              </View>
            </View>
          </View>
        </View>
        <View>
          <IconButton iconSize={20} style={{ margin: 5, backgroundColor: "#0f7fff", borderRadius: 2, padding: 5, marginHorizontal: 3, width: 40, height: 40, color: "white" }} title="Search" icon="search"></IconButton>
        </View>

        <DatePicker
           modal
           mode="date"
           open={openedDateFrom}
           date={dateFrom}
           onConfirm={(date) => {
             openDateFrom(false)
             setDateFrom(date)
           }}
           onCancel={() => {
             openDateFrom(false)
           }}
         ></DatePicker>

        <DatePicker
           modal
           mode="date"
           open={openedDateTo}
           date={dateTo}
           onConfirm={(date) => {
             openDateTo(false)
             setDateTo(date)
           }}
           onCancel={() => {
             openDateTo(false)
           }}
        ></DatePicker>
      </View>
      <View style={{ padding: 10 }}>
        {
          data.map((date) => {
            const [collapsed, setCollapsed] = React.useState(true);
            return (
              <View style={{ borderBottomColor: "grey", padding: 5, paddingVertical: 10, borderBottomWidth: 1 }} key={date.id}>
                <View style={{ flexDirection: "row", alignItems: 'center' }}>
                  <View style={{ flex: 5 }}>
                      <Text style={{ fontWeight: "bold", fontSize: 16 }}>{ date.date }</Text>
                  </View>
                  <View style={{ marginLeft: 15 }} >
                      <FontAwesome size={20} onPress={ () => { setCollapsed(!collapsed) }} name={ collapsed?"chevron-up":"chevron-down"}></FontAwesome>
                  </View>
                </View>
                <View style={{ display: collapsed ? "flex": "none" }}>
                {
                  date.customers.map((cust) => {
                    const [coordCollapsed, setCoordCollapsed] = React.useState(true);
                    const [coord2Collapsed, setCoord2Collapsed] = React.useState(true);
                    return (
                      <View key={cust.id}>
                        <View style={{ paddingVertical: 5, borderBottomColor: "#ddd", borderBottomWidth: 1 }}>
                          <View style={{ flexDirection: "row", alignItems: "center" }}>
                            <Text style={{ fontWeight: "bold", flex: 1 }}>{ cust.name }</Text>
                            <FontAwesome size={15} onPress={ () => { setCoordCollapsed(!coordCollapsed) }} name={ coordCollapsed?"chevron-up":"chevron-down"}></FontAwesome>
                          </View>
                          <View style={{ display: coordCollapsed ? "flex": "none" }}>
                            <View style={{ flexDirection: 'row' }}>
                              <Text style={{flex: 1}}>
                                <Text>Visited </Text>
                                <Text style={{ color: "black" }}>{ cust.geolocated_visit_address }</Text>
                              </Text>
                              <Text style={{ width: 80, textAlign: 'right', textDecorationLine: "underline", color: "blue" }} onPress={() => navigation.navigate("Map View")}>{ cust.visited_time }</Text>
                            </View>
                          </View>
                           
                        </View>
                        <View style={{ paddingVertical: 5, borderBottomColor: "#ddd", borderBottomWidth: 1 }}>
                          <View style={{ flexDirection: "row", alignItems: "center" }}>
                            <Text style={{ fontWeight: "bold", flex: 1 }}>Location</Text>
                            <FontAwesome size={15} onPress={ () => { setCoord2Collapsed(!coord2Collapsed) }} name={ coord2Collapsed?"chevron-up":"chevron-down"}></FontAwesome>
                          </View>

                          <View style={{ display: coord2Collapsed ? "flex": "none" }}>
                          {
                            cust.coords.map((coord) => {
                              return (
                                <View key={coord.id} style={{ flexDirection: 'row' }}>
                                  <Text style={{ flex: 1 }}>{coord.address}</Text>
                                  <Text style={{ width: 80, textAlign: 'right', textDecorationLine: "underline", color: "blue" }} onPress={() => navigation.navigate("Map View")}>{ coord.timestamp }</Text>
                                </View>
                              )
                            })
                          }
                          </View>
                          
                        </View>
                      </View>
                      
                    );
                  })
                }
                </View>
                
                
              </View>
            );
          })
        }
      </View>
    </ScrollView>
  );
};

export default TrackerPage;