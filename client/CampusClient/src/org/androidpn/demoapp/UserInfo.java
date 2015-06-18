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
	//��λ����Ϣ��Ϊȫ�ֱ���
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
	
	//λ�����ص�����
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
				//��Ӫ����Ϣ
				sb.append("\noperationers : ");
				sb.append(location.getOperators());
			}
//			logMsg(sb.toString());
			Log.i("BaiduLocationApiDem", sb.toString());
		}
	}
	
	
	//����֪ͨ�б�һ����ʼֵ����DemoAppActivity create��ʱ�����
	public void initUserInfo(){
		if (myNotifier.isEmpty()) {
			HashMap<String, String> addMap = new HashMap<String, String>();
		    addMap.put("ItemTitle", "����У԰��Ϣ����ϵͳ");
		    addMap.put("ItemMessage", "������ѧ�����о���Ժ|ͨ������Ϣ��ȫʵ����\n\n���ܣ�������Ŀ��Ϣ������������Ϣ���ۿ���Ƶ���ۿ�ֱ��\n\nTips��\n��½��ʹ����http://push.pkusz.edu.cn��ע����û��������롣\n����ҳ�棬��ѡ���ύ������ȡ�����ģ�\n��Ƶֱ����������ֱ����Ƶ�������û���_��Ƶ���ƣ��ݲ����ţ�");
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
