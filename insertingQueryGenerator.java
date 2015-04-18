
public class QueryGenerator {
	
	public static void main (String [] args)
	{
		TextIO.readFile("data.txt");
		while (!TextIO.eof())
		{
			if (count==400)
				break;
			String currentLine=TextIO.getln();
			for (int i=0; i<currentLine.length(); i++)
			{
				if (currentLine.charAt(i)=='\"')
				{
					currentLine=currentLine.substring(0,i)+"'"+currentLine.substring(i+1,currentLine.length());
				}
			}
			int posOne=currentLine.indexOf("\t");
			int posTwo=currentLine.indexOf("\t", posOne+1);
			String name=currentLine.substring(posOne+1, posTwo);
			String link=currentLine.substring(posTwo+1, currentLine.length());
			TextIO.putln("INSERT INTO `Product`(`Link`, `name`) VALUES (\""+link+"\", \""+ name+"\");");
		}

		
	}

}
