import controler.MainMenu;
import model.University;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Paths;


/**
 * Created by RekZidik on 08/01/2016.
 */
public class SchedulerApp {

    public static void main(String[] argv)  {
        String jsonText;
        JSONObject jsonObject;

        try {
            jsonText = String.valueOf(Files.readAllLines(Paths.get("data.json")).get(0));
        } catch (IOException  e) {
            e.printStackTrace();
            System.out.println("Bug");
            jsonText="{}";
        }
        try {
            jsonObject = new JSONObject(jsonText);

        }catch (JSONException e) {
            System.out.println("Bug JSON");
            jsonObject = new JSONObject();
        }

        University university = University.getInstance();
        university.fromJSON(jsonObject);
        MainMenu menu = new MainMenu(null,university);
        menu.interact();
    }
}
