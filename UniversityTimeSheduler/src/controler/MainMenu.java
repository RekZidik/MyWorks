package controler;

import model.Block;
import model.Formation;
import model.Teacher;
import model.University;
import model.manager.FormationsManager;

import java.io.FileNotFoundException;
import java.io.PrintWriter;
import java.io.UnsupportedEncodingException;


/**
 * Created by RekZidik on 07/01/2016.
 */
public class MainMenu extends BaseController<University> {


    public MainMenu(Controller father,University university) {
        super(father,university);
        setHook(false);
        activateSaveMode();
    }




    @Override
    public void printMenu() {
        System.out.println("1: Manage Formations.");
        System.out.println("2: Manage Teachers.");
        System.out.println("3: Manage Blocks.");
        System.out.println("4: Manage Slots.");
    }



    protected boolean interact(String response) {
        switch (Integer.valueOf(response)){
            case 1:
                (new ManageFormationsController(
                        this,
                        getModel().getFormations(),
                        new AddModelController.ConfigDisplay("^([\\w\\s]+/[\\d]+)|([\\d])$","Formation naming/Students","/"))
                ).interact();
                return true;

            case 2:
                (new ManageTeachersController(
                        this,
                        getModel().getTeachers(),
                        new AddModelController.ConfigDisplay("^(([\\w\\s]+/){2}[\\d]+)|([\\d])$","Name/First Name/Grade(N°)","/"))
                ).interact();
                return true;

            case 3:
                (new ManageBlocksController(
                        this,
                        getModel().getBlocks(),
                        new AddModelController.ConfigDisplay("^([\\w\\s]+/[\\d]+)|([\\d])$","Label/Number of levels","/"))
                ).interact();
                return true;

            case 4:
                (new ManageSlotsController(this,getModel().getSlots())).interact();
                return true;

            case 5:
                //TODO implementer le travail de gestion d'une salle en selectionnant le niveau auquel elle appartient
                return true;

            case 6:
                //TODO implementer le travail de gestion d'un module en selectionnant le niveau auquel elle appartient
                return true;


        }
        return false;

    }

}
