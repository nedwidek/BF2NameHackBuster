package info.raycaster.nhb;
import java.lang.String;

import java.util.Hashtable;

public class NameCache {
    private Hashtable cache;

    public NameCache() {
        cache = new Hashtable();
    }

    public void addPlayerNames(String pid, PlayerNames player) {
        cache.put(pid, player);
    }

    public boolean containsPlayer(String pid) {
        return cache.containsKey(pid);
    }

    public PlayerNames getPlayerNames(String pid) {
        return (PlayerNames) cache.get(pid);
    }
}
