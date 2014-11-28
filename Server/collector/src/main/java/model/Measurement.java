package model;

import java.io.Serializable;
import javax.persistence.*;
import java.util.Date;


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
	@GeneratedValue(strategy=GenerationType.SEQUENCE)
	private int id;

	private String name;

	@Temporal(TemporalType.DATE)
	private Date timestamp;

	private String unit;

	@Column(name="value_float")
	private float valueFloat;

	@Column(name="value_string")
	private String valueString;

	//bi-directional many-to-one association to Sensor
	@ManyToOne
	private Sensor sensor;

	public Measurement() {
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

	public Date getTimestamp() {
		return this.timestamp;
	}

	public void setTimestamp(Date timestamp) {
		this.timestamp = timestamp;
	}

	public String getUnit() {
		return this.unit;
	}

	public void setUnit(String unit) {
		this.unit = unit;
	}

	public float getValueFloat() {
		return this.valueFloat;
	}

	public void setValueFloat(float valueFloat) {
		this.valueFloat = valueFloat;
	}

	public String getValueString() {
		return this.valueString;
	}

	public void setValueString(String valueString) {
		this.valueString = valueString;
	}

	public Sensor getSensor() {
		return this.sensor;
	}

	public void setSensor(Sensor sensor) {
		this.sensor = sensor;
	}

}