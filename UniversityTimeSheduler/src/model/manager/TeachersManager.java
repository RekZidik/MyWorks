package model.manager;

import model.Teacher;
import model.University;
import org.json.JSONObject;

/**
 * Created by RekZidik on 27/12/2015.
 */
public class TeachersManager extends Manager<Teacher> {

    public TeachersManager() {
        label = "Teachers";
    }

    @Override
    public Teacher getModelInstance(JSONObject data) {
        return new Teacher();
    }

    @Override
    public boolean add(Teacher m) {
        return _add(m);
    }

    @Override
    public boolean remove(Teacher m) {
        return University.getInstance()
                    .getSlots()
                    .stream(m)
                    .filter(x->x.getTeacher().getId().equals(m.getId()))
                    .count() <= 0
                    &&
                _remove(m);
    }

    @Override
    public void printGlobalStat() {
        super.printGlobalStat();
        System.out.println("Naming Grades");
        for (int i = 0; i <Teacher.GRADES.size() ; i++) {
            System.out.println(i+":"+Teacher.GRADES.get(i));
        }
    }
}
