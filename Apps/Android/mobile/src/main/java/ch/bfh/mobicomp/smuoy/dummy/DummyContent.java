package ch.bfh.mobicomp.smuoy.dummy;

import java.util.*;

/**
 * Helper class for providing sample content for user interfaces created by
 * Android template wizards.
 * <p/>
 * TODO: Replace all uses of this class before publishing your app.
 */
public class DummyContent {

    /**
     * An array of sample (dummy) items.
     */
    public static List<Smuoy> ITEMS = new ArrayList<>();

    /**
     * A map of sample (dummy) items, by ID.
     */
    public static Map<String, Smuoy> ITEM_MAP = new HashMap<>();

    static {
        // Add 3 sample items.
        addItem(new Smuoy("1: Adelpha",
                new SensorData("Temperature", null, 5.34562674176, "°C"),
                new SensorData("Speed", "Wind", 12.13457556848, "km/h"),
                new SensorData("Direction", "Wind", 32.265723, "°")));
        addItem(new Smuoy("2: Bob",
                new SensorData("Speed", "Wind", 12.13457556848, "km/h")));
        addItem(new Smuoy("3: Celestia",
                new SensorData("Direction", "Wind", 32.265723, "°")));
    }

    private static void addItem(Smuoy item) {
        ITEMS.add(item);
        ITEM_MAP.put(item.id, item);
    }

    /**
     * A dummy item representing a piece of content.
     */
    public static class Smuoy {
        public String id;

        public List<SensorData> sensorData = new LinkedList<>();

        public Smuoy(String id, SensorData... data) {
            this.id = id;
            for (SensorData d : data) {
                sensorData.add(d);
            }
        }

        @Override
        public String toString() {
            return id;
        }
    }

    public static class SensorData {
        public String sensor;
        public String group;
        public double value;
        public String unit;

        public SensorData(String sensor, String group, double value, String unit) {
            this.sensor = sensor;
            this.value = value;
            this.unit = unit;
        }

        public String getGroup() {
            return group;
        }

        @Override
        public String toString() {
            return String.format("%1$s:\t%2$.2f%3$s", sensor, value, unit);
        }
    }
}
