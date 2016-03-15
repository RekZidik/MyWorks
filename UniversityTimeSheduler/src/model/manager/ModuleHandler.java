package model.manager;

import model.Formation;
import model.Group;
import model.Module;
import org.json.JSONObject;

/**
 * Created by RekZidik on 05/01/2016.
 */
public class ModuleHandler extends Manager<Module>{

    private Formation formation;

    public ModuleHandler(Formation formation) {
        this.formation = formation;
    }

    public boolean contains(Group group){
        return stream().filter(x->x.contains(group)).count()>0;
    }

    public boolean containsGroup(String id){
        return stream().filter(x->x.containsGroup(id)).count()>0;
    }

    @Override
    public Module getModelInstance(JSONObject data) {
        return new Module();
    }

    @Override
    public boolean add(Module m) {
        return _add(m);
    }

    @Override
    public boolean remove(Module m) {
        return _remove(m);
    }


}
