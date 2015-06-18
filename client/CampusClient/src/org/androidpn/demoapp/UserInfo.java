package org.androidpn.demoapp;

import java.util.ArrayList;
import java.util.HashMap;
import android.app.Application;

import com.baidu.location.BDLocationListener;
//import com.baidu.baidulocationdemo.LocationApplication.MyLocationListener;
import com.baidu.location.BDLocation;
import com.baidu.location.BDLocationListener;
import com.baidu.location.GeofenceClient;
import com.baidu.location.LocationClient;
import android.app.Application;
import android.app.Service;
import android.os.Vibrator;
import android.util.Log;
import android.widget.TextView;


public class UserInfo extends Application {

	
//	public LocationClient mLocationClient;
//	public GeofenceClient mGeofenceClient;
//	public MyLocationListener mMyLocationListener;
//	
//	public TextView mLocationResult,logMsg;
//	public TextView trigger,exit;
//	public Vibrator mVibrator;
	//把位置信息作为全局变量
	public LocationClient mLocationClient;
	public BDLocation mylocation;
	public MyLocationListener mMyLocationListener;
	private String myUserName;
	private String myUserPWD;
	private String myNotifierTitle;
	private String myNotifierMessage;
	private String myNotifierUri;
	private ArrayList<HashMap<String, String>> myNotifier = new ArrayList<HashMap<String,String>>();
	public TextView mLocationResult;	
	
	@Override
	public void onCreate() {
		super.onCreate();
		mLocationClient = new LocationClient(this.getApplicationContext());
		mMyLocationListener = new MyLocationListener();
		mLocationClient.registerLocationListener(mMyLocationListener);
		mylocation = new BDLocation();
	}
	
	//位置侦查回调函数
	public class MyLocationListener implements BDLocationListener {

		@Override
		public void onReceiveLocation(BDLocation location) {
			mylocation = location;
			//Receive Location 
			StringBuffer sb = new StringBuffer(256);
			sb.append("time : ");
			sb.append(location.getTime());
			sb.append("\nerror code : ");
			sb.append(location.getLocType());
			sb.append("\nlatitude : ");
			sb.append(location.getLatitude());
			sb.append("\nlontitude : ");
			sb.append(location.getLongitude());
			sb.append("\nradius : ");
			sb.append(location.getRadius());
			if (location.getLocType() == BDLocation.TypeGpsLocation){
				sb.append("\nspeed : ");
				sb.append(location.getSpeed());
				sb.append("\nsatellite : ");
				sb.append(location.getSatelliteNumber());
				sb.append("\ndirection : ");
				sb.append("\naddr : ");
				sb.append(location.getAddrStr());
				sb.append(location.getDirection());
			} else if (location.getLocType() == BDLocation.TypeNetWorkLocation){
				sb.append("\naddr : ");
				sb.append(location.getAddrStr());
				//运营商信息
				sb.append("\noperationers : ");
				sb.append(location.getOperators());
			}
//			logMsg(sb.toString());
			Log.i("BaiduLocationApiDem", sb.toString());
		}
	}
	
	
	//赋给通知列表一个初始值，在DemoAppActivity create的时候加载
	public void initUserInfo(){
		if (myNotifier.isEmpty()) {
			HashMap<String, String> addMap = new HashMap<String, String>();
		    addMap.put("ItemTitle", "关于校园信息服务系统");
		    addMap.put("ItemMessage", "北京大学深圳研究生院|通信与信息安全实验室\n\n功能：订阅栏目消息、接收推送消息、观看视频、观看直播\n\nTips：\n登陆请使用在http://push.pkusz.edu.cn上注册的用户名和密码。\n订阅页面，不选中提交，代表取消订阅；\n视频直播，发布的直播视频名称是用户名_视频名称（暂不开放）");
		    addMap.put("ItemUri", "http://push.pkusz.edu.cn");
		    this.myNotifier.add(addMap);    
		}

	}

	
	public void addMyNotifier(HashMap<String, String> addMap){
		this.myNotifier.add(0,addMap);
	}

	public ArrayList<HashMap<String, String>> getMyNotifier() {
		return myNotifier;
	}

	public void setMyNotifier(ArrayList<HashMap<String, String>> myNotifier) {
		this.myNotifier = myNotifier;
	}

	public String getMyNotifierTitle(){
		return myNotifierTitle;
	}
	
	public void setMyNotifierTitle(String myNotifierTitle){
		this.myNotifierTitle = myNotifierTitle;
	}
	
	public String getMyNotifierMessage(){
		return myNotifierMessage;
	}
	
	public void setMyNotifierMessage(String myNotifierMessage){
		this.myNotifierMessage = myNotifierMessage;
	}
	
	public String getMyNotifierUri(){
		return myNotifierUri;
	}
	
	public void setMyNotifierUri(String myNotifierUri){
		this.myNotifierUri = myNotifierUri;
	}
	
	public String getMyUserName() {
		return myUserName;
	}
	public void setMyUserName(String myUserName) {
		this.myUserName = myUserName;
	}
	public String getMyUserPWD() {
		return myUserPWD;
	}
	public void setMyUserPWD(String myUserPWD) {
		this.myUserPWD = myUserPWD;
	}
	
	
}
