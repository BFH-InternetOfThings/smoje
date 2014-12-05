package ch.bfh.iot.smoje.agent.collector;

import java.io.FileOutputStream;
import java.io.IOException;
import java.util.Date;

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
        Station station = em.find(Station.class, 6); // 6 = JLaw
        Client client = ClientBuilder.newBuilder().build();
        
        
        WebTarget target = client.target(station.getUrlSensor() + "/tempAir"); 
        
        String res = target.request(MediaType.APPLICATION_JSON).get(String.class);
        
        ObjectMapper mapper = new ObjectMapper();
        
        
        
        
        try {
            JsonNode json = mapper.readTree(res);
//            JsonNode jsonNode = json.get("value");
            
//            System.out.println(jsonNode.asText());
            
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
            
            
            writePhoto(em, station);
            
        } catch (JsonProcessingException e) {
            // TODO Auto-generated catch block
            e.printStackTrace();
        } catch (IOException e) {
            // TODO Auto-generated catch block
            e.printStackTrace();
        }
        
        
        
    }
    private static void writePhoto(EntityManager em, Station station) throws JsonProcessingException, IOException {
        Sensor sensor = em.find(Sensor.class, 10); // 10 = mockCamera Sensor
        
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
        
        String path = "/www/img/";
        
//        measurement.setValueFloat((float)json.get("value").asDouble()); // ugly as fuck --> todo optimize 
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