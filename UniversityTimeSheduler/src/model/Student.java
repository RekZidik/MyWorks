package model;

import org.json.JSONObject;

/**
 * Created by RekZidik on 01/12/2015.
 */
public abstract class Student extends Model {

    private String id;
    @Override
    public String getId() {
        return id;
    }

    @Override
    public boolean fromJSON(JSONObject jsonObject) {
        return false;
    }

    @Override
    public JSONObject toJSON() {
        return null;
    }


    @Override
    public void printState() {

    }

}
