package model;

/**
 * Created by RekZidik on 17/01/2016.
 */
public interface HallSpecification {
    public int getCapacity();

    public boolean isProjector();

    public Floor getLocalisation();

    public boolean isValidForTd();

    public boolean isValidForTp();

    public boolean isValidForCour();
}
