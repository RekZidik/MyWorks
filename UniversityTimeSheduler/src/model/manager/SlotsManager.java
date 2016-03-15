package model.manager;

import model.*;
import org.json.JSONObject;

import java.util.stream.Stream;

/**
 * Created by RekZidik on 09/01/2016.
 */
public class SlotsManager extends Manager<Slot> {

    public Stream<Slot> stream(Teacher teacher){
        return stream().filter(x->x.getTeacher().getId().equals(teacher.getId()));
    }

    public Stream<Slot> stream(Formation formation){
        return stream().filter(x->x.getGroup().getFormation().getId().equals(formation.getId()));
    }

    public Stream<Slot> stream(Block block){
        return stream().filter(x->x.getBlock().getId().equals(block.getId()));
    }

    public Stream<Slot> stream(Floor floor){
        return stream().filter(x->x.getFloor().getId().equals(floor.getId()));
    }

    public Stream<Slot> stream(Module module){
        return stream().filter(x->x.getModule().getId().equals(module.getId()));
    }

    private boolean overlapCheck(Slot slot){
        return stream().filter(x->x.overlapWith(slot)).findFirst().isPresent();
    }

    @Override
    public Slot getModelInstance(JSONObject data) {
        return new Slot(new Slot.Duration(),new Group(),new Teacher(),new TDHall());
    }

    @Override
    public boolean add(Slot m) {
        return !overlapCheck(m) && _add(m);
    }

    @Override
    public boolean remove(Slot m) {
        return _remove(m);
    }
}
