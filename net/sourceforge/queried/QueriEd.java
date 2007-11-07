package net.sourceforge.queried;

import java.util.ArrayList;
import java.util.HashMap;

import net.sourceforge.queried.gametypes.BF2ServerInfo;

/**
 * Query a game server.<br/>
 * <br/>
 * Query a game server for server details and player information.<br/>
 * <br/>
 * Server types supported:
 * <ul>
 *   <li>Americas Army (AA)</li>
 *   <li>Battlefield 1942 (BF1942)</li>
 *   <li>Battlefield 2 (BF2)</li>
 *   <li>Battlefield Vietnam (BFV)</li>
 *   <li>Call Of Duty (COD)</li>
 *   <li>Doom 3 (D3)</li>
 *   <li>Enemy Territory (ET)</li>
 *   <li>Halflife (HL)</li>
 *   <li>Halflife 2 (HL2) / Source</li>
 *   <li>Medal of Honor (MOH)</li>
 *   <li>Neverwinter Nights (NWN)</li>
 *   <li>Nexuiz (NEX)</li>
 *   <li>Quake 3 (Q3)</li>
 *   <li>Unreal Tournament (UT)</li>
 *   <li>Unreal Tournament 2003 (UT2003|UT2K3)</li>
 *   <li>Unreal Tournament 2004 (UT2004|UT2K4)</li>
 * </ul>
 * 
 * @author DeadEd
 */
public class QueriEd {

    /**
     * Timeout used for the sockets 
     */
    public static final int TIMEOUT = 2000;

    /**
     * Server details 
     */
    public static final int INFO_DETAILS = 0;
    /**
     *  Player details 
     */
    public static final int INFO_PLAYERS = 1;
 
    /**
     * Any query type 
     */
    public static final int QUERY_ANY = 0;
    /**
     * Halflife query type 
     */
    public static final int QUERY_HALFLIFE = 1;
    /**
     * Gamespy query type 
     */
    public static final int QUERY_GAMESPY = 2;
    /**
     * Gamespy 2 query type 
     */
    public static final int QUERY_GAMESPY2 = 3;
    /**
     * Halflife 2 / Source query type 
     */
    public static final int QUERY_SOURCE = 4;
    /**
     * UnrealEngine2 query type 
     */
    public static final int QUERY_UT2S = 5;

    /**
     * Any game type 
     */
    public static final int GAME_ANY = 0;
    /**
     * Unreal Tournament game type 
     */
    public static final int GAME_UT = 1; 
    /**
     * Unreal Tournament 2003 game type 
     */
    public static final int GAME_UT2003 = 2; 
    /**
     * Unreal Tournament 2004 game type 
     */
    public static final int GAME_UT2004 = 3; 
    /**
     * Enemy Territory game type 
     */
    public static final int GAME_ET = 4; 
    /**
     * Halflife game type 
     */
    public static final int GAME_HL = 5; 
    /**
     * Quake 3 game type 
     */
    public static final int GAME_Q3 = 6; 
    /**
     * Battlefield 1942 game type 
     */
    public static final int GAME_BF1942 = 7; 
    /**
     * Battlefield Vietnam game type 
     */
    public static final int GAME_BFV = 8; 
    /**
     * Call Of Duty game type 
     */
    public static final int GAME_COD = 9;
    /**
     * Doom 3 game type 
     */
    public static final int GAME_D3 = 10;
    /**
     * Halflife 2 / Source game type 
     */
    public static final int GAME_HL2 = 11; 
    /**
     * Neverwinter Nights 
     */
    public static final int GAME_NWN = 12; 
    /**
     * Battlefield 2 game type 
     */
    public static final int GAME_BF2 = 13; 
    /**
     * Americas Army game type 
     */
    public static final int GAME_AA = 14; 
    /**
     * Nexuiz game type 
     */
    public static final int GAME_NEX = 15; 
    
    private static HashMap supportedGames = new HashMap();
    static {
        supportedGames.put("AA", "Americas Army");
        supportedGames.put("BF", "Battlefield 1942");
        supportedGames.put("BF2", "Battlefield 2");
        supportedGames.put("BFV", "Battlefield Vietname");
        supportedGames.put("COD", "Call of Duty");
        supportedGames.put("COD2", "Call of Duty 2");
        supportedGames.put("D3", "Doom 3");
        supportedGames.put("ET", "Enemy Territory");
        supportedGames.put("HL", "Halflife");
        supportedGames.put("HL2", "Halflife 2");
        supportedGames.put("MOH", "Medal of Honor");
        supportedGames.put("NWN", "Never Winter Nights");
        supportedGames.put("NEX", "Nexuiz");
        supportedGames.put("Q3", "Quake 3");
        supportedGames.put("UT", "Unreal Tournament");
        supportedGames.put("UT2003|UT2K3", "Unreal Tournament 2003");
        supportedGames.put("UT2004|UT2K4", "Unreal Tournament 2004");
    }

    /**
     * Returns a HashMap of the games that QueriEd supports.
     * The key is the game code.  The full game name is the value.
     * 
     * @return a HashMap of the support games
     */
    public static HashMap getSupportedGames() {
        return supportedGames;
    }
    
    /**
     * Query a game server for server details.<br/>
     * <br/>
     * Ask for server details: name, ip, port, game, gameVersion, map, playerCount, maxPlayers. This
     * will use the specified local port to create the socket (useful if you need to configure your firewall)<br/>
     * <br/>
     * Valid game types:
     * <ul>
     *   <li><b>AA</b> - Americas Army</li>
     *   <li><b>BF</b> - Battlefield 1942</li>
     *   <li><b>BF2</b> - Battlefield 2</li>
     *   <li><b>BFV</b> - Battlefield Vietnam</li>
     *   <li><b>COD</b> - Call of Duty</li>
     *   <li><b>COD2</b> - Call of Duty 2</li>
     *   <li><b>D3</b> - Doom 3</li>
     *   <li><b>ET</b> - Enemy Territory</li>
     *   <li><b>HL</b> - Halflife</li>
     *   <li><b>HL2</b> - Halflife 2</li>
     *   <li><b>MOH</b> - Medal of Honor</li>
     *   <li><b>NWN</b> - Neverwinter Nights</li>
     *   <li><b>NEX</b> - Nexuiz</li>
     *   <li><b>Q3</b> - Quake 3</li>
     *   <li><b>UT</b> - Unreal Tournament</li>
     *   <li><b>UT2003|UT2K3</b> - Unreal Tournament 2003</li>
     *   <li><b>UT2004|UT2K4</b> - Unreal Tournament 2004</li>
     * </ul>
     * <br/> 
     * Example: <br/>
     * &nbsp;&nbsp;&nbsp;&nbsp;<code>ServerInfo serverInfo = QueriEd.serverQuery(27777, "HL", ip, port);</code>
     * 
     * @param localPort a port on the machine that the bot is running from that will be used to make the query
     * @param gameType one of the supported game types, defaults to Halflife
     * @param ipStr the ip (numerical or hostname) of the server
     * @param port the query port of the server
     * @return a ServerInfo object, or null if there was some problem wheil querying the server
     */
    public static ServerInfo serverQuery(int localPort, String gameType, String ipStr, int port) {
        int resolvedGameType = resolve(gameType);

        return serverQuery(localPort, resolvedGameType, ipStr, port, INFO_DETAILS);
    }
    
    /**
     * Query a game server for server details.<br/>
     * <br/>
     * Ask for server details: name, ip, port, game, gameVersion, map, playerCount, maxPlayers.  This
     * will try to find an open socket on the local machine.<br/>
     * <br/>
     * Valid game types:
     * <ul>
     *   <li><b>AA</b> - Americas Army</li>
     *   <li><b>BF</b> - Battlefield 1942</li>
     *   <li><b>BF2</b> - Battlefield 2</li>
     *   <li><b>BFV</b> - Battlefield Vietnam</li>
     *   <li><b>COD</b> - Call of Duty</li>
     *   <li><b>COD2</b> - Call of Duty 2</li>
     *   <li><b>D3</b> - Doom 3</li>
     *   <li><b>ET</b> - Enemy Territory</li>
     *   <li><b>HL</b> - Halflife</li>
     *   <li><b>HL2</b> - Halflife 2</li>
     *   <li><b>MOH</b> - Medal of Honor</li>
     *   <li><b>NWN</b> - Neverwinter Nights</li>
     *   <li><b>NEX</b> - Nexuiz</li>
     *   <li><b>Q3</b> - Quake 3</li>
     *   <li><b>UT</b> - Unreal Tournament</li>
     *   <li><b>UT2003|UT2K3</b> - Unreal Tournament 2003</li>
     *   <li><b>UT2004|UT2K4</b> - Unreal Tournament 2004</li>
     * </ul>
     * <br/> 
     * Example: <br/>
     * &nbsp;&nbsp;&nbsp;&nbsp;<code>ServerInfo serverInfo = QueriEd.serverQuery("HL", ip, port);</code>
     * 
     * @param gameType one of the supported game types, defaults to Halflife
     * @param ipStr the ip (numerical or hostname) of the server
     * @param port the query port of the server
     * @return a ServerInfo object, or null if there was some problem wheil querying the server
     */
    public static ServerInfo serverQuery(String gameType, String ipStr, int port) {
        return serverQuery(0, gameType, ipStr, port);
    }
    
    /**
     * Query a game server for player information.<br/>
     * <br/>
     * Ask for player details: name, kills, deaths, score, objectives completed.  This
     * will use the specified local port to create the socket (useful if you need to configure your firewall)<br/>
     * <br/>
     * Valid game types:
     * <ul>
     *   <li><b>AA</b> - Americas Army</li>
     *   <li><b>BF</b> - Battlefield 1942</li>
     *   <li><b>BF2</b> - Battlefield 2</li>
     *   <li><b>BFV</b> - Battlefield Vietnam</li>
     *   <li><b>COD</b> - Call of Duty</li>
     *   <li><b>COD2</b> - Call of Duty 2</li>
     *   <li><b>D3</b> - Doom 3</li>
     *   <li><b>ET</b> - Enemy Territory</li>
     *   <li><b>HL</b> - Halflife</li>
     *   <li><b>HL2</b> - Halflife 2</li>
     *   <li><b>MOH</b> - Medal of Honor</li>
     *   <li><b>NEX</b> - Nexuiz</li>
     *   <li><b>Q3</b> - Quake 3</li>
     *   <li><b>UT</b> - Unreal Tournament</li>
     *   <li><b>UT2003|UT2K3</b> - Unreal Tournament 2003</li>
     *   <li><b>UT2004|UT2K4</b> - Unreal Tournament 2004</li>
     * </ul>
     * <br/> 
     * Example: <br/>
     * &nbsp;&nbsp;&nbsp;&nbsp;<code>ArrayList playerInfo = QueriEd.playerQuery(27777, "HL", ip, port);</code>
     * 
     * @param localPort a port on the machine that the bot is running from that will be used to make the query
     * @param gameType one of the supported game types, defaults to Halflife
     * @param ipStr the ip (numerical or hostname) of the server
     * @param port the query port of the server
     * @return an ArrayList of PlayerInfo objects, the list will be empty if there aren't any players 
     * on the server
     */
    public static ArrayList playerQuery(int localPort, String gameType, String ipStr, int port) {
        int resolvedGameType = resolve(gameType);

        return playerQuery(localPort, resolvedGameType, ipStr, port, INFO_PLAYERS);
    }

    /**
     * Query a game server for player information.<br/>
     * <br/>
     * Ask for player details: name, kills, deaths, score, objectives completed. This
     * will try to find an open socket on the local machine.<br/>
     * <br/>
     * Valid game types:
     * <ul>
     *   <li><b>AA</b> - Americas Army</li>
     *   <li><b>BF</b> - Battlefield 1942</li>
     *   <li><b>BF2</b> - Battlefield 2</li>
     *   <li><b>BFV</b> - Battlefield Vietnam</li>
     *   <li><b>COD</b> - Call of Duty</li>
     *   <li><b>COD2</b> - Call of Duty 2</li>
     *   <li><b>D3</b> - Doom 3</li>
     *   <li><b>ET</b> - Enemy Territory</li>
     *   <li><b>HL</b> - Halflife</li>
     *   <li><b>HL2</b> - Halflife 2</li>
     *   <li><b>MOH</b> - Medal of Honor</li>
     *   <li><b>NEX</b> - Nexuiz</li>
     *   <li><b>Q3</b> - Quake 3</li>
     *   <li><b>UT</b> - Unreal Tournament</li>
     *   <li><b>UT2003|UT2K3</b> - Unreal Tournament 2003</li>
     *   <li><b>UT2004|UT2K4</b> - Unreal Tournament 2004</li>
     * </ul>
     * <br/> 
     * Example: <br/>
     * &nbsp;&nbsp;&nbsp;&nbsp;<code>ArrayList playerInfo = QueriEd.playerQuery("HL", ip, port);</code>
     * 
     * @param gameType one of the supported game types, defaults to Halflife
     * @param ipStr the ip (numerical or hostname) of the server
     * @param port the query port of the server
     * @return an ArrayList of PlayerInfo objects, the list will be empty if there aren't any players 
     * on the server
     */
    public static ArrayList playerQuery(String gameType, String ipStr, int port) {
        return playerQuery(0, gameType, ipStr, port);
    }
    
    private static int resolve(String gameType) {
        if(gameType.equalsIgnoreCase("UT") || gameType.equalsIgnoreCase("MOH")) {
            return GAME_UT;
        } else if(gameType.equalsIgnoreCase("UT2003") || gameType.equalsIgnoreCase("UT2K3")) {
            return GAME_UT2003;
        } else if(gameType.equalsIgnoreCase("UT2004") || gameType.equalsIgnoreCase("UT2K4")) {
            return GAME_UT2004;
        } else if(gameType.equalsIgnoreCase("ET")) {
            return GAME_ET;
        } else if(gameType.equalsIgnoreCase("Q3")) {
            return GAME_Q3;
        } else if(gameType.equalsIgnoreCase("HL")) {
            return GAME_HL;
        } else if(gameType.equalsIgnoreCase("HL2")) {
            return GAME_HL2;
        } else if(gameType.equalsIgnoreCase("BF")) {
            return GAME_BF1942;
        } else if(gameType.equalsIgnoreCase("BF2")) {
            return GAME_BF2;
        } else if(gameType.equalsIgnoreCase("BFV")) {
            return GAME_BFV;
        } else if(gameType.equalsIgnoreCase("COD") || gameType.equalsIgnoreCase("COD2")) {
            return GAME_COD;
        } else if(gameType.equalsIgnoreCase("D3")) {
            return GAME_D3;
        } else if(gameType.equalsIgnoreCase("NWN")) {
            return GAME_NWN;
        } else if(gameType.equalsIgnoreCase("AA")) {
            return GAME_AA;
        } else if(gameType.equalsIgnoreCase("NEX")) {
            return GAME_NEX;
        } else {
            return GAME_HL;
        }
    }
    
    private static ServerInfo serverQuery(int localPort, int gameType, String ipStr, int port, int infoType) {
        
        switch (gameType) {
            case GAME_BF2:
                return BF2ServerInfo.getDetails(localPort, ipStr, port, infoType, QUERY_GAMESPY2, GAME_BF2);
        }

        return null;
    }

    private static ArrayList playerQuery(int localPort, int gameType, String ipStr, int port, int infoType) {
        
        switch (gameType) {
            case GAME_BF2:
                return BF2ServerInfo.getPlayers(localPort, ipStr, port, infoType, QUERY_GAMESPY2, GAME_BF2);
        }

        return null;
    }

}
