package model.manager;

import model.Floor;
import model.Hall;
import model.TDHall;
import model.TPHall;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.stream.Collectors;

/**
 * Created by RekZidik on 09/01/2016.
 */
public class HallsHandler extends Manager<Hall> {

    private Floor floor;


    public HallsHandler(Floor floor) {
        this.floor = floor;
    }

    @Override
    public Hall getModelInstance(JSONObject data) {
        switch (getInt(data,"seanceType",111)){
            case Hall.TP_FLAG:
                return new TPHall();

            default:
                return new TDHall();
        }
    }


    @Override
    public boolean add(Hall m) {
        return _add(m);
    }

    @Override
    public boolean remove(Hall m) {
        return _remove(m);
    }
}
