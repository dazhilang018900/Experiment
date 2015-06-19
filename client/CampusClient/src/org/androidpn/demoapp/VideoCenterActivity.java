package org.androidpn.demoapp;

import java.util.ArrayList;
import java.util.HashSet;
import java.util.List;
import java.util.Set;

import org.androidpn.client.Constants;
import org.androidpn.data.ContactAdapter;
import org.androidpn.server.model.App;
import org.androidpn.util.GetPostUtil;
import org.androidpn.util.MyWebViewClient;
import org.androidpn.util.Util;
import org.androidpn.util.Xmler;

import android.app.Activity;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.Button;
import android.widget.ListView;
import org.androidpn.demoapp.UserInfo;

import org.androidpn.demoapp.AppWebActivity;
public class VideoCenterActivity extends Activity {
	private static String LOGTAG="AppActivity";
	private String USERNAME;
	private String PASSWORD;
	private List<App> appList;
	private ContactAdapter adapter;
	private UserInfo userinfo;
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		USERNAME = getIntent().getStringExtra("userID");
		PASSWORD = getIntent().getStringExtra("Pwd"); 
		setContentView(R.layout.activity_contact);
		userinfo = (UserInfo) getApplication();
	  
		this.setContentView(R.layout.activity_center);
		final WebView VideoSite = (WebView)this.findViewById(R.id.webview_center);
		WebSettings webSettings = VideoSite.getSettings();
		webSettings.setSaveFormData(false);
		webSettings.setJavaScriptEnabled(true);
		webSettings.setSupportZoom(false);
		VideoSite.setWebViewClient(new MyWebViewClient());
		String url = this.getIntent().getExtras().getString("url");
		if(url!=null){
			VideoSite.loadUrl(url);
		}
	}
}

