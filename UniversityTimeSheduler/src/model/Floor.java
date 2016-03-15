package model;

import model.manager.HallsHandler;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.Iterator;
import java.util.stream.Stream;

/**
 * Created by RekZidik on 05/01/2016.
 */
public class Floor extends Model {

    private Block block;
    private HallsHandler halls;
    private int index;

    public Floor(String label,Block block) {
        this.label = block.getLabel().concat("_").concat(label);
        this.block = block;
        this.halls = new HallsHandler(this);
        this.index = (int) block.streamFloors().count();
    }

    public Floor() {
    }

    public Floor(String[] tab){
        this.block = University.getInstance().getBlocks().get(tab[1]).orElse(new Block("",1));
        this.label = block.getLabel().concat("_").concat(tab[0]);
        this.halls = new HallsHandler(this);
        this.index = (int) block.streamFloors().count();
    }

    public int getIndex() {
        return index;
    }

    public Block getBlock() {
        return block;
    }

    public Stream<Hall> streamHalls(){
        return halls.stream();
    }

    public boolean containsHall(String id){
       return halls.contains(id);
    }

    public boolean containsHall(Hall hall){
       return halls.contains(hall);
    }

    public Iterator<Hall> hallIterator(){
        return halls.iterator();
    }

    public boolean add(Stream<Hall> floorStream){
        return halls.add(floorStream);
    }

    @Override
    public void setLabel(String label) {
        this.label = label;
    }

    @Override
    public void setId(String id) {
        while (University.getInstance().getBlocks().containsFloor(id))
            id=generateId();
        this.id = id;
    }

    public HallsHandler getHalls(){
        return halls;
    }

    @Override
    public boolean fromJSON(JSONObject jsonObject) throws JSONException {
        setId(getString(jsonObject,"id",generateId()));
        setLabel(getString(jsonObject,"label",getLabel()));
        index = getInt(jsonObject,"index",0);
        block = University.getInstance().getBlocks().get(getString(jsonObject,"block","")).orElse(new Block("Block",1));
        halls.fromJSONArray(getJSONArray(jsonObject,"halls",new JSONArray()));
        return true;
    }

    @Override
    public JSONObject toJSON() {
        JSONObject data = new JSONObject();
        data.put("label", getLabel());
        data.put("id",getId());
        data.put("index",index);
        data.put("block",block.getId());
        data.put("halls",halls.toJSONArray());
        return data;
    }

    @Override
    public void printState() {
        System.out.println("Ref : ".concat(getId()));
        System.out.print(getLabel());
        System.out.println("  level : ".concat(String.valueOf(getIndex())));
    }
}
