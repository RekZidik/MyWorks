package controler;

import model.*;
import model.manager.SlotsManager;

/**
 * Created by RekZidik on 10/01/2016.
 */
public class ManageSlotsController extends BaseController<SlotsManager> {

    public ManageSlotsController(Controller father, SlotsManager model) {
        super(father, model);
    }

    @Override
    protected void printMenu() {
        String name = getNameModel(getModel());
        System.out.println("1: Add ".concat(name));
        System.out.println("2: Delete ".concat(name));
        System.out.println("3: Show ".concat(name).concat("s"));
    }

    @Override
    protected boolean interact(String response) {
        switch (Integer.valueOf(response)){
            case 1:
                showAll();
                (new AddSlotController(this, getModel())).interact();
                return true;
            case 2:
                (new RemoveModelController<>(this,getModel())).interact();
            case 3:
                printStatModel();
                return true;
        }
        return false;
    }

    private void showAll(){
        System.out.println("Halls:");
        University.getInstance()
                .getBlocks()
                .streamHalls()
                .forEach(Model::printState);
        System.out.println("Teachers:");
        University.getInstance()
                .getTeachers()
                .stream()
                .forEach(Model::printState);
        System.out.println("Groups:");
        University.getInstance()
                .getFormations()
                .streamGroup()
                .forEach(Model::printState);
    }
}
