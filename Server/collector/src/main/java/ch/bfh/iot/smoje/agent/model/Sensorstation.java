package ch.bfh.iot.smoje.agent.model;

import java.io.Serializable;
import javax.persistence.*;
import java.util.List;


/**
 * The persistent class for the sensorstation database table.
 * 
 */
@Entity
@Table(name="sensorstation")
@NamedQuery(name="Sensorstation.findAll", query="SELECT s FROM Sensorstation s")
public class Sensorstation implements Serializable {
	private static final long serialVersionUID = 1L;

	@Id
	@SequenceGenerator(name="SENSORSTATION_ID_GENERATOR" )
	@GeneratedValue(strategy=GenerationType.SEQUENCE, generator="SENSORSTATION_ID_GENERATOR")
	private int id;

	private int active;

	private int delay;

	//bi-directional many-to-one association to Alert
	@OneToMany(mappedBy="sensorstation")
	private List<Alert> alerts;

	//bi-directional many-to-one association to Sensor
	@ManyToOne
	private Sensor sensor;

	//bi-directional many-to-one association to Station
	@ManyToOne
	private Station station;

	public Sensorstation() {
	}

	public int getId() {
		return this.id;
	}

	public void setId(int id) {
		this.id = id;
	}

	public int getActive() {
		return this.active;
	}

	public void setActive(int active) {
		this.active = active;
	}

	public int getDelay() {
		return this.delay;
	}

	public void setDelay(int delay) {
		this.delay = delay;
	}

	public List<Alert> getAlerts() {
		return this.alerts;
	}

	public void setAlerts(List<Alert> alerts) {
		this.alerts = alerts;
	}

	public Alert addAlert(Alert alert) {
		getAlerts().add(alert);
		alert.setSensorstation(this);

		return alert;
	}

	public Alert removeAlert(Alert alert) {
		getAlerts().remove(alert);
		alert.setSensorstation(null);

		return alert;
	}

	public Sensor getSensor() {
		return this.sensor;
	}

	public void setSensor(Sensor sensor) {
		this.sensor = sensor;
	}

	public Station getStation() {
		return this.station;
	}

	public void setStation(Station station) {
		this.station = station;
	}

}