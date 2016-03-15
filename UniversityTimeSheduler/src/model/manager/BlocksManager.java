package model.manager;

import model.Block;
import model.Floor;
import model.Hall;
import org.json.JSONObject;

import java.util.Optional;
import java.util.stream.Stream;

/**
 * Created by RekZidik on 07/01/2016.
 */
public class BlocksManager extends Manager<Block> {

    public BlocksManager() {
        label = "Blocks";
    }

    public boolean containsHall(String id){
        return stream().filter(x->x.containsHall(id)).count()>0;
    }

    public boolean contains(Hall hall){
        return stream().filter(x->x.contains(hall)).count()>0;
    }

    public boolean containsFloor(String id){
        return stream().filter(x->x.containsFloor(id)).count()>0;
    }

    public boolean contains(Floor floor){
        return stream().filter(x->x.contains(floor)).count()>0;
    }

    public Stream<Hall> streamHalls(){
        return stream().flatMap(Block::streamHalls);
    }

    public Stream<Floor> streamFloors(){
        return stream().flatMap(Block::streamFloors);
    }

    public Optional<Hall> getHall(String id){
        return streamHalls().filter(x->x.getId().equals(id)).findFirst();
    }

    public Optional<Floor> getFloor(String id){
        return streamFloors().filter(x->x.getId().equals(id)).findFirst();
    }

    @Override
    public Block getModelInstance(JSONObject data) {
        return new Block(getLabel(),1);
    }

    @Override
    public boolean add(Block m) {
        return _add(m);
    }

    @Override
    public boolean remove(Block m) {
        return _remove(m);
    }
}
