package ch.bfh.iot.smoje.agent.model;

import java.io.Serializable;
import javax.persistence.*;
import java.sql.Timestamp;


/**
 * The persistent class for the measurement database table.
 * 
 */
@Entity
@Table(name="measurement")
@NamedQuery(name="Measurement.findAll", query="SELECT m FROM Measurement m")
public class Measurement implements Serializable {
	private static final long serialVersionUID = 1L;

	@Id
	@SequenceGenerator(name="MEASUREMENT_ID_GENERATOR" )
	@GeneratedValue(strategy=GenerationType.SEQUENCE, generator="MEASUREMENT_ID_GENERATOR")
	private int id;

	private Timestamp timestamp;

	private String value;

	//bi-directional many-to-one association to Sensor
	@ManyToOne
	private Sensor sensor;

	//bi-directional many-to-one association to Station
	@ManyToOne
	private Station station;

	public Measurement() {
	}

	public int getId() {
		return this.id;
	}

	public void setId(int id) {
		this.id = id;
	}

	public Timestamp getTimestamp() {
		return this.timestamp;
	}

	public void setTimestamp(Timestamp timestamp) {
		this.timestamp = timestamp;
	}

	public String getValue() {
		return this.value;
	}

	public void setValue(String value) {
		this.value = value;
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