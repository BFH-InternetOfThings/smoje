package ch.bfh.iot.smoje.agent.model;

import java.io.Serializable;
import java.sql.Timestamp;

import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.ManyToOne;
import javax.persistence.NamedQuery;
import javax.persistence.SequenceGenerator;
import javax.persistence.Table;


/**
 * The persistent class for the alert database table.
 * 
 */
@Entity
@Table(name="alert")
@NamedQuery(name="Alert.findAll", query="SELECT a FROM Alert a")
public class Alert implements Serializable {
	private static final long serialVersionUID = 1L;

	@Id
	@SequenceGenerator(name="ALERT_ID_GENERATOR" )
	@GeneratedValue(strategy=GenerationType.SEQUENCE, generator="ALERT_ID_GENERATOR")
	private int id;

	private String message;

	private Timestamp timestamp;

	//bi-directional many-to-one association to Sensorstation
	@ManyToOne
	private Sensorstation sensorstation;

	public Alert() {
	}

	public int getId() {
		return this.id;
	}

	public void setId(int id) {
		this.id = id;
	}

	public String getMessage() {
		return this.message;
	}

	public void setMessage(String message) {
		this.message = message;
	}

	public Timestamp getTimestamp() {
		return this.timestamp;
	}

	public void setTimestamp(Timestamp timestamp) {
		this.timestamp = timestamp;
	}

	public Sensorstation getSensorstation() {
		return this.sensorstation;
	}

	public void setSensorstation(Sensorstation sensorstation) {
		this.sensorstation = sensorstation;
	}

}