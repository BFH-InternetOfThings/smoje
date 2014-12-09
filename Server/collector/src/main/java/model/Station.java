package model;

import java.io.Serializable;
import javax.persistence.*;


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
	@GeneratedValue(strategy=GenerationType.SEQUENCE)
	private int id;

	private String description;

	private String name;

	@Column(name="url_netmodule")
	private String urlNetmodule;

	@Column(name="url_sensor")
	private String urlSensor;

	@Column(name="url_tissan")
	private String urlTissan;

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

}