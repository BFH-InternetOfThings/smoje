package ch.bfh.iot.smoje.agent.model;

import java.io.Serializable;
import javax.persistence.*;
import java.util.List;


/**
 * The persistent class for the displaytype database table.
 * 
 */
@Entity
@Table(name="displaytype")
@NamedQuery(name="Displaytype.findAll", query="SELECT d FROM Displaytype d")
public class Displaytype implements Serializable {
	private static final long serialVersionUID = 1L;

	@Id
	@SequenceGenerator(name="DISPLAYTYPE_ID_GENERATOR" )
	@GeneratedValue(strategy=GenerationType.SEQUENCE, generator="DISPLAYTYPE_ID_GENERATOR")
	private int id;

	private String name;

	//bi-directional many-to-one association to Sensor
	@OneToMany(mappedBy="displaytype")
	private List<Sensor> sensors;

	public Displaytype() {
	}

	public int getId() {
		return this.id;
	}

	public void setId(int id) {
		this.id = id;
	}

	public String getName() {
		return this.name;
	}

	public void setName(String name) {
		this.name = name;
	}

	public List<Sensor> getSensors() {
		return this.sensors;
	}

	public void setSensors(List<Sensor> sensors) {
		this.sensors = sensors;
	}

	public Sensor addSensor(Sensor sensor) {
		getSensors().add(sensor);
		sensor.setDisplaytype(this);

		return sensor;
	}

	public Sensor removeSensor(Sensor sensor) {
		getSensors().remove(sensor);
		sensor.setDisplaytype(null);

		return sensor;
	}

}