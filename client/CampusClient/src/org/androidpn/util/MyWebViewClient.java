package org.androidpn.util;

import android.webkit.WebView;
import android.webkit.WebViewClient;

public class MyWebViewClient extends WebViewClient {

	// ��дshouldOverrideUrlLoading������ʹ������Ӻ�ʹ��������������򿪡�

	@Override
	public boolean shouldOverrideUrlLoading(WebView view, String url) {

		view.loadUrl(url);

		// �������Ҫ�����Ե�������¼��Ĵ�������true�����򷵻�false

		return true;

	}
}