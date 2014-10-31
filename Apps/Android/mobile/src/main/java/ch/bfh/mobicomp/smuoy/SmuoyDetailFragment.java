package ch.bfh.mobicomp.smuoy;

import android.app.Fragment;
import android.os.Bundle;
import android.support.v7.widget.CardView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.LinearLayout;
import android.widget.TextView;
import ch.bfh.mobicomp.smuoy.dummy.DummyContent;

import java.util.HashMap;
import java.util.Map;

/**
 * A fragment representing a single Smuoy detail screen.
 * This fragment is either contained in a {@link SmuoyListActivity}
 * in two-pane mode (on tablets) or a {@link SmuoyDetailActivity}
 * on handsets.
 */
public class SmuoyDetailFragment extends Fragment {
    /**
     * The fragment argument representing the item ID that this fragment
     * represents.
     */
    public static final String ARG_ITEM_ID = "item_id";

    /**
     * The dummy content this fragment is presenting.
     */
    private DummyContent.Smuoy item;

    /**
     * Mandatory empty constructor for the fragment manager to instantiate the
     * fragment (e.g. upon screen orientation changes).
     */
    public SmuoyDetailFragment() {
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        if (getArguments().containsKey(ARG_ITEM_ID)) {
            // Load the dummy content specified by the fragment
            // arguments. In a real-world scenario, use a Loader
            // to load content from a content provider.
            item = DummyContent.ITEM_MAP.get(getArguments().getString(ARG_ITEM_ID));
        }
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        LinearLayout rootView = (LinearLayout) inflater.inflate(R.layout.fragment_smuoy_detail, container, false);

        // Show the dummy content as text in a TextView.
        if (item != null) {
            addCard(inflater, rootView, item.id);
            for (DummyContent.SensorData sensor : item.sensorData) {
                addCard(inflater, rootView, sensor);
            }
        }

        return rootView;
    }

    private void addCard(LayoutInflater inflater, ViewGroup parentView, CharSequence text) {
        CardView card = (CardView) inflater.inflate(R.layout.data_card_basic, parentView, false);

        TextView titleText = (TextView) card.findViewById(R.id.text);
        titleText.setText(text);

        parentView.addView(card);
    }

    private void addCard(LayoutInflater inflater, ViewGroup parentView, DummyContent.SensorData sensor) {
        CardView card;
        if ("wind".equalsIgnoreCase(sensor.getGroup())) {
            card = getCard(inflater, parentView, R.layout.data_card_wind, false);
        } else {
            card = getCard(inflater, parentView, R.layout.data_card_basic, true);
            setText(card, R.id.text, sensor.toString());
        }
        parentView.addView(card);
    }

    private Map<Integer, CardView> cardViews = new HashMap<>();
    private CardView getCard(LayoutInflater inflater, ViewGroup parentView, int id, boolean forceNew){
        CardView card = cardViews.get(id);
        if (forceNew || card == null) {
            card = (CardView) inflater.inflate(id, parentView, false);
        }
        return card;
    }

    private void setText(View parent, int id, CharSequence text) {
        ((TextView) parent.findViewById(id)).setText(text);
    }
}
