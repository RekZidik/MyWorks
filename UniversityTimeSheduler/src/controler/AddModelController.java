package controler;

import model.Model;
import model.manager.Manager;
import org.json.JSONObject;

import java.lang.reflect.Constructor;
import java.lang.reflect.InvocationTargetException;

/**
 * Created by RekZidik on 09/01/2016.
 */
public class AddModelController<T extends Model> extends BaseController<Manager<T>> {

    private ConfigDisplay config;

    public AddModelController(Controller father, Manager<T> model,ConfigDisplay configDisplay) {
        super(father, model);
        setHook(false);
        this.config = configDisplay;
        setRegexResponse(config.getRegex());
    }

    @Override
    protected void printMenu() {
        System.out.print(config.getMessage());
    }

    @Override
    protected boolean interact(String response) {
        if (!(matcher.group(1)==null)) {
            String[] tab = matcher.group(1).split(config.getSeparator());
            Constructor<?> constructor;
            T element = null;
            JSONObject data ;
            try {
                constructor = Model.class.getConstructor();
                try {
                    data = new JSONObject("{\"seanceType\":" + tab[tab.length - 1]+"}");
                }catch (IndexOutOfBoundsException e){
                    data =  new JSONObject();
                }
                for (Constructor<?> e : getModel().getModelInstance(data).getClass().getConstructors()) {
                    if (e.getParameterCount()>0 && e.getParameterTypes()[0].isArray()) {
//                    System.out.println("Parameter count "+e.getParameterCount()+" isArray"+ e.getParameterTypes()[0].isArray());
//                        Class<?>[] types = e.getParameterTypes();
//                        for (int i = 0; i < types.length; i++) {
//                            flag &= types[i].equals(String.class);
//                        }
//                        if (flag)
                        //&& e.getParameterTypes()[0].isArray()
                            constructor = e;
                        break;
                    }
                }
                element = (T) constructor.newInstance(new Object[] {tab});
            } catch (NoSuchMethodException | IllegalAccessException | InstantiationException | InvocationTargetException e) {
                e.printStackTrace();
            }
            if (!getModel().add(element)) {
                printErrorMessage();
                return false;
            }
            savingState();
            printSuccessMessage();
            return true;
        }
        return false;
    }

    @Override
    protected void printStatModel() {
    }



    public static class ConfigDisplay{
        private String regex;
        private String message;
        private String separator;

        public ConfigDisplay(String regex, String message, String separator) {
            this.regex = regex;
            this.message = message;
            this.separator = separator;
        }

        public String getRegex() {
            return regex;
        }

        public void setRegex(String regex) {
            this.regex = regex;
        }

        public String getMessage() {
            return message;
        }

        public void setMessage(String message) {
            this.message = message;
        }

        public String getSeparator() {
            return separator;
        }

        public void setSeparator(String separator) {
            this.separator = separator;
        }
    }
}
