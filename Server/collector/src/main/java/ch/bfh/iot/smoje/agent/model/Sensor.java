package ch.bfh.iot.smoje.agent.model;

import java.io.Serializable;
import javax.persistence.*;
import java.util.List;


/**
 * The persistent class for the sensor database table.
 * 
 */
@Entity
@Table(name="sensor")
@NamedQuery(name="Sensor.findAll", query="SELECT s FROM Sensor s")
public class Sensor implements Serializable {
	private static final long serialVersionUID = 1L;

	@Id
	@SequenceGenerator(name="SENSOR_ID_GENERATOR" )
	@GeneratedValue(strategy=GenerationType.SEQUENCE, generator="SENSOR_ID_GENERATOR")
	private int id;

	private String description;

	private String name;

	private int sortorder;

	private String title;

	private String unit;

	//bi-directional many-to-one association to Measurement
	@OneToMany(mappedBy="sensor")
	private List<Measurement> measurements;

	//bi-directional many-to-one association to Displaytype
	@ManyToOne
	private Displaytype displaytype;

	//bi-directional many-to-one association to Sensorstation
	@OneToMany(mappedBy="sensor")
	private List<Sensorstation> sensorstations;

	public Sensor() {
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

	public int getSortorder() {
		return this.sortorder;
	}

	public void setSortorder(int sortorder) {
		this.sortorder = sortorder;
	}

	public String getTitle() {
		return this.title;
	}

	public void setTitle(String title) {
		this.title = title;
	}

	public String getUnit() {
		return this.unit;
	}

	public void setUnit(String unit) {
		this.unit = unit;
	}

	public List<Measurement> getMeasurements() {
		return this.measurements;
	}

	public void setMeasurements(List<Measurement> measurements) {
		this.measurements = measurements;
	}

	public Measurement addMeasurement(Measurement measurement) {
		getMeasurements().add(measurement);
		measurement.setSensor(this);

		return measurement;
	}

	public Measurement removeMeasurement(Measurement measurement) {
		getMeasurements().remove(measurement);
		measurement.setSensor(null);

		return measurement;
	}

	public Displaytype getDisplaytype() {
		return this.displaytype;
	}

	public void setDisplaytype(Displaytype displaytype) {
		this.displaytype = displaytype;
	}

	public List<Sensorstation> getSensorstations() {
		return this.sensorstations;
	}

	public void setSensorstations(List<Sensorstation> sensorstations) {
		this.sensorstations = sensorstations;
	}

	public Sensorstation addSensorstation(Sensorstation sensorstation) {
		getSensorstations().add(sensorstation);
		sensorstation.setSensor(this);

		return sensorstation;
	}

	public Sensorstation removeSensorstation(Sensorstation sensorstation) {
		getSensorstations().remove(sensorstation);
		sensorstation.setSensor(null);

		return sensorstation;
	}

}