package org.androidpn.demoapp;

import java.util.ArrayList;
import java.util.HashSet;
import java.util.List;
import java.util.Set;

import org.androidpn.client.Constants;
import org.androidpn.data.ContactAdapter;
import org.androidpn.server.model.App;
import org.androidpn.util.GetPostUtil;
import org.androidpn.util.Util;
import org.androidpn.util.Xmler;

import android.app.Activity;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.AdapterView;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.EditText;
import android.widget.RadioGroup;
import android.widget.TextView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.RadioGroup.OnCheckedChangeListener;
import android.widget.ListView;
import org.androidpn.demoapp.UserInfo;

import org.androidpn.demoapp.AppWebActivity;

//import com.baidu.baidulocationdemo.WebActivity.GetOnListener;
//import com.baidu.baidulocationdemo.WebActivity.WaitListener;
//import com.baidu.baidulocationdemo.LocationApplication;
//import com.baidu.baidulocationdemo.R;
//import com.baidu.baidulocationdemo.LocationActivity;
//import com.baidu.baidulocationdemo.LocationApplication;
//import com.baidu.baidulocationdemo.R;
//import com.baidu.baidulocationdemo.WebActivity;
//import com.baidu.baidulocationdemo.LocationActivity.MyButtonListener;
import com.baidu.location.BDLocation;
import com.baidu.location.LocationClient;
import com.baidu.location.LocationClientOption;
import com.baidu.location.LocationClientOption.LocationMode;

public class BusActivity extends Activity {
	private String url;
	private String name;
	private double longitude;
    private double latitude;
    private Button getOnBtn;
	private Button getOffBtn;
	private WebView myWebView = null;
	private LocationClient mLocationClient;
	private BDLocation myloc;
	private TextView LocationResult,ModeInfor;
	private Button startLocation;
	private Button sendLocation;
	private RadioGroup selectMode,selectCoordinates;
	private EditText frequence;
	//gps的设置采用默认数值就可以了。
	private LocationMode tempMode = LocationMode.Hight_Accuracy;
	private String tempcoor="gcj02";
	private CheckBox checkGeoLocation;
	
	
	@Override
	//在这里自动开启gps功能
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.web_surf);
		
		
		 url = getIntent().getStringExtra("url");
		 name = getIntent().getStringExtra("userName");
		 Log.e("linhc",name+"    林汉尺 ");
		 url += "/index.php?nick="+name;
		 
		 myloc = ((UserInfo)getApplication()).mylocation;
		 getOnBtn = (Button)findViewById(R.id.on);
	     getOffBtn =(Button)findViewById(R.id.off);
	     longitude = myloc.getLongitude();
	     latitude = myloc.getLatitude();
	     myWebView = (WebView)findViewById(R.id.webview_linhc);
		
	     myWebView.setWebViewClient(new MyWebViewClient());
	     
		mLocationClient = ((UserInfo)getApplication()).mLocationClient;
		
		getOnBtn.setOnClickListener(new GetOnListener());
        getOffBtn.setOnClickListener(new WaitListener());
		
		InitLocation();
		
		
		Log.e("linhc","初始化");
		
		startLocation = (Button)findViewById(R.id.gps);
		
		Log.e("linhc","初始化3");
		startLocation.setOnClickListener(new OnClickListener() {		
			@Override   //点击按键之后开启gps服务
			public void onClick(View v) {
				// TODO Auto-generated method stub					
				if(startLocation.getText().equals(getString(R.string.startlocation))){
					mLocationClient.start();
					startLocation.setText(getString(R.string.stoplocation));
				}else{
					mLocationClient.stop();
					startLocation.setText(getString(R.string.startlocation));
				}				
			}
		});	
		
//		Log.e("linhc","初始化2");
        myWebView.loadUrl(url);// 
	}
	@Override
	protected void onStop() {
		// TODO Auto-generated method stub
		mLocationClient.stop();
		super.onStop();
	}	
	
	
	private void InitLocation(){
		LocationClientOption option = new LocationClientOption();
		option.setLocationMode(tempMode);//设置定位模式
		option.setCoorType(tempcoor);//返回的定位结果是百度经纬度，默认值gcj02
		int span=1000;
		Log.e("linhc","初始化代码出错了吗？");
		option.setScanSpan(span);//设置发起定位请求的间隔时间为5000ms
//		option.setIsNeedAddress(checkGeoLocation.isChecked());
		mLocationClient.setLocOption(option);
		//初始化的时候就开始定位服务吧！
		mLocationClient.start();
	}
	private class GetOnListener implements OnClickListener {  
	  	  
        public void onClick(View arg0) {  
            // TODO Auto-generated method stub  
        	longitude = myloc.getLongitude();
            latitude = myloc.getLatitude();
        	String new_url = url +"&longitude="+longitude+"&latitude="+latitude+"&action=on";
        	myWebView.loadUrl(new_url);
        }  
  
    }
    private class WaitListener implements OnClickListener {  
    	  
        public void onClick(View arg0) {  
            // TODO Auto-generated method stub  
        	longitude = myloc.getLongitude();
            latitude = myloc.getLatitude();
            String new_url = url +"&longitude="+longitude+"&latitude="+latitude+"&action=wait";
        	myWebView.loadUrl(new_url);
        }  
  
    }
    //重载函数，使用内置浏览器
    private class MyWebViewClient extends WebViewClient{ 

        //重写shouldOverrideUrlLoading方法，使点击链接后不使用其他的浏览器打开。 

     @Override 

     public boolean shouldOverrideUrlLoading(WebView view, String url) { 

         view.loadUrl(url); 

         return true; 

     }
    }
	
}