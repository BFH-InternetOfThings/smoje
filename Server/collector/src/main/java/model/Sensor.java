package model;

import java.io.Serializable;
import javax.persistence.*;


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

	@Column(name="station_id")
	private int stationId;

	private String status;

	@Column(name="stype_id")
	private int stypeId;

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

	public int getStationId() {
		return this.stationId;
	}

	public void setStationId(int stationId) {
		this.stationId = stationId;
	}

	public String getStatus() {
		return this.status;
	}

	public void setStatus(String status) {
		this.status = status;
	}

	public int getStypeId() {
		return this.stypeId;
	}

	public void setStypeId(int stypeId) {
		this.stypeId = stypeId;
	}

}