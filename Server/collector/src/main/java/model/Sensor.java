package model;

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
	@GeneratedValue(strategy=GenerationType.AUTO)
	private int id;

	private int delay;

	private String description;

	private String name;

	private String status;

	//bi-directional many-to-one association to Alert
	@OneToMany(mappedBy="sensor")
	private List<Alert> alerts;

	//bi-directional many-to-one association to Measurement
	@OneToMany(mappedBy="sensor")
	private List<Measurement> measurements;

	//bi-directional many-to-one association to Sensortype
	@ManyToOne
	@JoinColumn(name="stype_id")
	private Sensortype sensortype;

	//bi-directional many-to-one association to Station
	@ManyToOne
	private Station station;

	public Sensor() {
	}

	public int getId() {
		return this.id;
	}

	public void setId(int id) {
		this.id = id;
	}

	public int getDelay() {
		return this.delay;
	}

	public void setDelay(int delay) {
		this.delay = delay;
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

	public String getStatus() {
		return this.status;
	}

	public void setStatus(String status) {
		this.status = status;
	}

	public List<Alert> getAlerts() {
		return this.alerts;
	}

	public void setAlerts(List<Alert> alerts) {
		this.alerts = alerts;
	}

	public Alert addAlert(Alert alert) {
		getAlerts().add(alert);
		alert.setSensor(this);

		return alert;
	}

	public Alert removeAlert(Alert alert) {
		getAlerts().remove(alert);
		alert.setSensor(null);

		return alert;
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

	public Sensortype getSensortype() {
		return this.sensortype;
	}

	public void setSensortype(Sensortype sensortype) {
		this.sensortype = sensortype;
	}

	public Station getStation() {
		return this.station;
	}

	public void setStation(Station station) {
		this.station = station;
	}

}