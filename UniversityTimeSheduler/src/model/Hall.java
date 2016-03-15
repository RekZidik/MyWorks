package model;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.logging.Level;

/**
 * Created by RekZidik on 01/12/2015.
 */
public abstract class Hall extends Model implements HallSpecification {
    private static int nbrInstances = 1;
    public static final int COUR_FLAG= 1;
    public static final int TD_FLAG=10;
    public static final int TP_FLAG=100;

    private  int seanceType;
    private boolean projector;
    private int capacity;
    private Floor localisation;

    public Hall(Floor localisation, int capacity, boolean projector, int seanceType ) {
        this.capacity = capacity;
        this.projector = projector;
        this.localisation = localisation;
        this.label = localisation.getLabel().concat(String.valueOf(nbrInstances++));
        this.seanceType = seanceType;
    }

    public Hall() {
        localisation = new Floor();
        fromJSON(new JSONObject());
    }

    public Hall(String[] tab) {
        this.localisation = University.getInstance().getBlocks().getFloor(tab[0]).orElse(new Floor());
        this.capacity = Integer.valueOf(tab[1]);
        this.projector = Boolean.parseBoolean(tab[2]);
        this.label = localisation.getLabel().concat(String.valueOf(nbrInstances++));
        this.seanceType = Integer.valueOf(tab[tab.length-1]);
        //TODO Continue implementation of constructor
    }




    @Override
    public void setLabel(String label) {
        this.label = label;
    }

    @Override
    public void setId(String id) {
        while (University.getInstance().getBlocks().containsHall(id))
            id=generateId();
        this.id = id;
    }

    public int getCapacity() {
        return capacity;
    }

    public boolean isProjector() {
        return projector;
    }

    public Floor getLocalisation() {
        return localisation;
    }

    public boolean isValidForTd(){
        return (seanceType & TD_FLAG) > 0;
    }

    public boolean isValidForTp(){
        return (seanceType & TP_FLAG) > 0;
    }

    public boolean isValidForCour(){
        return (seanceType & COUR_FLAG) > 0;
    }

    @Override
    public boolean fromJSON(JSONObject jsonObject) throws JSONException {
        setId(getString(jsonObject,"id",generateId()));
        setLabel(getString(jsonObject,"label",getLabel()));
        seanceType = getInt(jsonObject,"seanceType",COUR_FLAG);
        capacity = getInt(jsonObject,"capacity",0);
        localisation = University.getInstance().getBlocks().getFloor(getString(jsonObject,"localisation","")).orElse(new Floor());
        projector = getBoolean(jsonObject,"projector",false);
        label = getString(jsonObject,"label",getLabel());
        return true;
    }

    @Override
    public JSONObject toJSON() {
        JSONObject data = new JSONObject();
        data.put("label", getLabel());
        data.put("id",getId());
        data.put("seanceType",seanceType);
        data.put("capacity",capacity);
        data.put("projector",projector);
        data.put("label",label);
        data.put("localisation",localisation.getId());
        return data;
    }

    @Override
    public void printState() {
        System.out.println("Ref :".concat(getId()));
        System.out.println(getLabel());
    }
}
