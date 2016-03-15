package controler;

import model.Model;
import model.manager.Manager;

/**
 * Created by RekZidik on 09/01/2016.
 */
public class RemoveModelController<T extends Model> extends BaseController<Manager<T>> {
    public RemoveModelController(Controller father, Manager<T> model) {
        super(father, model);
        setHook(false);
        setRegexResponse("^([\\d]+)$");
    }

    @Override
    protected void printMenu() {
        System.out.print(getNameModel(getModel()).concat(" references :"));
    }

    @Override
    protected boolean interact(String response) {
        if(!getModel().remove(getModel().get(response).get())) {
            printErrorMessage();
            return false;
        }

        printSuccessMessage();
        return true;
    }

    @Override
    protected void printStatModel() {
        System.out.println("Warning: The removal can generated a loss of data ");
        getModel().printState();
    }
}
