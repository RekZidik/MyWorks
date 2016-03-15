package controler;

import model.Slot;
import model.University;
import model.manager.SlotsManager;

import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.time.Instant;
import java.util.Date;

/**
 * Created by RekZidik on 10/01/2016.
 */
public class AddSlotController extends BaseController<SlotsManager> {
    public AddSlotController(Controller father, SlotsManager model) {
        super(father, model);
        setRegexResponse("^((2[\\d]{3}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]/){2})([\\d\\s]/){2}[\\d\\s])|([\\d])$");
    }

    @Override
    protected void printMenu() {
        System.out.println("Date Begin(AAAA-MM-JJ HH:MM)/Date End/Ref Group/Ref Teacher/Ref Hall");
    }

    @Override
    protected boolean interact(String response) {
        if (matcher.group(0).equals("0"))
            getFather().get().interact();
        String[] tab = matcher.group(1).split("/");
        Date dateBegin=Date.from(Instant.MIN);
        Date dateEnd=Date.from(Instant.MAX);
        try {
            dateBegin = new SimpleDateFormat("yyyy/MM/dd hh:mm").parse(tab[0]);
            dateEnd = new SimpleDateFormat("yyyy/MM/dd hh:mm").parse(tab[1]);
        } catch (ParseException e) {
            e.printStackTrace();
        }
        Slot slot = new Slot(
                new Slot.Duration(dateBegin,dateEnd),
                University.getInstance().getFormations().getGroup(tab[2]).get(),
                University.getInstance().getTeachers().get(tab[3]).get(),
                University.getInstance().getBlocks().getHall(tab[4]).get()
        );
        return University.getInstance().getSlots().add(slot);
    }
}
