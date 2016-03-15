package controler;

import model.Module;
import model.manager.Manager;

/**
 * Created by RekZidik on 17/01/2016.
 */
public class ManageModuleController extends ManageModelsController<Module> {
    public ManageModuleController(Controller father, Manager<Module> model, AddModelController.ConfigDisplay configDisplay) {
        super(father, model, configDisplay);
    }

    @Override
    protected boolean forManageItem() {
        //TODO implementer le travail de modification d'un module en selectionnant
        return false;
    }
}
