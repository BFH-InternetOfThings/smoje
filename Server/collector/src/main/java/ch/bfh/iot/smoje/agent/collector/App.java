package ch.bfh.iot.smoje.agent.collector;

import ch.bfh.iot.smoje.agent.model.Measurement;
import ch.bfh.iot.smoje.agent.model.Sensor;
import ch.bfh.iot.smoje.agent.model.Sensorstation;
import ch.bfh.iot.smoje.agent.model.Station;
import com.fasterxml.jackson.core.JsonProcessingException;
import com.fasterxml.jackson.databind.JsonNode;
import com.fasterxml.jackson.databind.ObjectMapper;
import org.apache.commons.codec.binary.Base64;

import javax.persistence.EntityManager;
import javax.persistence.Persistence;
import javax.ws.rs.client.Client;
import javax.ws.rs.client.ClientBuilder;
import javax.ws.rs.client.WebTarget;
import javax.ws.rs.core.MediaType;
import java.io.FileOutputStream;
import java.io.IOException;
import java.sql.Timestamp;
import java.util.Date;
import java.util.List;

/**
 * Agent 007
 *
 */
public class App {

    public static void main(String[] args) {
        EntityManager em = Persistence.createEntityManagerFactory("collector").createEntityManager();

        List<Station> stations = em.createQuery("SELECT s FROM Station s").getResultList();

        for (Station station : stations) {
            List<Sensorstation> sensorStations = em.createQuery("SELECT s FROM Sensorstation s WHERE s.station = ?1")
		            .setParameter(1, station).getResultList();

            for (Sensorstation sensorStation : sensorStations) {
                // todo check if request is necessary

                // Measurement lastMeasurement = (Measurement)
                // em.createQuery("select max(m.timestamp) from Measurement m where m.sensorstation = :mySensorstation")
                // .setParameter("mySensorstation", sensorStation)
                // .getSingleResult();

                // lastMeasurement.getTimestamp() + sensorStation.getDelay() <=
                // Calendar lastCal = Calendar.getInstance();
                // lastCal.setTime(lastMeasurement.getTimestamp());
                // lastCal.add(Calendar.MINUTE, sensorStation.getDelay());
                //
                // boolean read = lastCal.before(Calendar.getInstance());
                //
                // System.out.println(read);
                //
                if (true) {
	                Sensor sensor = sensorStation.getSensor();
                    int sensorType = sensor.getId();
                    switch (sensorType) {
                    case 1: // camera
                        try {
                            writePhoto(em, station, sensor);
                        } catch (JsonProcessingException e1) {
                            // TODO Auto-generated catch block
                            e1.printStackTrace();
                        } catch (IOException e1) {
                            // TODO Auto-generated catch block
                            e1.printStackTrace();
                        }
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

            Measurement measurement = new Measurement();
            measurement.setValue(json.get("value").toString());
            measurement.setTimestamp(new Timestamp(new Date().getTime()));
            // todo alert if unit is no the same as in
            // json.get("unit").asText());
            measurement.setStation(station);
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
        WebTarget target = client.target(station.getUrlSensor() + sensor.getName());

        System.out.println(target.getUri());

        String res = target.request(MediaType.APPLICATION_JSON).get(String.class);
        JsonNode json = mapper.readTree(res);

        Measurement measurement = new Measurement();

        // create file
        JsonNode value = json.get("value");
        byte[] data = Base64.decodeBase64(value.asText());

        System.out.println(value.asText());

        // TODO: File naming
        String filename = new Date().toString() + ".jpg";
        System.out.println(filename);

        // TODO: in properties verschieben
        String path = "/var/www/img/";

        measurement.setValue(path + filename);

        FileOutputStream stream = new FileOutputStream(path + filename);
        try {
            stream.write(data);
        } finally {
            stream.close();
        }

        System.out.println(new Timestamp(new Date().getTime()));
        measurement.setTimestamp(new Timestamp(new Date().getTime()));
        measurement.setStation(station);

        em.getTransaction().begin();
        em.persist(measurement);
        em.getTransaction().commit();
    }
}