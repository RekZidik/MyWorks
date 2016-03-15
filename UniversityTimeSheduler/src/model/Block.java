package model;

import model.manager.FloorsHandler;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.Iterator;
import java.util.Optional;
import java.util.stream.Stream;

/**
 * Created by RekZidik on 05/01/2016.
 */
public class Block extends Model {
    private FloorsHandler floors ;

    public Block(String label, int height) {
        this.label = label;
        initFloors(height);
    }

    public Block(String[] tab) {
        this.label = tab[0];
        initFloors((Integer.valueOf(tab[1])>0)?Integer.valueOf(tab[1]):1);
    }

    private void initFloors(int length){
        this.floors = new FloorsHandler(this);
        for (int i = 0; i < length; i++) {
            floors.add(new Floor("L".concat(String.valueOf(i)),this));
        }
    }

    public boolean addFloor(Floor floor){
        return floors.add(floor);
    }

    public boolean removeFloor(){
        floors.unstack();
        return true;
    }


    public Optional<Hall> getHall(String id){
        return floors.getHall(id);
    }

    public Stream<Floor> streamFloors(){
        return floors.stream();
    }

    public Stream<Hall> streamHalls(){
        return floors.stream().flatMap(Floor::streamHalls);
    }

    public boolean containsFloor(String id){
        return floors.contains(id);
    }

    public boolean contains(Floor floor){
        return floors.contains(floor);
    }

    public boolean containsHall(String id){
        return floors.stream().filter(x->x.containsHall(id)).findFirst().isPresent();
    }

    public boolean contains(Hall hall){
        return floors.stream().filter(x->x.containsHall(hall)).findFirst().isPresent();
    }

    @Override
    public void setLabel(String label) {
        this.label = label;
    }

    @Override
    public void setId(String id) {
        while (University.getInstance().getBlocks().contains(id))
            id=generateId();
        this.id = id;
    }

    @Override
    public boolean fromJSON(JSONObject jsonObject) throws JSONException {
        setId(getString(jsonObject,"id",generateId()));
        setLabel(getString(jsonObject,"label",getLabel()));
//        Iterator<Floor> it = floors.iterator();
//        while(it.hasNext()) {
//            it.remove();
//        }
        floors.fromJSONArray(getJSONArray(jsonObject,"floors",new JSONArray()));
        return true;
    }

    @Override
    public JSONObject toJSON() {
        JSONObject data = new JSONObject();
        data.put("label", getLabel());
        data.put("id",getId());
        data.put("floors",floors.toJSONArray());
        return data;
    }

    @Override
    public void printState() {
        System.out.println("Ref :".concat(getId()));
        System.out.println(label);
    }
}
