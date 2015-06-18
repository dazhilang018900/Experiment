/*
 * Copyright (C) 2010 Moduad Co., Ltd.
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */
package org.androidpn.server.console.controller;

import java.io.BufferedReader;
import java.util.List;

import javax.servlet.ServletOutputStream;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.androidpn.server.model.User;
import org.androidpn.server.service.ServiceLocator;
import org.androidpn.server.service.UserExistsException;
import org.androidpn.server.service.UserNotFoundException;
import org.androidpn.server.service.UserService;
import org.androidpn.server.util.Config;
import org.androidpn.server.xmpp.push.NotificationManager;
import org.apache.commons.feedparser.FeedParserListener;
import org.springframework.web.bind.ServletRequestUtils;
import org.springframework.web.servlet.ModelAndView;
import org.springframework.web.servlet.mvc.multiaction.MultiActionController;

import org.apache.commons.feedparser.*;
import org.dom4j.Document;
import org.dom4j.Element;
 

import sun.misc.BASE64Decoder;
/** 
 * A controller class to process the notification related requests.  
 *
 * @author Sehwan Noh (devnoh@gmail.com)
 */
public class NotificationController extends MultiActionController {
    private NotificationManager notificationManager;
    public static long timeStart;

    private UserService userService;
    
    public NotificationController() {
        notificationManager = new NotificationManager();
    }

    public ModelAndView list(HttpServletRequest request,
            HttpServletResponse response) throws Exception {
        ModelAndView mav = new ModelAndView();
        // mav.addObject("list", null);
        mav.setViewName("notification/form");
        return mav;
    }

    
    /**
     * set user's subscribes
     * @deprecated
     * 
     * @param request
     * @param response
     * @return
     * @throws Exception
     * @author zhanghuabing
     */
    @Deprecated
	public ModelAndView get(HttpServletRequest request, HttpServletResponse response) throws Exception{
    	System.out.println("notification get====");
    	String subscriber = ServletRequestUtils.getStringParameter(request, "subscriber");  
    	String subscriptions = ServletRequestUtils.getStringParameter(request, "subscriptions");  
    	String apiKey = Config.getString("apiKey", "");
    	
    	ServletOutputStream out = response.getOutputStream();
    	
        userService = ServiceLocator.getUserService();
        try{
	        User us = userService.getUserByUsername(subscriber);
	        Long userId=us.getId();
	        us.setSubscriptions(subscriptions);
	        userService.saveUser(us);
	        userService.delSubscribes(us.getId());
	        String[] subs=subscriptions.split(";");
	        for(String sub: subs){
	        	userService.addSubscribe(userId,sub);
	        }
	        response.setContentType("text/plain");
			out.print("subscribe:success");  
			out.flush();
        }catch(UserNotFoundException e){
        	response.setContentType("text/plain");
			out.print("subscribe:failure");  
			out.flush();
        }catch(UserExistsException e){
        	response.setContentType("text/plain");
			out.print("subscribe:failure"); 
			out.flush();
        }
        
        
       
        /*
    	ModelAndView mav0 = new ModelAndView();
        mav0.setViewName("redirect:notification.do");
        return mav0;
        */
        return null;
    	
    }    
    
    //create a listener for handling our callbacks
	

    
    /**
     * connect with pubsub plugin (PuSHPress) and receive feeds and push
     * @param request
     * @param response
     * @return
     * @throws Exception
     * @author xzg
     */
    public ModelAndView pubsub(HttpServletRequest request,
            HttpServletResponse response) throws Exception {
        String apiKey = Config.getString("apiKey", "");
 
        System.out.println("NotificationController.pubsub#"+request.getCharacterEncoding());  // UTF-8
        String rStr = ServletRequestUtils.getStringParameter(request, "hub.challenge");
        if(rStr!=null){
	        System.out.println(rStr);
			response.setContentType("text/plain");
    		ServletOutputStream out = response.getOutputStream();
    		out.print(rStr);  
			out.flush();
        }else{
        	// try to print the request string.
        	BufferedReader br = request.getReader();
        	String s = br.readLine();
        	StringBuilder sb = new StringBuilder();
        	while(s!=null){
        		sb.append(s);
        		System.out.println(s);
        		s = br.readLine();
        	}
         
        	
        	//create a listener for handling our callbacks
        	/*FeedParserListener listener = new DefaultFeedParserListener() {

        	        public void onChannel( FeedParserState state,
        	                               String title,
        	                               String link,
        	                               String description ) throws FeedParserException {

        	            System.out.println( "Found a new channel: " + title );

        	        }

        	        public void onItem( FeedParserState state,
        	                            String title,
        	                            String link,
        	                            String description,
        	                            String permalink ) throws FeedParserException {

        	            System.out.println( "Found a new published article: " + title+ permalink );
        	            notificationManager.sendMyNotifications("", title, description, link, "video_cievideo");
        	        }
        	};
        	FeedParser parser = FeedParserFactory.newFeedParser();
        	parser.parse(listener, request.getInputStream(), "");
        	*/   
        	
        	Document document = org.dom4j.DocumentHelper.parseText(sb.toString());
        	Element re=document.getRootElement();
        	List es=re.elements("entry");

        	for(int i=0;i<es.size();i++){
        	    Element currentItem=(Element)es.get(i);
        	    Element title=(Element)currentItem.elements("title").get(0);
        	    Element link=(Element)currentItem.elements("link").get(0);
        	    Element updated=(Element)currentItem.elements("updated").get(0);
        	    Element content=(Element)currentItem.elements("content").get(0);
        	    Element category = (Element)currentItem.elements("category").get(0);
        	    System.out.println(title.getStringValue());
        	    System.out.println(content.getStringValue());
        	    System.out.println(link.attributeValue("href"));
        	    System.out.println(category.attributeValue("term"));
        	    if(category == null || category.attributeValue("term")== null) return null;
        	    if(category.attributeValue("term").equals("")) return null;
        	    notificationManager.sendMyNotifications("", title.getStringValue(),
        	    		"", link.attributeValue("href"), category.attributeValue("term"));
        	}
        }
		return null;
    }

    
    /**
     * send.do(xxx) 推送新闻／视频等
     * @param request
     * @param response
     * @return
     * @throws Exception
     * @author zhanghuabing
     */
    public ModelAndView send(HttpServletRequest request,
            HttpServletResponse response) throws Exception {
        String apiKey = Config.getString("apiKey", "");

	        /**
	         */
	        System.out.println("NotificationController.send#"+request.getCharacterEncoding());  // UTF-8
	        /** author x
	         * @depreciated
	        if(request.getParameter("chat")!=null){
	        	//handle with a chat request
	        	String fromUsername="",
	        			toUsername=request.getParameter("toUsername"),
	        			msg=request.getParameter("message"),
	        			time=Calendar.getInstance().getTime().toString();
	        	System.out.println(toUsername+":"+msg);
	        	if(fromUsername==null||toUsername==null||msg==null) {
	        		return null;
	        	}
	        	notificationManager.sendMessage(apiKey, fromUsername, toUsername, msg, time);
	        	return null;
	        }*/
	        String feedTitle = ServletRequestUtils.getStringParameter(request, "feedTitle");
	        String feedContent = ServletRequestUtils.getStringParameter(request, "feedContent");
	        String feedLink = ServletRequestUtils.getStringParameter(request, "feedLink");
	        
	        System.out.println("---------------------feedTitle--------------------:"+feedTitle);
	        System.out.println("---------------------feedContent------------------:"+feedContent);
	        System.out.println("---------------------feedLink------------------:"+feedLink);
	        if(feedTitle == null || feedContent == null || feedLink == null){
	        	return null;
	        }
	        
	        // http://xx.xx.xx.xx/videoMonitor/monitor_laboratory/xxxx
	        if(feedLink.contains("videoMonitor")){
	        	//timeStart = System.currentTimeMillis();
        		notificationManager.sendMyNotifications(apiKey, feedTitle, feedContent, feedLink, "monitor_all"); 
        		response.setContentType("text/plain");
        		ServletOutputStream out = response.getOutputStream();
        		out.print("getNotice:success");  
    			out.flush();
	        }
	       
	        else if(feedLink.contains("push.pkusz.edu.cn")){
	        	/*if(feedLink.contains("videocourseware")){  
	        		notificationManager.sendMyNotifications(apiKey, feedTitle, feedContent, feedLink, "video_videocourseware"); 
	        	}
	        	else
	        	*/ if(feedLink.contains("leisurevideo")){  
	        		notificationManager.sendMyNotifications(apiKey, feedTitle, feedContent, feedLink, "video_leisurevideo"); 
	        	}
	        	else if(feedLink.contains("schoolvideo")){  
	        		notificationManager.sendMyNotifications(apiKey, feedTitle, feedContent, feedLink, "video_schoolvideo"); 
	        	}
	        	else if(feedLink.contains("cievideo")){ 
	        		notificationManager.sendMyNotifications(apiKey, feedTitle, feedContent, feedLink, "video_cievideo"); 
	        	}
	        	else if(feedLink.contains("hsbcvideo")){  
	        		notificationManager.sendMyNotifications(apiKey, feedTitle, feedContent, feedLink, "video_hsbcvideo"); 
	        	}
	        	else if(feedLink.contains("stlvideo")){  
	        		notificationManager.sendMyNotifications(apiKey, feedTitle, feedContent, feedLink, "video_stlvideo"); 
	        	}
	        	else if(feedLink.contains("renwenvideo")){  
	        		notificationManager.sendMyNotifications(apiKey, feedTitle, feedContent, feedLink, "video_renwenvideo"); 
	        	}
	        }
	              
	        /*
	    	else if(feedLink.contains("english.pkusz.edu.cn")){
	    			if(feedLink.contains("News&Bulletin")){ // News&Bulletin
	    				notificationManager.sendMyNotifications(apiKey, feedTitle, feedContent, feedLink, "english_news");
	    			}
	    	}
	    	*/
	    	
	    	else if(feedLink.contains("news.pkusz.edu.cn")){
	    			if(feedLink.contains("news")){  
	    				notificationManager.sendMyNotifications(apiKey, feedTitle, feedContent, feedLink, "news_yaowen");
	    			}
	    			/*
	    			else if(feedLink.contains("ר 
	    	    		notificationManager.sendMyNotifications(apiKey, feedTitle, feedContent, feedLink, "news_zhuanti");
	    	    	}
	    			else if(feedLink.contains(" 
	    	    		notificationManager.sendMyNotifications(apiKey, feedTitle, feedContent, feedLink, "news_renwu");
	    	    	}
	    			else if(feedLink.contains(" 
	    	    		notificationManager.sendMyNotifications(apiKey, feedTitle, feedContent, feedLink, "news_dianshi");
	    	    	}
	    	    	*/
	    	}
	    	
	    	else if(feedLink.contains("www.pkusz.edu.cn")){
	    		if(feedLink.contains("noti")){  
	    			notificationManager.sendMyNotifications(apiKey, feedTitle, feedContent, feedLink, "pkusz_notification");
	    		}
	    	}            
	    	else {
	    		String feedSection = ServletRequestUtils.getStringParameter(request, "feedSection");
	    		if(feedSection!=null&&feedSection!="")
	    			notificationManager.sendMyNotifications(apiKey, feedTitle, feedContent, feedLink, feedSection);
	    		else{
	    			System.out.println("null feedsection");
	    		}
	    	}
    	return null;
    }

    public ModelAndView admin_send(HttpServletRequest request,
            HttpServletResponse response) throws Exception {
        String apiKey = Config.getString("apiKey", "");

    	String broadcast = ServletRequestUtils.getStringParameter(request,"broadcast");
    	/**
    	 */
    	System.out.println(" broadcast "+broadcast);
    	if(broadcast!=null){
	        String username = ServletRequestUtils.getStringParameter(request,"username");
	        String title = new String(request.getParameter("title").getBytes("iso8859_1"));//ServletRequestUtils.getStringParameter(request, "title");
	        String message = new String(request.getParameter("message").getBytes("iso8859_1"));//ServletRequestUtils.getStringParameter(request, "message");
	        String uri = new String(request.getParameter("uri").getBytes("iso8859_1"));// ServletRequestUtils.getStringParameter(request, "uri");
	        title = "title:"+getFromURL(title);
	        message= getFromURL(message);
	        uri = getFromURL(uri);
	        
	        String v = "";
	        if (broadcast.equalsIgnoreCase("Y")) {
	        	v = "Y";
	        	timeStart = System.currentTimeMillis();
	            notificationManager.sendBroadcast(apiKey, title, message, uri);
	        }else if (broadcast.equalsIgnoreCase("A")) {
	            notificationManager.sendAllBroadcast(apiKey, title, message, uri);
	            v = "A";
	        }else if (broadcast.equalsIgnoreCase("N")){	        	
	        	v = "N";
	            notificationManager.sendNotifications(apiKey, username, title, message, uri);
	        }
	        System.out.println("NotificationController.admin_send#"+request.getCharacterEncoding()+"#"+v);  // UTF-8  
    	}
    	
    	ModelAndView mav = new ModelAndView();
        mav.setViewName("redirect:notification.do");
        return mav;
        
    }
    
    public ModelAndView user_send(HttpServletRequest request,
            HttpServletResponse response) throws Exception {
        String apiKey = Config.getString("apiKey", "");
 
        String username = ServletRequestUtils.getStringParameter(request,"username");
        String title = ServletRequestUtils.getStringParameter(request, "title");
        String message = ServletRequestUtils.getStringParameter(request, "message");
        String uri = ServletRequestUtils.getStringParameter(request, "uri");//java.net.URLDecoder.decode(message,   "utf-8");
        System.out.println("message:"+message);
//        title= getFromBASE64(title);
//        message= getFromBASE64(message); 
        title= getFromBASE64(title);//getFromBASE64(title);
        message=getFromBASE64(message);//java.net.URLDecoder.decode(message,   "utf-8");
      
        notificationManager.sendNotifications(apiKey, username, title, message, uri);
        System.out.println("title:"+title);
        System.out.println("message:"+message);
     
    	ServletOutputStream out = response.getOutputStream();
		out.print("<result>succeed</result>");  
		out.flush();
    	return null;
    }
    
    
 // 将 BASE64 编码的字符串 s 进行解码 
    public static String getFromBASE64(String s) { 
	    if (s == null) return null; 
	    BASE64Decoder decoder = new BASE64Decoder(); 
	    try { 
	    byte[] b = decoder.decodeBuffer(s); 
	    return new String(b,"utf-8"); //@error: default gbk, and we need to decode as utf8
	    } catch (Exception e) { 
	    return null; 
	    } 
    }
    
    public static String getFromURL(String s){
    	if(s==null) return null;
     
    	try{
    		String b= java.net.URLDecoder.decode(s, "utf-8");
    		return b;
    	}catch(Exception e){
    		return null;
    	}
    }
    
    /**
     * appPush.do(xxx) 应用推送给订阅者
     * @param request
     * @param response
     * @return
     * @throws Exception
     * @author xzg
     */
    public ModelAndView appPush(HttpServletRequest request,
            HttpServletResponse response) throws Exception {
        String apiKey = Config.getString("apiKey", "");

	        /**
	         */
	        System.out.println("NotificationController.appPush#"+request.getCharacterEncoding());  // UTF-8
	        /*String feedTitle = ServletRequestUtils.getStringParameter(request, "title");
	        String feedContent = ServletRequestUtils.getStringParameter(request, "message");
	        String feedLink = ServletRequestUtils.getStringParameter(request, "uri");
	        String feedSection = ServletRequestUtils.getStringParameter(request, "appName");
	        feedTitle=getFromURL(feedTitle);//getFromBASE64(feedTitle);
	        feedContent=getFromURL(feedContent);//getFromBASE64(feedContent);
	        feedLink = getFromURL(feedLink);
	        if(feedSection!=null&&feedSection!=""){
			notificationManager.sendMyNotifications(apiKey, feedTitle, feedContent, feedLink, feedSection);
			response.setContentType("text/xml");
    		ServletOutputStream out = response.getOutputStream();
			out.print("<result>succeed</result>");  
			out.flush();
			}else{
				System.out.println("null feedsection");
				response.setContentType("text/xml");
	    		ServletOutputStream out = response.getOutputStream();
				out.print("<result>failed</result>");  
				out.flush();
			}*/
	        
	        String title = new String(request.getParameter("title").getBytes("iso8859_1"));//ServletRequestUtils.getStringParameter(request, "title");
	        String message = new String(request.getParameter("message").getBytes("iso8859_1"));//ServletRequestUtils.getStringParameter(request, "message");
	        String uri = new String(request.getParameter("uri").getBytes("iso8859_1"));// ServletRequestUtils.getStringParameter(request, "uri");
	        String appName = new String(request.getParameter("appName").getBytes("iso8859_1"));
	        title = getFromURL(title);
	        message= getFromURL(message);
	        uri = getFromURL(uri);
    		appName = getFromURL(appName);
    		
    		
    		if(appName!=null&&appName!=""){
    			notificationManager.sendMyNotifications(apiKey, title, message, uri, appName);
    			response.setContentType("text/xml");
        		ServletOutputStream out = response.getOutputStream();
    			out.print("<result>succeed</result>");  
    			out.flush();
    		}else{
    			System.out.println("null feedsection");
    			response.setContentType("text/xml");
        		ServletOutputStream out = response.getOutputStream();
    			out.print("<result>failed</result>");  
    			out.flush();
    		}
    		
    		System.out.println("---------------------feedTitle--------------------:"+title);
	        System.out.println("---------------------feedContent------------------:"+message);
	        System.out.println("---------------------feedLink------------------:"+uri);
	        System.out.println("---------------------feedSection------------------:"+appName);
    		return null;
    }
    
}
