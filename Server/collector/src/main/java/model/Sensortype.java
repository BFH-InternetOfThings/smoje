package model;

import java.io.Serializable;
import javax.persistence.*;


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

}