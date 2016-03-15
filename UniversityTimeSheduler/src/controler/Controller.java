package controler;


import java.util.Optional;


/**
 * Created by RekZidik on 04/01/2016.
 */
public interface Controller {

    public Optional<Controller> getFather();
    public void interact();

}
