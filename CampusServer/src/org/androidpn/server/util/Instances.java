package org.androidpn.server.util;
import com.thoughtworks.xstream.XStream;
public class Instances{
	public static XStream xmler=null;
	public static XStream getXStream(){
		if(xmler==null){
			synchronized(Instances.class){
				xmler=new XStream();
			}
		}
		return xmler;
	}
	
}
