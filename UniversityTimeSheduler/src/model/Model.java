package model;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

/**
 * "Model" is the base class to inherit all of the Model objects.
 */
public abstract class Model {
    protected String label;
    protected String id;


    public Model() {
        setId(generateId());
        setLabel("Unknown");
    }

    /**
     *
     * @return Unique identifier of object
     */
    public String getId() {
        return id;
    }

    public abstract void setLabel(String label) ;

    public abstract void setId(String id) ;


    /**
     *
     * @return Public name of object
     */
    public String getLabel() {
        return label;
    }

    protected static String generateId() {
        return String.valueOf((int)(Math.random()*100000000))+String.valueOf((int)(Math.random()*1000000000));
    }

    static public String getString(JSONObject data ,String name,String p_default) {
        try {
            return data.getString(name);
        } catch (JSONException e) {
            return p_default;
        }

    }
    static public boolean getBoolean(JSONObject data, String name,boolean p_default) {
        try {
            return data.getBoolean(name);
        } catch (JSONException e) {
            return p_default;
        }

    }
    static public int getInt(JSONObject data, String name, int p_default) {
        try {
            return data.getInt(name);
        } catch (JSONException e) {
            return p_default;
        }

    }
    static public double getDouble(JSONObject data, String name, double p_default) {
        try {
            return data.getInt(name);
        } catch (JSONException e) {
            return p_default;
        }

    }

    static public JSONObject getJSONObject(JSONObject data, String name, JSONObject p_default) {
        try {
            return data.getJSONObject(name);
        } catch (JSONException e) {
            return p_default;
        }

    }

    static public JSONObject getJSONObjectByIndex(JSONArray data, int i, JSONObject p_default) {
        try {
            return data.getJSONObject(i);
        } catch (JSONException e) {
            return p_default;
        }

    }

    static public JSONArray getJSONArray(JSONObject data, String name, JSONArray p_default) {
        try {
            return data.getJSONArray(name);
        } catch (JSONException e) {
            return p_default;
        }

    }



    /**
     *@param jsonObject
     * JSON representation of Object Model
     *@return
     * boolean result of initialisation with parameter
     */
    public abstract boolean fromJSON(JSONObject jsonObject) throws JSONException;


    /**
     *
     * @return
     * JSON representation of Model Object
     */
    public abstract JSONObject toJSON();

    /**
     * Print in the standard Output state object
     */
    public abstract void printState();
}
