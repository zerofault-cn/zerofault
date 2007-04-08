package Mobile;
import java.util.*;
import java.math.*;
import java.io.*;
public class  GetRandom
{
	int count;
	int sum;
	public GetRandom(){
		count=0;
		sum=0;
	}
	public void setCount(int acount){
		this.count=acount;
	}
	public void setSum(int asum){
		this.sum=asum;
	}
	public int getCount(){
		return this.count;
	}
	public int getSum(){
		return this.sum;
	}
	public String realGetRandom(){
			Random rand=new Random();
			for(int i=0;i<count;i++){
				sum+=rand.nextInt(999);
			}
			//sum=sum/count;
			String ret=null;
			return (ret.valueOf(sum));
	}


	
	//public static void main(String[] args){
	//	GetRandom app=new GetRandom();
	//	app.setCount(139);
	//	app.setSum(0);
	//	System.out.print(app.realGetRandom());
	//	
	//}
}
