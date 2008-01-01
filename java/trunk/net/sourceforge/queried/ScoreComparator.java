package net.sourceforge.queried;

import java.util.Comparator;

public class ScoreComparator implements Comparator {

    public ScoreComparator() {
    }

    public int compare(Object obj1, Object obj2) {
        PlayerInfo playerInfo1 = (PlayerInfo) obj1;
        PlayerInfo playerInfo2 = (PlayerInfo) obj2;

        if(playerInfo1.getScore() < playerInfo2.getScore()) {
            return 1;
        }

        return playerInfo1.getScore() <= playerInfo2.getScore() ? 0 : -1;
    }
}
