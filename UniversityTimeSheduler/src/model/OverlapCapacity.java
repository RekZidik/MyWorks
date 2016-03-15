package model;

/**
 * Created by RekZidik on 06/01/2016.
 */
public interface OverlapCapacity<T extends Model> {
    public boolean overlapWith(T other);
}
