package info.raycaster.nhb;


import info.raycaster.nhb.*;

import net.sourceforge.queried.Util;
import net.sourceforge.queried.QueriEd;

import java.lang.String;
import java.net.URL;
import java.net.URLConnection;
import java.net.HttpURLConnection;
import java.util.ArrayList;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.BufferedReader;
import java.util.regex.Pattern;
import java.util.regex.Matcher;

public class ServerInfo {

    private static NameCache cache = null;

    private static int[] ports = new int[]{29900, 29901, 29902, 29904, 29910};

    static {
        cache = new NameCache();
    }

    public static ArrayList getPlayers(String serverIP) {
        String serverResponse = null;

        int i=0;

        while(serverResponse == null && i < ports.length) {
            System.out.println("Checking server on port: " + ports[i]);
            serverResponse = Util.getInfo(0, serverIP, ports[i],  QueriEd.INFO_PLAYERS,
                                          QueriEd.QUERY_GAMESPY2, QueriEd.GAME_BF2);
        }
        
        if (serverResponse == null) {
            return null;
        }
        
        System.out.println("Processing players");
        String[] nicks = assembleParts(serverResponse, "player_");

        if (nicks == null) {
            return new ArrayList();
        }

        System.out.println("Processing pids");
        String[] pids = assembleParts(serverResponse, "pid_");

        if (nicks.length != pids.length) {
            return null;
        }

        ArrayList retValues = new ArrayList(pids.length);

        for (i=0; i<pids.length; i++) {

            PlayerNames name;

            if (cache.containsPlayer(pids[i])) {
                name = cache.getPlayerNames(pids[i]);
            } else {
                name = new PlayerNames();
                name.setPid(pids[i]);
    
                if (nicks[i].indexOf(" ") > -1) {
                    nicks[i] = nicks[i].substring(nicks[i].indexOf(" ") + 1);
                }
                name.setServerName(nicks[i]);

                String gamespyName = getGamespyName(pids[i]);
    
                name.setGamespyName(gamespyName);
            }

            retValues.add(name);
        }

        return retValues;
    }

    private static String getGamespyName(String pid) {

        System.out.println("Connecting to Gamespy for " + pid);

        String loc = "http://bf2web.gamespy.com/ASP/getplayerinfo.aspx?pid="
            + pid + "&info=per*,cmb*,twsc,cpcp,cacp,dfcp,kila,heal,rviv,rsup,rpar,tgte,dkas,dsab,cdsc,rank,cmsc,kick,kill,deth,suic,ospm,klpm,klpr,dtpr,bksk,wdsk,bbrs,tcdr,ban,dtpm,lbtl,osaa,vrk,tsql,tsqm,tlwf,mvks,vmks,mvn*,vmr*,fkit,fmap,fveh,fwea,wtm-,wkl-,wdt-,wac-,wkd-,vtm-,vkl-,vdt-,vkd-,vkr-,atm-,awn-,alo-,abr-,ktm-,kkl-,kdt-,kkd-";

        String name = null;

        try {
            URL url = new URL(loc);

            URLConnection con = url.openConnection();

            con.setDoOutput(true);
            con.setDoInput(true);

            con.addRequestProperty("User-Agent", "GameSpyHTTP/1.0");
    
            con.connect();

            if (con instanceof HttpURLConnection && 
                ((HttpURLConnection)con).getResponseCode() != 200) {
                return name;
            }

            BufferedReader reader = 
                new BufferedReader(new InputStreamReader(con.getInputStream()));

            Pattern pattern = Pattern.compile("^D\\s+"+pid+"\\s+(\\S+)\\s+.*");
            
            String line;
            while ((line = reader.readLine()) != null) {
                Matcher matcher = pattern.matcher(line);
                if (matcher.matches()) {
                    name = matcher.group(1);
                }
            }
    
        } catch (Exception e) {
            e.printStackTrace();
        }

        return name;
    }

    // Pulled from QueriEd
    private static String[] assembleParts(String recStr, String markerString) {
        char chr = 00;
        String marker = markerString + chr;
        boolean search = true;
        int start = 0;
        int end = 0;
        String chunk = "";
        String[] retArray = null;

        if (recStr.indexOf(markerString + chr + chr + chr) > -1) {
            // No players on server, return the null array.
            return retArray;
        }

        while(search) {
            start = recStr.indexOf(marker, start) + marker.length() + 1;
            end = recStr.indexOf(chr +""+ chr, start);
            if(end <= 0) {
                end = recStr.length();
            }
            if(start == marker.length()) {
                search = false;
            }
            if(search) {
                chunk = recStr.substring(start, end);
                if(retArray == null || retArray.length == 0) {
                    retArray = chunk.split(chr +"");
                    
                } else { // new chunk started with player_.>
                    String[] tmpArray = chunk.split(chr +"");
                    String[] copyArray = (String[]) retArray.clone();
                    retArray = new String[tmpArray.length + copyArray.length - 1]; 
                    // replace the last item as it is repeated fully in the new segment
                    System.arraycopy(copyArray, 0, retArray, 0, copyArray.length - 1);
                    System.arraycopy(tmpArray, 0, retArray, copyArray.length -1, tmpArray.length);
                    
                }                
                start = end;
            }
        }
        
        if(retArray == null) {
            return null;
        }
        
        return (String[]) retArray.clone();
    }
}
