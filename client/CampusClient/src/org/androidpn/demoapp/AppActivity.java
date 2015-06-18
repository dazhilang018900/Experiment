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
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ListView;
import org.androidpn.demoapp.UserInfo;

import org.androidpn.demoapp.AppWebActivity;
public class AppActivity extends Activity {
	private static String LOGTAG="AppActivity";
	private String USERNAME;
	private String PASSWORD;
	private List<App> appList;
	private ContactAdapter adapter;
	private UserInfo userinfo;
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		USERNAME = getIntent().getStringExtra("userID");
		PASSWORD = getIntent().getStringExtra("Pwd");//
		setContentView(R.layout.activity_contact);
		userinfo = (UserInfo) getApplication();
		if(Constants.appList!=null){
			appList=Constants.appList;
		}
		else{
			appList=new ArrayList<App>();
			getApps();//asyn
		}
		if(Constants.subApps==null){
			getSubApps();
		}
		
		ListView appView = (ListView) this.findViewById(R.id.ContactListView);
		adapter=new ContactAdapter(this,(List) appList);
		appView .setAdapter(adapter);
		appView .setOnItemClickListener(new OnItemClickListener(){
			@Override
			public void onItemClick(AdapterView<?> arg0, View arg1, int arg2,
					long arg3) {
				
				// TODO Auto-generated method stub
				//Log.i(LOGTAG,"item "+arg2+" clicked");
				//Util.alert(AppActivity.this,arg2+" clicked");		
				App u=(App)arg0.getAdapter().getItem(arg2);
				//Util.alert(AppActivity.this,u.getStr()+":"+u.getUrl());
				 
				if(u==null){
					Util.alert(AppActivity.this, "״̬�쳣");
					AppActivity.this.finish();
					return;
				}
				if(u!=null&&u.getName()!=null&&u.getUrl()!=""){
					//Log.i(LOGTAG,u.getStr());
					//��ȡapp����
					String appname = u.getName();
//					Log.i("���Ӧ������",appname);
//					Log.d("linhanchi_test", appname);
//					if(appname.equals("b736")){
//						Util.alert(AppActivity.this,"yes");
//					}else{
//						Util.alert(AppActivity.this,"b736"+appname);
//					}
//					Util.alert(AppActivity.this,appname);
					if(appname.equals("b736")){
						//����ٶȵ�ͼapp
						Intent it=new Intent(AppActivity.this,BusActivity.class);
						Bundle bundle=AppActivity.this.getIntent().getExtras();
						it.putExtras(bundle);
						String userName = userinfo.getMyUserName();
						it.putExtra("userName", userName);
						it.putExtra("appName", u.getName());
						it.putExtra("url", u.getUrl());
//						Log.e("linhc","���ڿ��Խ��밡!");
						startActivityForResult(it,0);
					}else{
					Intent it=new Intent(AppActivity.this,AppWebActivity.class);
					//Util.alert(AppActivity.this,"start appwebactivity");
					Bundle bundle=AppActivity.this.getIntent().getExtras();
					it.putExtras(bundle);
					
//					��ȡ�û�����
					
//					String userName = UserInfo.class.;
					String userName = userinfo.getMyUserName();
					it.putExtra("userName", userName);
					it.putExtra("appName", u.getName());
					it.putExtra("url", u.getUrl());
//					Util.alert(AppActivity.this,it.getStringExtra("userID")+":"+
//							":"+it.getStringExtra("appName")+":"+it.getStringExtra("url"));
					startActivityForResult(it,0);
					}
				}else{
					Util.alert(AppActivity.this, "��Ӧ����Ч");
				}
			}
		});
	}
	
	
	
	/**===============================================================
	 * ��ȡӦ���б�,��ӵ�applist����ʾ����
	 * ===============================================================
	 */
	private void getApps(){
		if(Constants.appList!=null) return;
		StringBuilder params = new StringBuilder();
		params.append("action=listApps&username="+USERNAME); //
		new AsyncTask<StringBuilder, Integer, String>() {
			@Override
			protected String doInBackground(StringBuilder... parameter) {
				/*--End--*/
				String resp = GetPostUtil.send("POST",
						getString(R.string.androidpnserver) + "subscriptions.do",
						parameter[0]);
				return resp;
			}

			@Override
			protected void onPostExecute(String resp) {
				Log.i(LOGTAG,"getApps:"+resp);
				if (!"succeed".equals( Util.getXmlElement(resp, "result"))) {
					Util.alert(AppActivity.this, "��ȡӦ���б�ʧ��:"+resp);
					return;
				}else {
					int i = resp.indexOf("<list>"), j;
					if (i < 0 || (j = resp.indexOf("</list>")) < 0) {
						Util.alert(AppActivity.this,"û���ҵ�Ӧ��");//"</list>"
						appList = Constants.appList = new ArrayList();
					} 
					else {
						String str = resp.substring(i, j + 7);
						Xmler.getInstance().alias("app", App.class);
						List<App> list = (List) Xmler.getInstance().fromXML(str);

						if (list == null) {
							Util.alert(AppActivity.this, "Ӧ���б�Ϊ��");
							return;
						}else{
							//Util.alert(AppActivity.this, "Ӧ���б��Ѿ�����,��ǰ������"+list.size()+"��app");
							for(App app:list){
								if(app.getUrl()!="")
									appList.add(app);
							}
							Constants.appList = appList;
							if(adapter!=null)//��ʾ����
								adapter.notifyDataSetChanged();
						}
					}
				}
			}
		}.execute(params);
	}
	
	private void getSubApps(){
		if(Constants.subApps!=null) return;//�����б�ǿ�
		
		StringBuilder params = new StringBuilder();
		params.append("action=getSubs&username="+USERNAME); //attention:don't add ? in front
		new AsyncTask<StringBuilder, Integer, String>() {
			@Override
			protected String doInBackground(StringBuilder... parameter) {
				/*--End--*/
				String resp = GetPostUtil.send("POST",
						getString(R.string.androidpnserver) + "/subscriptions.do",
						parameter[0]);
				return resp;
			}

			@Override
			protected void onPostExecute(String resp) {
				Log.i(LOGTAG,"getApps:"+resp);
				//Util.alert(AppActivity.this, "��ȡ�����б�:"+resp);
				if (!"succeed".equals( Util.getXmlElement(resp, "result"))) {
					return;
				}else {
					int i = resp.indexOf("<list>"), j;
					if (i < 0 || (j = resp.indexOf("</list>")) < 0) {
						//Util.alert(AppActivity.this,"û�ж���Ӧ��");//"</list>"
						Constants.subApps=new HashSet<String>();
					} 
					else {
						String str = resp.substring(i, j + 7);
						Xmler.getInstance().alias("app", App.class);
						List<App> list = (List) Xmler.getInstance().fromXML(str);
						Set subs=new HashSet<String>();

						if (list == null) {
							Util.alert(AppActivity.this, "Ӧ���б�Ϊ��");
							return;
						}else{
							//Util.alert(AppActivity.this, "Ӧ���б��Ѿ�����,��ǰ������"+list.size()+"��app");
							for(App app:list){
								if(app.getUrl()!="")
									subs.add(app.getName());
							}
							Constants.subApps=subs;
						}
					}
				}
			}
		}.execute(params);
	}
	
}

