package controler;

import model.Model;
import model.manager.Manager;

import java.util.Optional;

/**
 * Created by RekZidik on 15/01/2016.
 */
public class ModelSelectorController<S extends Model,T extends Manager<S>> extends BaseController<T> {
    private Optional<S> basicModel;

    public ModelSelectorController(Controller father, T model) {
        super(father, model);
        basicModel = Optional.ofNullable(null);
        setRegexResponse("([\\d]+)");
    }

    public void reset(){
        basicModel = Optional.ofNullable(null);
    }

    @Override
    protected void printMenu() {
        String name = getNameModel(getModel());
        System.out.println("Select an ".concat(name).concat(" with Ref"));
    }

    public Optional<S> getBasicModel() {
        return basicModel;
    }

    @Override
    protected boolean interact(String response) {
        basicModel = getModel().get(response);
        if (basicModel.isPresent()){
            printSuccessMessage();
            return true;
        }
        printErrorMessage();
        return false;
    }

}
