package model;

import model.manager.ModuleHandler;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.Iterator;
import java.util.stream.Stream;

/**
 * Created by RekZidik on 27/12/2015.
 */
public class Formation extends Model{
    public static final int MAX_SIZE_GROUP =20;
    private static int nbrInstances;
    private String nomination;
    private int students;
    private ModuleHandler modules;


    public Formation(String nomination, String students) {
        this.nomination = nomination;
        this.modules = new ModuleHandler(this);
        setStudents(Integer.valueOf(students));
        this.label = generateLabel(nomination);
        setId(generateId());
        nbrInstances++;
    }

    public Formation(String[] tab) {
        this.nomination = tab[0];
        this.modules = new ModuleHandler(this);
        setStudents(Integer.valueOf(tab[1]));
        this.label = generateLabel(nomination);
        setId(generateId());
        nbrInstances++;
    }

    public Formation() {
    }

    public boolean contains(Group group){
        return modules.contains(group);
    }

    public boolean contains(Module module){
        return modules.contains(module);
    }

    public Iterator<Module> iterator() {
        return modules.iterator();
    }

    public Stream<Module> stream(){
        return modules.stream();
    }

    public boolean containsGroup(String id){
        return modules.containsGroup(id);
    }

    public boolean containsModule(String id){
        return modules.contains(id);
    }

    @Override
    public void setLabel(String label) {
        this.label = label;
    }

    @Override
    public void setId(String id) {
        while (University.getInstance().getFormations().contains(id))
            id=generateId();
        this.id = id;
    }

    public String getNomination() {
        return nomination;
    }

    public void setNomination(String nomination) {
        this.nomination = nomination;
    }

    public int getStudents() {
        return students;
    }

    public void setStudents(int students) {
        modules.stream().filter(x->!x.isOptional()).forEach(x->x.setStudents(students));
        this.students = students;
    }

    private String generateLabel(String nomination){
        String[] tab = nomination.split(" ");
        String id= "";
        for (String st : tab){
                id=id.concat(String.valueOf(st.charAt(0)).toUpperCase()).concat("_");
        }
        return id.concat(String.valueOf(nbrInstances));
    }

    public ModuleHandler getModules(){
        return modules;
    }



    @Override
    public String getId() {
        return id;
    }

    @Override
    public boolean fromJSON(JSONObject jsonObject) throws JSONException {
        setId(getString(jsonObject,"id",generateId()));
        setLabel(getString(jsonObject,"label",getLabel()));
        nomination = getString(jsonObject,"nomination",getLabel());
        students = getInt(jsonObject,"students",0);
        modules.fromJSON(getJSONObject(jsonObject,"modules",new JSONObject()));
        return true;
    }

    @Override
    public JSONObject toJSON() {
        JSONObject data = new JSONObject();
        data.put("label", getLabel());
        data.put("id",getId());
        data.put("nomination",getNomination());
        data.put("students",getStudents());
        data.put("modules",modules.toJSON());
        return data;
    }

    @Override
    public void printState() {
        System.out.println("References :".concat(getId()));
        System.out.println("Nomination :".concat(getNomination()).concat(" Students:").concat(String.valueOf(getStudents())));
    }
}
