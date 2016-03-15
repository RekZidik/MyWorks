package model;

import org.json.JSONException;
import org.json.JSONObject;

import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;

/**
 * Created by RekZidik on 05/01/2016.
 */
public class Slot extends Model implements OverlapCapacity<Slot>{

    private Duration duration;
    private Group group;
    private Teacher teacher;
    private Hall hall;

    public Slot(Duration duration, Group group, Teacher teacher, Hall hall) {
        this.duration = duration;
        this.group = group;
        this.teacher = teacher;
        this.hall = hall;
    }

    @Override
    public void setLabel(String label) {
        this.label = label;
    }

    @Override
    public void setId(String id) {
        while (University.getInstance().getSlots().contains(id))
            id=generateId();
        this.id = id;
    }

    public Duration getDuration() {
        return duration;
    }

    public void setDuration(Duration duration) {
        this.duration = duration;
    }

    public Group getGroup() {
        return group;
    }

    public void setGroup(Group group) {
        this.group = group;
    }

    public Teacher getTeacher() {
        return teacher;
    }

    public void setTeacher(Teacher teacher) {
        this.teacher = teacher;
    }

    public Hall getHall() {
        return hall;
    }

    public void setHall(Hall hall) {
        this.hall = hall;
    }

    public Module getModule(){
        return getGroup().getModule();
    }

    public Floor getFloor(){
        return getHall().getLocalisation();
    }

    public Block getBlock(){
        return getHall().getLocalisation().getBlock();
    }

    @Override
    public boolean fromJSON(JSONObject jsonObject) throws JSONException {
        setId(getString(jsonObject,"id",generateId()));
        setLabel(getString(jsonObject,"label",getLabel()));
        teacher = University.getInstance().getTeachers().get(getString(jsonObject,"teacher","")).get();
        group = University.getInstance().getFormations().getGroup(getString(jsonObject,"teacher","")).get();
        hall = University.getInstance().getBlocks().getHall(getString(jsonObject,"teacher","")).get();
        duration.fromJSON(getJSONObject(jsonObject,"duration",new JSONObject()));
        return true;
    }

    @Override
    public JSONObject toJSON() {
        JSONObject data = new JSONObject();
        data.put("label", getLabel());
        data.put("id",getId());
        data.put("teacher",teacher.getId());
        data.put("group",group.getId());
        data.put("hall",hall.getId());
        data.put("duration",duration.toJSON());
        return data;
    }

    @Override
    public void printState() {
        duration.printState();
        System.out.print("/Teacher :".concat(getTeacher().getName()));
        System.out.print("/Group :".concat(Group.translateType(getGroup().getType())).concat(String.valueOf(getGroup().getIndex())));
        System.out.print("/Formation :".concat(getGroup().getFormation().getNomination()));
        System.out.print("/Hall :".concat(String.valueOf(getHall().getLabel())));

    }

    @Override
    public boolean overlapWith(Slot other) {
        return duration.overlapWith(other.getDuration())
                &&
                (
                                getGroup().getId().equals(other.getGroup().getId())
                        ||
                                getHall().getId().equals(other.getHall().getId())
                        ||
                                getTeacher().getId().equals(other.getTeacher().getId())
                );
    }

    public static class Duration extends Model implements OverlapCapacity<Duration>{
        private String endText;
        private String beginText;
        private Date begin;
        private Date end;

        public Duration(Date begin, Date end) {
            if(begin.getTime()<end.getTime()) {
                this.begin = begin;
                this.end = end;
            }
            else {
                this.begin = end;
                this.end = begin;
            }
        }

        public Duration() {
        }

        public boolean overlapWith(Duration duration){
            return getBegin().compareTo(duration.getEnd()) > 0 || getEnd().compareTo(duration.getBegin()) < 0;
        }

        public Date getBegin() {
            return begin;
        }

        public void setBegin(Date begin) {
            if (begin.compareTo(this.end) < 0)
                this.begin = begin;
            else{
                this.begin = end;
                this.end = begin;
            }
        }

        public Date getEnd() {
            return end;
        }

        public void setEnd(Date end) {
            if (end.compareTo(this.begin) > 0)
                this.end = end;
            else {
                this.end = begin;
                this.begin = end;
            }
        }


        public void setLabel(String label) {
            this.label = label;
        }

        @Override
        public void setId(String id) {
            this.id = id;
        }

        @Override
        public boolean fromJSON(JSONObject jsonObject) throws JSONException {
            try {
                end = new SimpleDateFormat("yyyy/MM/dd hh:mm").parse(getString(jsonObject,"end","2050/01/01 20:00"));
                endText = getString(jsonObject,"end","2050/01/01 20:00");
                begin = new SimpleDateFormat("yyyy/MM/dd hh:mm").parse(getString(jsonObject,"begin","2000/01/01 20:00"));
                beginText = getString(jsonObject,"begin","2000/01/01 20:00");
            } catch (ParseException e) {
                e.printStackTrace();
                return false;
            }
            return true;
        }

        @Override
        public JSONObject toJSON() {
            JSONObject data = new JSONObject();
            data.put("begin",beginText);
            data.put("end",endText);
            return data;
        }

        @Override
        public void printState() {
            System.out.print(begin+"-->"+end);
        }
    }
}
