package model.manager;

import model.Formation;
import model.Group;
import model.Module;
import model.University;
import org.json.JSONObject;

import java.util.Optional;
import java.util.stream.Collector;
import java.util.stream.Stream;

/**
 * Created by RekZidik on 07/01/2016.
 */
public class FormationsManager extends Manager<Formation> {

    public Stream<Group> streamGroup(){
        return  stream()
                .flatMap(Formation::stream)
                .flatMap(Module::stream);
    }

    public Stream<Module> streamModule(){
        return  stream()
                .flatMap(Formation::stream);
    }

    public Optional<Group> getGroup(String id){
        return streamGroup().filter(x->x.getId().equals(id)).findFirst();
    }

    public Optional<Module> getModule(String id){
        return streamModule().filter(x->x.getId().equals(id)).findFirst();
    }

    public boolean contains(Module module){
        return stream().filter(x->x.contains(module)).findFirst().isPresent();
    }

    public boolean contains(Group group){
        return stream().filter(x->x.contains(group)).findFirst().isPresent();
    }

    public boolean containsModule(String id){
        return stream().filter(x->x.containsModule(id)).findFirst().isPresent();
    }

    public boolean containsGroup(String id){
        return stream().filter(x->x.containsGroup(id)).findFirst().isPresent();
    }

    public FormationsManager() {
        setLabel("Formations");
    }

    @Override
    public Formation getModelInstance(JSONObject data) {
        return new Formation(getLabel(),"-1");
    }

    @Override
    public boolean add(Formation m) {
        return _add(m);
    }

    @Override
    public boolean remove(Formation m) {
        return University.getInstance()
                    .getSlots()
                    .stream(m)
                    .filter(x->x.getModule().getFormation().getId().equals(m.getId()))
                    .count() <= 0
                &&
                _remove(m);
    }
}
