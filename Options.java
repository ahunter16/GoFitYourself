public class Option
{
	int length;		//length of this workout in minutes
	int[] splits;	//array with indexes 0 - 7, with  
					//each index corresponding to each of:
					//legs, back, chest, biceps, triceps, shoulders, forearms, abs

	public Option(int length, int[] splits)
	{
		this.length = length;
		this.splits = splits;
	}
}