package model;

import model.manager.BlocksManager;
import model.manager.FormationsManager;
import model.manager.SlotsManager;
import model.manager.TeachersManager;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.Optional;

/**
 * Created by RekZidik on 06/01/2016.
 */
public class University extends Model{

    static private University university;

    private BlocksManager blocks;
    private FormationsManager formations;
    private TeachersManager teachers;
    private SlotsManager slots;

    private University() {
        blocks = new BlocksManager();
        formations = new FormationsManager();
        teachers = new TeachersManager();
        slots = new SlotsManager();
    }

    @Override
    public void setLabel(String label) {
        this.label = label;
    }

    @Override
    public void setId(String id) {
    }

    public Optional<Model> get(String st){
        if (blocks.getId().equals(st))
            return Optional.of(blocks);
        if (teachers.getId().equals(st))
            return Optional.of(teachers);
        if (formations.getId().equals(st))
            return Optional.of(blocks);
        if (slots.getId().equals(st))
            return Optional.of(blocks);
        return Optional.empty();
    }


    public BlocksManager getBlocks() {
        return blocks;
    }

    public FormationsManager getFormations() {
        return formations;
    }

    public TeachersManager getTeachers() {
        return teachers;
    }

    public SlotsManager getSlots() {
        return slots;
    }

    @Override
    public boolean fromJSON(JSONObject jsonObject) throws JSONException {
        setLabel(getString(jsonObject,"name","UPEC"));
        blocks.fromJSONArray(getJSONArray(jsonObject,"blocks",blocks.toJSONArray()));
        formations.fromJSONArray(getJSONArray(jsonObject,"formations",formations.toJSONArray()));
        teachers.fromJSONArray(getJSONArray(jsonObject,"teachers",teachers.toJSONArray()));
        slots.fromJSONArray(getJSONArray(jsonObject,"slots",slots.toJSONArray()));
        return true;
    }

    @Override
    public JSONObject toJSON() {
        JSONObject data = new JSONObject();
        data.put("name",label);
        data.put("blocks",blocks.toJSONArray());
        data.put("formations",formations.toJSONArray());
        data.put("teachers",teachers.toJSONArray());
        data.put("slots",slots.toJSONArray());
        return data;
    }

    @Override
    public void printState() {

        System.out.println(getLabel());
        System.out.print("Formations : ".concat(String.valueOf(getFormations().length())));
        System.out.print(" Blocks : ".concat(String.valueOf(getBlocks().length())));
        System.out.print(" Teachers : ".concat(String.valueOf(getTeachers().length())));
        System.out.print(" Students : ");
        System.out.println(
                        getFormations()
                        .stream().mapToInt(Formation::getStudents)
                        .reduce(0,(x,y)-> x+y)
        );
    }


    public static University getInstance(){
        if(university == null){
            university = new University();
            return university;
        }
        else
            return university;
    }
}
