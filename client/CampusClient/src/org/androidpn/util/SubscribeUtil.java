package org.androidpn.util;

import java.util.List;

import org.androidpn.demoapp.AppWebActivity;
import org.androidpn.demoapp.R;

import android.app.Activity;
import android.content.Context;
import android.os.AsyncTask;
import android.util.Log;

public class SubscribeUtil {

	/**
	 * addSubscribe(username,appid)
	 * ����ĳ��Ӧ��
	 */
	public static void addSubscribe(final Context cxt, String s,Long t){
		StringBuilder parameter = new StringBuilder();
		parameter.append("action=addSubscribe"); //
		parameter.append("&username=" + s + "&appid="+ t);
		new AsyncTask<StringBuilder, Integer, String>() {
			@Override
			protected String doInBackground(StringBuilder... parameter) {
				/*--End--*/
				String resp = GetPostUtil.send("POST",
						cxt.getString(R.string.androidpnserver) + "subscriptions.do",
						parameter[0]);
				return resp;
			}

			@Override
			protected void onPostExecute(String resp) {
				if (!"succeed".equals( Util.getXmlElement(resp, "result"))) {
					String reason =  Util.getXmlElement(resp, "reason");
					Util.alert(cxt, "���ӹ�עʧ��:"+resp
							+ (reason == null ? "" : reason));
					return;
				}else {
					Util.alert(cxt, "���ӹ�ע�ɹ�");
				}
			}
		}.execute(parameter);
	}
	
	
	/**
	 *  
	 * ���ö���ĳЩӦ��
	 */
	public static void setSubscribe(final Context cxt, String s, Long [] t){
		StringBuilder parameter = new StringBuilder();
		
		
		parameter.append("action=setSub"); //
		parameter.append("&username=" + s + "&subs="+ t);
		new AsyncTask<StringBuilder, Integer, String>() {
			@Override
			protected String doInBackground(StringBuilder... parameter) {
				/*--End--*/
				String resp = GetPostUtil.send("POST",
						cxt.getString(R.string.androidpnserver) + "subscriptions.do",
						parameter[0]);
				return resp;
			}

			@Override
			protected void onPostExecute(String resp) {
				if (!"succeed".equals( Util.getXmlElement(resp, "result"))) {
					String reason =  Util.getXmlElement(resp, "reason");
					Util.alert(cxt, "���ù�עʧ��:"+resp
							+ (reason == null ? "" : reason));
					return;
				}else {
					Util.alert(cxt, "���ù�ע�ɹ�");
				}
			}
		}.execute(parameter);
	}
	
}