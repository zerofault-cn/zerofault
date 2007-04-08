
import java.net.*;
import java.io.*;



public class Guonei {
  String rp = "\n<table width=\"100%\"  border=\"1\" cellspacing=\"0\" cellpadding=\"0\" background=\"file:///usr/suit/newebox/image/weather/wt.png\">\n\t<tr>\n\t\t<td style=\"font-size:20px;color:white\">###city<img src=\"file:///usr/suit/newebox/image/weather/###tubiao.jpg\" height=\"30\">&nbsp;&nbsp;###state<br>###temperature<br>###feng</td>\n\t</tr>\n</table>\n";
  String url_str = "http://www.cma.gov.cn/qx/qxshow1.php?ttype=1&period_time=20:00";

  public Guonei() {}

  public static void main(String[] arg) throws Exception {
    Guonei qln = new Guonei();
    qln.create();
  }

//读取指定URL的各项内容，并生成规定格式的TXT文件
  private void create() throws Exception {
    File temp, targ;
    PrintWriter pw;
		URL url = new URL(url_str);
    BufferedReader br = new BufferedReader(new InputStreamReader(url.openStream()));
    int a;
    String city, state, tubiao, temperature, feng, exch, tempor, rep="";
    String line = null, source = "";
		String[] cities;
    while ( (line = br.readLine()) != null) {
      source += line;
    }
    br.close();
    source = source.substring(source.lastIndexOf("<table border=\"0\" width=\"100%\">"));
    source = source.substring(0, source.indexOf("</table>"));
		temp = new File(System.getProperty("user.dir") + File.separator +	"weather.htm");
		targ = new File(System.getProperty("user.dir") + File.separator +	"weatherpage.htm");
		if (targ.exists()) targ.delete();
		pw = new PrintWriter(new FileOutputStream(targ, true));
		br = new BufferedReader(new FileReader(temp));
		while ( (line = br.readLine()) != null) {
			if ( (a = line.indexOf("Array(\"北京")) != -1) {
				tempor = line.substring(a + 7,line.lastIndexOf("\""));
				cities = tempor.split("\",\"");
				for(int i = 0; i < cities.length; i++) {
					if((a = source.indexOf(cities[i])) == -1) {
						rep += "\"\"";
						System.out.println("未找到城市---" + cities[i]);
						continue;
					}
					tempor = source.substring(a);
					tempor = tempor.substring(tempor.indexOf("<font") + 16);
					tempor = tempor.substring(tempor.indexOf("<font") + 16);
					state = tempor.substring(0, tempor.indexOf("</font")).trim();
					tubiao = "qing";
					if(state.indexOf("晴") != -1) tubiao = "qing";
					if(state.indexOf("阵雨") != -1) tubiao = "zhenyu";
					if(state.indexOf("小雨") != -1) tubiao = "yun_yu";
					if(state.indexOf("中雨") != -1) tubiao = "yu_yun";
					if(state.indexOf("大雨") != -1) tubiao = "yu";
					if(state.indexOf("暴雨") != -1) tubiao = "yu";
					if(state.indexOf("多云") != -1) tubiao = "yun";
					if(state.indexOf("阴") != -1) tubiao = "qing_yun";
					if(state.indexOf("雪") != -1) tubiao = "xue";
					if(state.indexOf("雷") != -1) tubiao = "lei_yu";
					tempor = tempor.substring(tempor.indexOf("<font") + 16);
					exch = tempor.substring(0, tempor.indexOf("</font")).trim();
					tempor = tempor.substring(tempor.indexOf("<font") + 16);
					temperature = tempor.substring(0, tempor.indexOf("</font")).trim() + "℃~" + exch + "℃";
					tempor = tempor.substring(tempor.indexOf("<font") + 16);
					tempor = tempor.substring(tempor.indexOf("<font") + 16);
					feng = tempor.substring(0, tempor.indexOf("</font")).trim();
					if(!feng.substring(0,1).matches("[0-9]|<|>")) {
						for(a = 0; a < feng.length(); a++) {
							if(feng.substring(a,a + 1).matches("[0-9]|<|>")) break;
						}
						if(a == feng.length()) feng = feng + "风";
						else feng = feng.substring(0,a).trim() + "风" + feng.substring(a) + "级";
					}
					else feng += "级";
					rep += "\"" + cities[i] + "<br><img src=file:///usr/suit/newebox/image/weather/" + tubiao + ".jpg height=30>&nbsp;&nbsp;" + state;
					rep += "<br>" + temperature + "<br>" + feng + "\",";
				}
				if(rep != null && rep.length() > 1) rep = rep.substring(0,rep.length() - 1);
			}
			if((a = line.indexOf("###weather")) != -1) line = replace(line,"###weather",rep);
			pw.println(line);
		}
		br.close();
		pw.close();
		System.out.println("创建weatherpage完毕");
  }

  private String replace(String strSource,String strFrom,String strTo){
    String strDest = "";
    int intFromLen = strFrom.length();
    int intPos;

    while((intPos=strSource.indexOf(strFrom))!=-1){
      strDest = strDest + strSource.substring(0,intPos);
      strDest = strDest + strTo;
      strSource = strSource.substring(intPos+intFromLen);
    }
    strDest = strDest + strSource;

    return strDest;
  }

}
