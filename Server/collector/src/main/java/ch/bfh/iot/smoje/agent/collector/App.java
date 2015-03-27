package ch.bfh.iot.smoje.agent.collector;

import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.sql.Timestamp;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;
import java.util.List;

import javax.persistence.EntityManager;
import javax.persistence.Persistence;
import javax.ws.rs.client.Client;
import javax.ws.rs.client.ClientBuilder;
import javax.ws.rs.client.WebTarget;
import javax.ws.rs.core.MediaType;

import org.apache.commons.codec.binary.Base64;
import org.apache.logging.log4j.LogManager;
import org.apache.logging.log4j.Logger;

import ch.bfh.iot.smoje.agent.model.Measurement;
import ch.bfh.iot.smoje.agent.model.Sensor;
import ch.bfh.iot.smoje.agent.model.Sensorstation;
import ch.bfh.iot.smoje.agent.model.Station;

import com.fasterxml.jackson.core.JsonProcessingException;
import com.fasterxml.jackson.databind.JsonNode;
import com.fasterxml.jackson.databind.ObjectMapper;

/**
 * Agent 007
 *
 */
public class App {
    private static final Logger logger = LogManager.getLogger();

    public static void main(String[] args) {
        EntityManager em = Persistence.createEntityManagerFactory("collector").createEntityManager();

        logger.info("START: Getting stations ");

        List<Station> stations = em.createQuery("SELECT s FROM Station s").getResultList();

        for (Station station : stations) {
            
            List<Sensorstation> sensorStations = em.createQuery("SELECT s FROM Sensorstation s WHERE s.station = ?1 and s.active = 1 ")
                .setParameter(1, station).getResultList();

            for (Sensorstation sensorStation : sensorStations) {
                // todo check if request is necessary

                Timestamp lastTimestamp = (Timestamp) em.createQuery("select max(m.timestamp) from Measurement m where m.station = ?1 and m.sensor = ?2")
                    .setParameter(1, sensorStation.getStation())
                    .setParameter(2, sensorStation.getSensor())
                    .getSingleResult();
                
                
                Calendar lastCal = null;
                
                // On first measurement, lastTimestamp is null
                if(lastTimestamp != null) {
                    lastCal = Calendar.getInstance();
                    lastCal.setTime(lastTimestamp);
                    lastCal.add(Calendar.MINUTE, sensorStation.getDelay());
                }


                boolean read = lastCal == null || lastCal.before(Calendar.getInstance());
                logger.info("Sensor " + sensorStation.getSensor().getName() + " doRead: " + read);

                if (read) {
	            Sensor sensor = sensorStation.getSensor();
                    int sensorType = sensor.getId();
                    switch (sensorType) {
                    case 1: // camera
                            writePhoto(em, station, sensor);
                        break;
                    case 9: // GPS
                        // writeLocation(em, station, sensor);
                        break;

                    default:
                        writeSensor(em, station, sensor);
                        break;
                    }
                }
            }
        }
        
        logger.info("END: Collector finished");

    }

    private static void writeLocation(EntityManager em, Station station, Sensor sensor) {

        Client client = ClientBuilder.newBuilder().build();
        WebTarget target = client.target(station.getUrlNetmodule());
        String res = target.request(MediaType.APPLICATION_JSON).get(String.class);
        ObjectMapper mapper = new ObjectMapper();

        try {
            JsonNode json = mapper.readTree(res);

            Timestamp date = new Timestamp(0);

            Measurement measurement = new Measurement();

            measurement.setTimestamp(date);
            measurement.setValue(json.get("latitude").asText() + ";" + json.get("longitude").asText());
            measurement.setSensor(sensor);
            measurement.setStation(station);

            em.getTransaction().begin();
            em.persist(measurement);
            em.getTransaction().commit();

        } catch (JsonProcessingException e) {
            logger.catching(e);
        } catch (IOException e) {
            logger.catching(e);;
        }
    }

    private static void writeSensor(EntityManager em, Station station, Sensor sensor) {
        
        logger.info("START write sensor " + sensor.getName());

        Client client = ClientBuilder.newBuilder().build();
        WebTarget target = client.target(station.getUrlSensor() + sensor.getName());
        String res = target.request(MediaType.APPLICATION_JSON).get(String.class);
        ObjectMapper mapper = new ObjectMapper();

        try {
            JsonNode json = mapper.readTree(res);

            Measurement measurement = new Measurement();
            measurement.setValue(json.get("value").toString().replaceAll("\"", ""));
            measurement.setTimestamp(new Timestamp(new Date().getTime()));
            // todo alert if unit is no the same as in
            // json.get("unit").asText());
            measurement.setStation(station);
            measurement.setSensor(sensor);

            em.getTransaction().begin();
            em.persist(measurement);
            em.getTransaction().commit();

        } catch (JsonProcessingException e) {
            logger.catching(e);
        } catch (IOException e) {
            logger.catching(e);
        }
        logger.info("END write sensor " + sensor.getName());
    }

    private static void writePhoto(EntityManager em, Station station, Sensor sensor) {
        
        logger.info("START writing Photo");

        ObjectMapper mapper = new ObjectMapper();

        Client client = ClientBuilder.newBuilder().build();
        WebTarget target = client.target(station.getUrlSensor() + sensor.getName());

        logger.info(target.getUri());

        String res = target.request(MediaType.APPLICATION_JSON).get(String.class);
        JsonNode json = null;
        try {
            json = mapper.readTree(res);
        } catch (JsonProcessingException e) {
            logger.catching(e);
        } catch (IOException e) {
            logger.catching(e);
        }

        Measurement measurement = new Measurement();

        // create file
        JsonNode value = json.get("value");
        byte[] data = Base64.decodeBase64(value.asText());

        SimpleDateFormat df = new SimpleDateFormat("yyyy-MM-dd_HH:mm:ss");
        String filename = df.format(new Date()) + ".jpg";
        logger.info(filename);

        // TODO: in properties verschieben
        String path = "/var/www/img/";

        measurement.setValue(filename);

        try (FileOutputStream stream = new FileOutputStream(path + filename)){
            stream.write(data);
        } catch (FileNotFoundException e) {
            logger.catching(e);
        } catch (IOException e) {
            logger.catching(e);
        } 

        measurement.setTimestamp(new Timestamp(new Date().getTime()));
        measurement.setStation(station);
        measurement.setSensor(sensor);

        em.getTransaction().begin();
        em.persist(measurement);
        em.getTransaction().commit();
        
        logger.info("END: Writeing Photo");
    }
}