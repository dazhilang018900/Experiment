package org.androidpn.server.model;
import java.io.Serializable;

import javax.persistence.Column;

/**
 * @author: xzg
 * Log 表格的复合主键映射
 */
//@Entity
//@Table(name = "apn_log")
public class Log implements Serializable {  
	private static final long serialVersionUID = 1L;

    @Column(name = "username", nullable = false )
    private String username;
    @Column(name = "action", nullable = false )
    private int action;
//    @Column(name="time", nullable=false)
//    private String time;
    
    public String getUsername() {
        return username;
    }

    public void setUsername(String name) {
        this.username = name;
    }
    
    public long getAction() {
        return action;
    }

    public void setAction(int a) {
        this.action = a;
    }
   
    public Log(){
    	
    }
    public Log(String name,int action2) {
    	this.username=name;
    	this.action=action2; 
    }
    @Override
    public boolean equals(Object o) {
        if (!(o instanceof Log)) {
            return false;
        }
        
        final Log obj = (Log) o;
        if(username.equals(obj.username)&&action==obj.action) return true;
        return false;
    }

    @Override
    public int hashCode() {
        int result = 0;
        result = 29 * result +username.hashCode();
        result = 29 * result
                + action;
        return result;
    }

}
