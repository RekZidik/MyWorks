package controler;

import model.Model;
import model.manager.Manager;

import java.util.Optional;
import java.util.Scanner;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

/**
 * Created by RekZidik on 09/01/2016.
 */
public abstract class ManageModelsController<T extends Model> extends BaseController<Manager<T>> {
    protected static final int MANAGE_MODEL_CHOICE = 4;

    private AddModelController.ConfigDisplay config;
    protected Optional<T> basicModel;
    protected Matcher matcher;
    protected Pattern pattern;
    protected Scanner scanner;
    protected String input;

    public ManageModelsController(Controller father, Manager<T> model,AddModelController.ConfigDisplay configDisplay) {
        super(father, model);
        this.config = configDisplay;
        this.basicModel = Optional.empty();
    }

    @Override
    protected void printMenu() {
        String name = getNameModel(getModel());
        System.out.println("1: Add ".concat(name));
        System.out.println("2: Delete ".concat(name));
        System.out.println("3: Show ".concat(name).concat("s"));
        System.out.println(String.valueOf(MANAGE_MODEL_CHOICE).concat(": Manage ".concat(name).concat("s")));
    }

    @Override
    protected boolean interact(String response) {
        switch (Integer.valueOf(response)){
            case 1:
                (new AddModelController<>(this, getModel(), config)).interact();
                return true;

            case 2:
                (new RemoveModelController<>(this,getModel())).interact();
                return true;

            case 3:
                getModel().printState();
                interact();
                return true;
            case MANAGE_MODEL_CHOICE:
                scanner = new Scanner(System.in);
                pattern = Pattern.compile("^[\\d]+$");
                getModel().printState();
                while (true) {
                    System.out.println("Select Item by References.");
                    input = scanner.nextLine();
                    matcher = pattern.matcher(input);
                    if (input.equals("") || matcher.find()){
                        basicModel = getModel().get(input);
                        break;
                    }
                }
                return forManageItem();
        }
        return false;
    }

    @Override
    protected void printStatModel() {
        getModel().printGlobalStat();
    }

    protected abstract boolean forManageItem();
}
