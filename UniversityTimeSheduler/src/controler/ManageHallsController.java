package controler;

import model.Hall;
import model.manager.Manager;

/**
 * Created by RekZidik on 17/01/2016.
 */
public class ManageHallsController extends ManageModelsController<Hall> {
    public ManageHallsController(Controller father, Manager<Hall> model, AddModelController.ConfigDisplay configDisplay) {
        super(father, model, configDisplay);
    }

    @Override
    protected boolean forManageItem() {
        //TODO implementer le travail de modification d'une salle en selectionnant
        return false;
    }
}
