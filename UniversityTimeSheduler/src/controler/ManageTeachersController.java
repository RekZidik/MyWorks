package controler;

import model.Module;
import model.Teacher;
import model.University;
import model.manager.Manager;

import java.util.Optional;
import java.util.regex.Pattern;

/**
 * Created by RekZidik on 17/01/2016.
 */
public class ManageTeachersController extends ManageModelsController<Teacher> {

    public ManageTeachersController(Controller father, Manager<Teacher> model, AddModelController.ConfigDisplay configDisplay) {
        super(father, model, configDisplay);
    }

    @Override
    protected boolean forManageItem() {
        //TODO implementer le travail de modification d'un professeur en selectionnant

        if (basicModel.isPresent()) {
            pattern = Pattern.compile("[\\w]+");
            while (true) {
                System.out.println("Name(".concat(basicModel.get().getName()).concat(") :"));
                input = scanner.nextLine();
                matcher = pattern.matcher(input);
                if (input.equals("")) break;
                if (matcher.find()){
                    basicModel.get().setName(input);
                    break;
                }
            }

            pattern = Pattern.compile("[\\w\\s]+");
            while (true) {
                System.out.println("First name(".concat(String.valueOf(basicModel.get().getFirstName())).concat(") :"));
                input = scanner.nextLine();
                matcher = pattern.matcher(input);
                if (input.equals("")) break;
                if (matcher.find()){
                    basicModel.get().setFirstName(input);
                    break;
                }
            }

            while (true) {
                System.out.println("Grade (".concat(String.valueOf(basicModel.get().getGrade())).concat(") :"));
                input = scanner.nextLine();
                matcher = pattern.matcher(input);
                if (input.equals("")) break;
                if (matcher.find()){
                    basicModel.get().setGrade(input);
                    break;
                }
            }

            while (true) {
                System.out.println("All Modules  :");
                University.getInstance().getFormations().streamModule().forEach(Module::printState);
                System.out.println("Taught Modules  :");
                basicModel.get().getTaughtModulesID().forEach(x-> University.getInstance()
                                                                .getFormations().getModule(x).get().printState());
                System.out.println("Add taught Module  :");
                input = scanner.nextLine();
                matcher = pattern.matcher(input);
                if (input.equals("")) break;
                if (matcher.find()) {
                    basicModel.get().addModule(input);
                    break;
                }
            }

            basicModel = Optional.empty();
        }
        interact();
        return true;
    }
}
