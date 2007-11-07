package net.sourceforge.queried;

/**
 * Player information that is returned by the player query.
 * 
 * Any numerical values are set to <code>-9999</code> by default.  If the value is
 * still <code>-9999</code> after the query it means that no such value was returned;
 * for example <i>kills</i> are the only value returned on a Halflife query, so <i>deaths</i> 
 * will always be <code>-9999</code>
 * 
 * @author DeadEd
 */
public class PlayerInfo {

	private String name = "";
    private int kills = -9999;
    private int deaths = -9999;
    private int score = -9999;
    private int objectivesCompleted = -9999;
	
	public PlayerInfo() {
	}
    
    /**
     * Get the number of deaths for this player.
     * 
     * @return number of times this player has died.
     */
    public int getDeaths() {
        return deaths;
    }

    /**
     * Get the number of kills for this player.
     * 
     * @return the number of times this player has made a kill.
     */
    public int getKills() {
        return kills;
    }

    /**
     * Get the name of this player.
     * 
     * @return the name of this player.
     */
    public String getName() {
        return name;
    }

    /**
     * Get the number of objectives that this player has completed.
     * 
     * @return the number of objectives completed by this player.
     */
    public int getObjectivesCompleted() {
        return objectivesCompleted;
    }

    /**
     * Get the score of this player.
     * 
     * @return the score of this player.
     */
    public int getScore() {
        return score;
    }

    public void setDeaths(int i) {
        deaths = i;
    }

    public void setKills(int i) {
        kills = i;
    }

    public void setName(String string) {
        name = string;
    }

    public void setObjectivesCompleted(int i) {
        objectivesCompleted = i;
    }

    public void setScore(int i) {
        score = i;
    }

}
