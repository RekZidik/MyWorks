package model.manager;

import model.Group;
import model.Module;
import org.json.JSONObject;

/**
 * Created by RekZidik on 07/01/2016.
 */
public class GroupHandler extends Manager<Group> {

    private Module module;

    public GroupHandler(Module module) {
        this.module = module;
    }

    public Module getModule() {
        return module;
    }

    @Override
    public Group getModelInstance(JSONObject data) {
        return new Group();
    }

    @Override
    public boolean add(Group m) {
        return _add(m);
    }

    @Override
    public boolean remove(Group m) {
        return _remove(m);
    }
}
