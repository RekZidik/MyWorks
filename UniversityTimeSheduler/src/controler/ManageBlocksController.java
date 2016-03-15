package controler;

import model.Block;
import model.Floor;
import model.manager.HallsHandler;
import model.manager.Manager;
import org.json.JSONObject;

import java.util.Optional;
import java.util.regex.Pattern;

/**
 * Created by RekZidik on 17/01/2016.
 */
public class ManageBlocksController extends ManageModelsController<Block> {
    public ManageBlocksController(Controller father, Manager<Block> model, AddModelController.ConfigDisplay configDisplay) {
        super(father, model, configDisplay);
    }

    @Override
    protected boolean forManageItem() {
        //TODO implementer le travail de modification d'un bâtiment
        if (basicModel.isPresent()) {
            pattern = Pattern.compile("[\\w]+");
            while (true) {
                System.out.println("Label(".concat(basicModel.get().getLabel()).concat(") :"));
                input = scanner.nextLine();
                matcher = pattern.matcher(input);
                if (input.equals("") ) break;
                if ( matcher.find()){
                    basicModel.get().setLabel(input);
                    break;
                }
            }

            pattern = Pattern.compile("[\\d]+");
            long count = basicModel.get().streamFloors().count();
            while (true) {
                System.out.println("Add floors(".concat(String.valueOf(count)).concat(") :"));
                input = scanner.nextLine();
                matcher = pattern.matcher(input);
                if (input.equals("")) break;
                if (matcher.find()){
                    count = Integer.valueOf(input);
                    for (int i = 0; i < count; i++)
                        basicModel.get().addFloor(new Floor());
                    count = basicModel.get().streamFloors().count();
                }
            }

            while (true) {
                System.out.println("Remove floors (".concat(String.valueOf(count).concat(") :")));
                input = scanner.nextLine();
                matcher = pattern.matcher(input);
                if (input.equals("")) break;
                if (matcher.find()){
                    count = Integer.valueOf(input);
                    for (int i = 0; i < count; i++)
                        basicModel.get().removeFloor();
                    count = basicModel.get().streamFloors().count();
                }
            }
            pattern = Pattern.compile("[Yes|YES|y|Y]");
            while (true) {
                count = basicModel.get().streamHalls().count();
                System.out.println("Manage Halls (".concat(String.valueOf(count).concat(")[Y|N] :")));
                input = scanner.nextLine();
                matcher = pattern.matcher(input);
                if (input.equals("")) break;
                if (matcher.find()){
                    Optional<Floor> floor ;
                    while (true) {
                        basicModel.get().streamFloors().forEach(Floor::printState);
                        pattern = Pattern.compile("^[\\d]+$");
                        System.out.println("Select floor :");
                        input = scanner.nextLine();
                        matcher = pattern.matcher(input);
                        floor = basicModel.get().streamFloors().filter(x->x.getId().equals(input)).findFirst();
                        if (input.equals("")) break;
                        if (floor.isPresent()) {
//                            HallsHandler manager = new HallsHandler(floor.get());
//                            JSONObject data = floor.get().toJSON();
//                            manager.add(basicModel.get().streamHalls());
//                            manager.setLabel(basicModel.get().getLabel().concat(" Halls"));
                            (new ManageHallsController(this,
                                    floor.get().getHalls(),
                                    new AddModelController.ConfigDisplay(
                                            "^((".concat(floor.get().getId()).concat(")/[\\d]+/[Y|N](/[\\d]+){2})|([\\d])$")
                                            , "Ref level:".concat(floor.get().getId()).concat("/capacity/have projector(Y|N)/Outlets/Seance Type")
                                            , "/")))
                                    .interact();
//                            data.put("halls",manager.toJSONArray());
//                            floor.get().fromJSON(data);
                            break;
                        }
                    }
                }
            }

            basicModel = Optional.empty();
        }

    interact();
    return true;
    }
}
