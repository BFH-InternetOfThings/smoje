package ch.bfh.iot.smoje.agent.collector;

import java.io.FileOutputStream;
import java.io.IOException;
import java.util.Date;
import java.util.List;

import javax.persistence.EntityManager;
import javax.persistence.Persistence;
import javax.ws.rs.client.Client;
import javax.ws.rs.client.ClientBuilder;
import javax.ws.rs.client.WebTarget;
import javax.ws.rs.core.MediaType;

import model.Measurement;
import model.Sensor;
import model.Station;

import org.apache.commons.codec.binary.Base64;

import com.fasterxml.jackson.core.JsonProcessingException;
import com.fasterxml.jackson.databind.JsonNode;
import com.fasterxml.jackson.databind.ObjectMapper;

/**
 * Agent 007
 *
 */
public class App 
{

    public static void main( String[] args )
    {
        EntityManager em = Persistence.createEntityManagerFactory("collector").createEntityManager();
        
        List<Station> stations = em.createQuery(
                "SELECT s FROM Station s").getResultList();
        
        for (Station station : stations){
            List<Sensor> sensors = em.createQuery(
                    "SELECT s FROM Sensor s").getResultList();
        	
            for(Sensor sensor : sensors){
            	//todo check if request is necessary
            	if(true){
                  
            		int sensorType = sensor.getSensortype().getId();
            		switch (sensorType) {
					case 7: // camera
//						try {
//							writePhoto(em, station, sensor);
//						} catch (JsonProcessingException e1) {
//							// TODO Auto-generated catch block
//							e1.printStackTrace();
//						} catch (IOException e1) {
//							// TODO Auto-generated catch block
//							e1.printStackTrace();
//						}
						break;

					case 8: // GPS
//						writeLocation(em, station, sensor);
						break;
						
					default:
						writeSensor(em, station, sensor);
						break;
					}
            	}
            }
        }
    }
    
    private static void writeLocation(EntityManager em, Station station, Sensor sensor) {
		
  	    Client client = ClientBuilder.newBuilder().build();              
        WebTarget target = client.target(station.getUrlNetmodule());           
        String res = target.request(MediaType.APPLICATION_JSON).get(String.class);
        ObjectMapper mapper = new ObjectMapper();
                
        try {
            JsonNode json = mapper.readTree(res);
                              
            java.util.Date date = new java.util.Date();
            
            Measurement measurement = new Measurement();
            measurement.setName(json.get("id").asText());
            
            measurement.setTimestamp(date);
            measurement.setValueString(json.get("latitude").asText() + ";" + json.get("longitude").asText());
            measurement.setUnit("latitude/longitude");
            measurement.setSensor(sensor);
            
            em.getTransaction().begin();
            em.persist(measurement);
            em.getTransaction().commit();
            
                        
        } catch (JsonProcessingException e) {
            // TODO Auto-generated catch block
            e.printStackTrace();
        } catch (IOException e) {
            // TODO Auto-generated catch block
            e.printStackTrace();
        }
	}

	private static void writeSensor(EntityManager em, Station station, Sensor sensor) {
			
  	    Client client = ClientBuilder.newBuilder().build();              
        WebTarget target = client.target(station.getUrlSensor() + sensor.getName());           
        String res = target.request(MediaType.APPLICATION_JSON).get(String.class);
        ObjectMapper mapper = new ObjectMapper();
                
        try {
            JsonNode json = mapper.readTree(res);
                              
            java.util.Date date = new java.util.Date();
            
            Measurement measurement = new Measurement();
            measurement.setName(json.get("id").asText());
            measurement.setValueFloat((float)json.get("value").asDouble()); // todo optimize            
            measurement.setTimestamp(date);
            measurement.setUnit(json.get("unit").asText());
            measurement.setSensor(sensor);
            
            em.getTransaction().begin();
            em.persist(measurement);
            em.getTransaction().commit();
            
                        
        } catch (JsonProcessingException e) {
            // TODO Auto-generated catch block
            e.printStackTrace();
        } catch (IOException e) {
            // TODO Auto-generated catch block
            e.printStackTrace();
        }
	}

	private static void writePhoto(EntityManager em, Station station, Sensor sensor) throws JsonProcessingException, IOException {
        
        ObjectMapper mapper = new ObjectMapper();
        
        Client client = ClientBuilder.newBuilder().build();
        WebTarget target = client.target(station.getUrlSensor() + "/" + sensor.getName()); 
        String res = target.request(MediaType.APPLICATION_JSON).get(String.class);
        JsonNode json = mapper.readTree(res);
        
        Measurement measurement = new Measurement();
        measurement.setName(json.get("id").asText());
        
        // create file
        JsonNode value = json.get("value");
        byte[] data = Base64.decodeBase64(value.asText());
        
        System.out.println(value.asText());
        
        String filename = new Date().toString() + ".jpg";
        System.out.println(filename);
        
        String path = "/var/www/img/";
        
        measurement.setValueString(path + filename);         
        
        FileOutputStream stream = new FileOutputStream(path + filename); 
        try { stream.write(data); 
        } finally { 
        	stream.close(); }

        measurement.setTimestamp(new java.util.Date());
        measurement.setUnit(json.get("unit").asText());
        measurement.setSensor(sensor);
        
        em.getTransaction().begin();
        em.persist(measurement);
        em.getTransaction().commit();
    }
}