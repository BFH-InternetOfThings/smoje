package ch.bfh.iot.smoje.agent.model;

import java.io.Serializable;
import javax.persistence.*;
import java.util.List;


/**
 * The persistent class for the station database table.
 * 
 */
@Entity
@Table(name="station")
@NamedQuery(name="Station.findAll", query="SELECT s FROM Station s")
public class Station implements Serializable {
	private static final long serialVersionUID = 1L;

	@Id
	@SequenceGenerator(name="STATION_ID_GENERATOR" )
	@GeneratedValue(strategy=GenerationType.SEQUENCE, generator="STATION_ID_GENERATOR")
	private int id;

	private String description;

	private String name;

	@Column(name="url_netmodule")
	private String urlNetmodule;

	@Column(name="url_sensor")
	private String urlSensor;

	@Column(name="url_tissan")
	private String urlTissan;

	//bi-directional many-to-one association to Measurement
	@OneToMany(mappedBy="station")
	private List<Measurement> measurements;

	//bi-directional many-to-one association to Sensorstation
	@OneToMany(mappedBy="station")
	private List<Sensorstation> sensorstations;

	public Station() {
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

	public String getUrlNetmodule() {
		return this.urlNetmodule;
	}

	public void setUrlNetmodule(String urlNetmodule) {
		this.urlNetmodule = urlNetmodule;
	}

	public String getUrlSensor() {
		return this.urlSensor;
	}

	public void setUrlSensor(String urlSensor) {
		this.urlSensor = urlSensor;
	}

	public String getUrlTissan() {
		return this.urlTissan;
	}

	public void setUrlTissan(String urlTissan) {
		this.urlTissan = urlTissan;
	}

	public List<Measurement> getMeasurements() {
		return this.measurements;
	}

	public void setMeasurements(List<Measurement> measurements) {
		this.measurements = measurements;
	}

	public Measurement addMeasurement(Measurement measurement) {
		getMeasurements().add(measurement);
		measurement.setStation(this);

		return measurement;
	}

	public Measurement removeMeasurement(Measurement measurement) {
		getMeasurements().remove(measurement);
		measurement.setStation(null);

		return measurement;
	}

	public List<Sensorstation> getSensorstations() {
		return this.sensorstations;
	}

	public void setSensorstations(List<Sensorstation> sensorstations) {
		this.sensorstations = sensorstations;
	}

	public Sensorstation addSensorstation(Sensorstation sensorstation) {
		getSensorstations().add(sensorstation);
		sensorstation.setStation(this);

		return sensorstation;
	}

	public Sensorstation removeSensorstation(Sensorstation sensorstation) {
		getSensorstations().remove(sensorstation);
		sensorstation.setStation(null);

		return sensorstation;
	}

}