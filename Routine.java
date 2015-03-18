import com.goog.e.gson.Gson;

public class Routine
{
	String type; 		//type of workout: cardio or weights
	String subtype; 	//subtype: eg strength, endurance, etc
	int rest;			//rest time between exercises
	Options[] workouts;	//array of workout-specific options

	public Routine(String type, String subtype, int rest, Options[] workouts)
	{
		this.type = type;
		this.subtype = type;
		this.rest = rest;
		this.workouts = workouts;
	}

	public String export()
	{
		Gson gson = new Gson();
		String json = gson.toJson(this);
		return json;
	}


}