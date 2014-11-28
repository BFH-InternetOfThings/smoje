package model;

import java.io.Serializable;
import javax.persistence.*;
import java.util.List;


/**
 * The persistent class for the sensortype database table.
 * 
 */
@Entity
@Table(name="sensortype")
@NamedQuery(name="Sensortype.findAll", query="SELECT s FROM Sensortype s")
public class Sensortype implements Serializable {
	private static final long serialVersionUID = 1L;

	@Id
	@GeneratedValue(strategy=GenerationType.AUTO)
	private int id;

	private String description;

	private String name;

	private String unit;

	//bi-directional many-to-one association to Sensor
	@OneToMany(mappedBy="sensortype")
	private List<Sensor> sensors;

	public Sensortype() {
	}

	public int getId() {
		return this.id;
	}

	public void setId(int id) {
		this.id = id;
	}

	public String getDescription() {
		return this.description;
	}

	public void setDescription(String description) {
		this.description = description;
	}

	public String getName() {
		return this.name;
	}

	public void setName(String name) {
		this.name = name;
	}

	public String getUnit() {
		return this.unit;
	}

	public void setUnit(String unit) {
		this.unit = unit;
	}

	public List<Sensor> getSensors() {
		return this.sensors;
	}

	public void setSensors(List<Sensor> sensors) {
		this.sensors = sensors;
	}

	public Sensor addSensor(Sensor sensor) {
		getSensors().add(sensor);
		sensor.setSensortype(this);

		return sensor;
	}

	public Sensor removeSensor(Sensor sensor) {
		getSensors().remove(sensor);
		sensor.setSensortype(null);

		return sensor;
	}

}