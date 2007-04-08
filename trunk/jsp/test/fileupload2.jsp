package document;

//import javax
import javax.servlet.*;
import javax.servlet.http.*;

//import java
import java.io.*;

//import else
import com.jspsmart.upload.*;

public class UpLoadToHD extends HttpServlet{

  private ServletConfig config;

  /**
   * init the servlet
   */
  final public void init(ServletConfig config) throws ServletException{
    this.config=config;
  }
  final public ServletConfig getServletConfig(){
    return config;
  }

  /**
   * handle get requests
   */
  public void doGet(HttpServletRequest request,HttpServletResponse response)
      throws ServletException,IOException{
    doPost(request,response);
  }
  /**
   * handle post requests
   */
  public void doPost(HttpServletRequest request,HttpServletResponse response)
      throws ServletException,IOException{

    try{

      SmartUpload mySmartUpload=new SmartUpload();

      mySmartUpload.initialize(config,request,response);

      //mySmartUpload.setMaxFileSize(1024*600); 默认为最大32M

      mySmartUpload.upload();

      String opmsg=CreatFolder.creatFolder("D:/Apache Tomcat 4.0/webapps/mytest/upload);
      
      mySmartUpload.initialize(config,request,response);


      com.jspsmart.upload.File myFile=mySmartUpload.getFiles().getFile(0);

      if(!myFile.isMissing()){    
            myFile.saveAs("/upload/ + myFile.getFileName());
      }

    }catch(Exception e){
      e.printStackTrace();
    }
  }
}
