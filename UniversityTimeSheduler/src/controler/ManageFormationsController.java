package controler;

import model.Formation;
import model.manager.Manager;

import java.util.Optional;
import java.util.regex.Pattern;

/**
 * Created by RekZidik on 08/01/2016.
 */
public class ManageFormationsController extends ManageModelsController<Formation> {

    public ManageFormationsController(Controller father, Manager<Formation> model, AddModelController.ConfigDisplay configDisplay) {
        super(father, model, configDisplay);
    }

    @Override
    protected boolean forManageItem() {

        if (basicModel.isPresent()) {
            pattern = Pattern.compile("[\\w\\s]+");
            while (true) {
                System.out.println("Nomination(".concat(basicModel.get().getNomination()).concat(") :"));
                input = scanner.nextLine();
                matcher = pattern.matcher(input);
                if (input.equals("")) break;
                if (matcher.find()){
                    basicModel.get().setNomination(input);
                    break;
                }
            }

            pattern = Pattern.compile("[\\d]+");
            while (true) {
                System.out.println("Students(".concat(String.valueOf(basicModel.get().getStudents())).concat(") :"));
                input = scanner.nextLine();
                matcher = pattern.matcher(input);
                if (input.equals("")) break;
                if (matcher.find()){
                    basicModel.get().setStudents(Integer.valueOf(input));
                    break;
                }
            }

            pattern = Pattern.compile("[Yes|YES|y|Y]");
            while (true) {
                System.out.println("Manage Module (Yes/No) :");
                input = scanner.nextLine();
                matcher = pattern.matcher(input);
                if (input.equals("")) break;
                if (matcher.find()){
//                    ModuleHandler manager = new ModuleHandler(basicModel.get());
//                    manager.add(basicModel.get().stream());
//                    manager.setLabel(basicModel.get().getLabel().concat(" Modules"));
                    (new ManageModuleController(this,
                                                basicModel.get().getModules(),
                                                new AddModelController.ConfigDisplay(
                                                        "^((".concat(basicModel.get().getId()).concat(")/[\\w\\s]+/[Y|N](/[\\d]+){4})|([\\d])$")
                                                        ,"Ref:".concat(basicModel.get().getId()).concat("/Nomination/Optional(Y|N)/Students/TD hours/TP hours/Cour hours")
                                                        ,"/")))
                    .interact();
                    break;
                }
            }
            basicModel = Optional.empty();
        }

        interact();
        return true;
    }
}
