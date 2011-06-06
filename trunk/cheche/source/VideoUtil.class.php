public class VideoUtil {
013
     
014
    /**
015
     * 获取视频信息
016
     * @param url
017
     * @return
018
     */
019
    public static Video getVideoInfo(String url){
020
        Video video = new Video();
021
         
022
        if(url.indexOf("v.youku.com")!=-1){
023
            try {
024
                video = getYouKuVideo(url);
025
            } catch (Exception e) {
026
                video = null;
027
            }
028
        }else if(url.indexOf("tudou.com")!=-1){
029
            try {
030
                video = getTudouVideo(url);
031
            } catch (Exception e) {
032
                video = null;
033
            }
034
        }else if(url.indexOf("v.ku6.com")!=-1){
035
            try {
036
                video = getKu6Video(url);
037
            } catch (Exception e) {
038
                video = null;
039
            }
040
        }else if(url.indexOf("6.cn")!=-1){
041
            try {
042
                video = get6Video(url);
043
            } catch (Exception e) {
044
                video = null;
045
            }
046
        }else if(url.indexOf("56.com")!=-1){
047
            try {
048
                video = get56Video(url);
049
            } catch (Exception e) {
050
                video = null;
051
            }
052
        }
053
         
054
        return video;
055
    }
056
     
057
     
058
    /**
059
     * 获取优酷视频
060
     * @param url  视频URL
061
     */
062
    public static Video getYouKuVideo(String url) throws Exception{
063
        Document doc = getURLContent(url);
064
         
065
        /**
066
         *获取视频缩略图
067
         */
068
        String pic = getElementAttrById(doc, "s_sina", "href");
069
        int local = pic.indexOf("pic=");
070
        pic = pic.substring(local+4);
071
         
072
        /**
073
         * 获取视频地址
074
         */    
075
        String flash = getElementAttrById(doc, "link2", "value");
076
         
077
        /**
078
         * 获取视频时间
079
         */
080
        String time = getElementAttrById(doc, "download", "href");
081
        String []arrays = time.split("\\|");
082
        time = arrays[4];
083
         
084
        Video video = new Video();
085
        video.setPic(pic);
086
        video.setFlash(flash);
087
        video.setTime(time);
088
         
089
        return video;
090
    }
091
     
092
     
093
    /**
094
     * 获取土豆视频
095
     * @param url  视频URL
096
     */
097
    public static Video getTudouVideo(String url) throws Exception{
098
        Document doc = getURLContent(url);
099
        String content = doc.html();
100
        int beginLocal = content.indexOf("<script>document.domain");
101
        int endLocal = content.indexOf("</script>");
102
        content = content.substring(beginLocal, endLocal);
103
         
104
        /**
105
         * 获取视频地址
106
         */
107
        String flash = getScriptVarByName("iid_code", content);
108
        flash = "http://www.tudou.com/v/" + flash + "/v.swf";
109
         
110
        /**
111
         *获取视频缩略图
112
         */
113
        String pic = getScriptVarByName("thumbnail", content);
114
         
115
        /**
116
         * 获取视频时间
117
         */
118
        String time = getScriptVarByName("time", content);
119
 
120
        Video video = new Video();
121
        video.setPic(pic);
122
        video.setFlash(flash);
123
        video.setTime(time);
124
         
125
        return video;
126
    }
127
     
128
     
129
    /**
130
     * 获取酷6视频
131
     * @param url  视频URL
132
     */
133
    public static Video getKu6Video(String url) throws Exception{
134
        Document doc = getURLContent(url);
135
         
136
        /**
137
         * 获取视频地址
138
         */
139
        Element flashEt = doc.getElementById("outSideSwfCode");
140
        String flash = flashEt.attr("value");
141
         
142
        /**
143
         * 获取视频缩略图
144
         */
145
        Element picEt = doc.getElementById("plVideosList");
146
        String time = null;
147
        String pic = null;
148
        if(picEt!=null){
149
            Elements pics = picEt.getElementsByTag("img");
150
            pic = pics.get(0).attr("src");
151
             
152
            /**
153
             * 获取视频时长
154
             */
155
            Element timeEt = picEt.select("span.review>cite").first();
156
            time = timeEt.text();
157
        }else{
158
            pic = doc.getElementsByClass("s_pic").first().text();
159
        }
160
         
161
        Video video = new Video();
162
        video.setPic(pic);
163
        video.setFlash(flash);
164
        video.setTime(time);
165
         
166
        return video;
167
         
168
    }
169
     
170
     
171
    /**
172
     * 获取6间房视频
173
     * @param url  视频URL
174
     */
175
    public static Video get6Video(String url) throws Exception{
176
        Document doc = getURLContent(url);
177
         
178
        /**
179
         * 获取视频缩略图
180
         */
181
        Element picEt = doc.getElementsByClass("summary").first();
182
        String pic = picEt.getElementsByTag("img").first().attr("src");
183
         
184
        /**
185
         * 获取视频时长
186
         */
187
        String time = getVideoTime(doc, url, "watchUserVideo");
188
        if(time==null){
189
            time = getVideoTime(doc, url, "watchRelVideo");
190
        }
191
         
192
        /**
193
         * 获取视频地址
194
         */
195
        Element flashEt = doc.getElementById("video-share-code");
196
        doc = Jsoup.parse(flashEt.attr("value")); 
197
        String flash = doc.select("embed").attr("src");
198
         
199
        Video video = new Video();
200
        video.setPic(pic);
201
        video.setFlash(flash);
202
        video.setTime(time);
203
         
204
        return video;
205
    }
206
     
207
     
208
    /**
209
     * 获取56视频
210
     * @param url  视频URL
211
     */
212
    public static Video get56Video(String url) throws Exception{
213
        Document doc = getURLContent(url);
214
        String content = doc.html();
215
         
216
        /**
217
         * 获取视频缩略图
218
         */
219
        int begin = content.indexOf("\"img\":\"");
220
        content = content.substring(begin+7, begin+200);
221
        int end = content.indexOf("\"};");
222
        String pic = content.substring(0, end).trim();
223
        pic = pic.replaceAll("\\\\", "");      
224
         
225
        /**
226
         * 获取视频地址
227
         */
228
        String flash = "http://player.56.com" + url.substring(url.lastIndexOf("/"), url.lastIndexOf(".html")) + ".swf";
229
         
230
        Video video = new Video();
231
        video.setPic(pic);
232
        video.setFlash(flash);
233
         
234
        return video;
235
    }
236
 
237
    /**
238
     * 获取6间房视频时长   
239
     */
240
    private static String getVideoTime(Document doc, String url, String id) {
241
        String time = null;
242
         
243
        Element timeEt = doc.getElementById(id);
244
        Elements links = timeEt.select("dt > a");
245
         
246
         
247
        for (Element link : links) {
248
          String linkHref = link.attr("href");
249
          if(linkHref.equalsIgnoreCase(url)){
250
              time = link.parent().getElementsByTag("em").first().text();
251
              break;
252
          }
253
        }
254
        return time;
255
    }
256
     
257
             
258
    /**
259
     * 获取script某个变量的值
260
     * @param name  变量名称
261
     * @return   返回获取的值
262
     */
263
    private static String getScriptVarByName(String name, String content){
264
        String script = content;
265
         
266
        int begin = script.indexOf(name);
267
         
268
        script = script.substring(begin+name.length()+2);
269
         
270
        int end = script.indexOf(",");
271
         
272
        script = script.substring(0,end);
273
         
274
        String result=script.replaceAll("'", "");
275
        result = result.trim();
276
         
277
        return result;
278
    }
279
     
280
     
281
    /**
282
     * 根据HTML的ID键及属于名，获取属于值
283
     * @param id  HTML的ID键
284
     * @param attrName  属于名
285
     * @return  返回属性值
286
     */
287
    private static String getElementAttrById(Document doc, String id, String attrName)throws Exception{
288
        Element et = doc.getElementById(id);
289
        String attrValue = et.attr(attrName);
290
         
291
        return attrValue;
292
    }
293
     
294
     
295
     
296
    /**
297
     * 获取网页的内容
298
     */
299
    private static Document getURLContent(String url) throws Exception{
300
        Document doc = Jsoup.connect(url)
301
          .data("query", "Java")
302
          .userAgent("Mozilla")
303
          .cookie("auth", "token")
304
          .timeout(6000)
305
          .post();
306
        return doc;
307
    }
308
     
309
     
310
    public static void main(String[] args) {
311
        //String url = "http://v.youku.com/v_show/id_XMjU0MjI2NzY0.html";
312
        //String url = "http://www.tudou.com/programs/view/pVploWOtCQM/";
313
        //String url = "http://v.ku6.com/special/show_4024167/9t7p64bisV2A31Hz.html";
314
        //String url = "http://v.ku6.com/show/BpP5LeyVwvikbT1F.html";
315
        //String url = "http://6.cn/watch/14757577.html";
316
        String url = "http://www.56.com/u64/v_NTkzMDEzMTc.html";
317
        Video video = getVideoInfo(url);
318
        System.out.println("视频缩略图："+video.getPic());
319
        System.out.println("视频地址："+video.getFlash());
320
        System.out.println("视频时长："+video.getTime());
321
    }
322
}
