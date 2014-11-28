package ch.bfh.iot.smoje.agent.collector;

import java.io.IOException;

import javax.persistence.EntityManager;
import javax.persistence.Persistence;
import javax.ws.rs.client.Client;
import javax.ws.rs.client.ClientBuilder;
import javax.ws.rs.client.WebTarget;
import javax.ws.rs.core.MediaType;

import com.fasterxml.jackson.core.JsonProcessingException;
import com.fasterxml.jackson.databind.JsonNode;
import com.fasterxml.jackson.databind.ObjectMapper;

import model.Measurement;
import model.Sensor;
import model.Station;

/**
 * Agent 007
 *
 */
public class App 
{
    public static void main( String[] args )
    {
        EntityManager em = Persistence.createEntityManagerFactory("collector").createEntityManager();
        Station station = em.find(Station.class, 6); // 6 = JLaw
        
    	Client client = ClientBuilder.newBuilder().build();
    	
    	WebTarget target = client.target(station.getUrlSensor()); 
    	
    	String res = target.request(MediaType.APPLICATION_JSON).get(String.class);
    	
    	ObjectMapper mapper = new ObjectMapper();
    	try {
            JsonNode json = mapper.readTree(res);
            JsonNode jsonNode = json.get("value");
            
            System.out.println(jsonNode.asText());
            
        	Sensor sensor = em.find(Sensor.class, 7); // 7 = tempAir Sensor
        	java.util.Date date = new java.util.Date();
        	
        	Measurement measurement = new Measurement();
        	measurement.setName(json.get("id").asText());
        	measurement.setValueFloat((float)json.get("value").asDouble()); // ugly as fuck --> todo optimize        	
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
}
