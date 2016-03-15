package model.manager;

import model.Model;
import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.Iterator;
import java.util.Optional;
import java.util.stream.Stream;

/**
 * Created by RekZidik on 26/12/2015.
 */
public abstract class  Manager<T extends Model> extends Model{
    private boolean flag = false;
    private ArrayList<T> list;


    public Manager() {
        super();
        list= new ArrayList<>();
    }

    @Override
    public void setLabel(String label) {
        this.label = label;
    }

    @Override
    public void setId(String id) {
        this.id = id;
    }

    protected boolean _add(T m) {
        return m != null && list.add(m);
    }

    protected boolean _remove(T m){
        return m != null && list.remove(m);
    }

    /**
     *
     * @return Number of Model objects managed
     */
    public Iterator<T> iterator(){
        return list.iterator();
    }

    public int length(){
        return list.size();
    }

    public void reset(){
        list.removeAll(list);
    }

    public boolean fromJSONArray(JSONArray array){
        reset();
        boolean result=true;
        for (int i = 0; i < array.length(); i++) {
            T item = getModelInstance(array.getJSONObject(i));
            result=result && item.fromJSON(array.getJSONObject(i)) && add(item);
        }
        return result;
    }

    public JSONArray toJSONArray(){
        JSONArray array = new JSONArray();
        for (Model aList : list) {
            array.put(aList.toJSON());
        }
        return array;
    }

    public Stream<T> stream(){
        return list.stream();
    }

    public boolean contains(String id){
        return stream().filter(x->x.getId().equals(id)).count()>0;
    }

    public boolean contains(T model){
        return list.contains(model);
    }

    /**
     *@return an instance of Model object managed
     */
    public abstract T getModelInstance(JSONObject data);

    /**
     * Add item to objects managed
     * @return Result of operation
     */
    public abstract boolean add(T m);

    /**
     * Remove item from objects managed
     * @return Result of operation
     */
    public abstract boolean remove(T m);

    /**
     * Remove item from Stream of Model
     * @return Result of operation
     */
    public boolean remove(Stream<T> stream){
        flag = false;
        stream.forEach(x->flag &= remove(x));
        return !flag;
    }

    /**
     * Add item from Stream of Model
     * @return Result of operation
     */
    public boolean add(Stream<T> stream){
        flag = false;
        stream.forEach(x->flag &= add(x));
        return !flag;
    }

    /**
     * @param id identifier of Model object
     * @return Un Optional object object contain the result of operation
     */
    public Optional<T> get(String id){
        for (T e: list) {
            if (e.getId().equals(id))
                return Optional.of(e);
        }
        return Optional.empty();
    }

    @Override
    public boolean fromJSON(JSONObject jsonObject) {
        return false;
    }

    @Override
    public JSONObject toJSON() {
        return null;
    }

    public void printGlobalStat(){
        //System.out.println(getLabel());
        System.out.println(getLabel().concat(" ".concat(String.valueOf(length()))));
    }

    @Override
    public void printState() {
        stream().forEach(Model::printState);
    }
}
