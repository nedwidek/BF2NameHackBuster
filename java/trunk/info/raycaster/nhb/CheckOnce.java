package info.raycaster.nhb;


import info.raycaster.nhb.*;

import java.util.ArrayList;
import java.util.Iterator;
import java.lang.String;
import java.lang.Thread;
import java.util.regex.Pattern;
import java.util.regex.Matcher;

public class CheckOnce {
    private static void usage() {
        System.out.println("Requires one argument that must be an ip address");
        System.exit(1);
    }

    private static boolean isValidIP(String ip_addr) {
        Pattern pattern = Pattern.compile("(\\d{1,3})\\.(\\d{1,3})\\.(\\d{1,3})\\.(\\d{1,3})");
        Matcher matcher = pattern.matcher(ip_addr);

        if (matcher.matches()) {

            try {
                for (int i=1; i<5; i++) {
                    int octet = Integer.parseInt(matcher.group(i));
                    if (octet < 0 || octet > 255) {
                        return false;
                    }
                }
                
                return true;
            } catch (Exception e) {
            }
        }

        return false;
    }

    public static void main(String[] args) {
        if (args.length != 1) {
            usage();
        }

        if (!isValidIP(args[0])) {
            usage();
        }

        ArrayList names =  ServerInfo.getPlayers(args[0]);

        if (names == null) {
            System.out.println("No response from server.");
            System.exit(0);

        }

        if (names.size() == 0) {
            System.out.println("No players on server.");
            System.exit(0);
        }

        Iterator namesIterator = names.iterator();

        String output = ""; 

        while (namesIterator.hasNext()) {
            PlayerNames player = (PlayerNames) namesIterator.next();
            String serverName = player.getServerName();
            String gamespyName = player.getGamespyName();

            if (gamespyName == null) {
                output += "Error getting gamespy name!!!!\nPID:            " + 
                    player.getPid() + "\nName on server: " +  serverName +
                    "\n\n";
                continue;
            }


            if (!serverName.equals(gamespyName)) {

                if (serverName.toLowerCase().equals(gamespyName.toLowerCase())
                    || gamespyName.toLowerCase().startsWith(serverName.toLowerCase())) {
                        output += "Suspicious Name!!!! Note that this may be a false positive."
                            + "\nPID:            " + player.getPid() +
                            "\nName on server: " + player.getServerName() + "\nReal Name:      " +
                            player.getGamespyName() + "\n\n";

                } else {
                    output += "Hacked Name!!!!\nPID:       " + player.getPid() +
                        "\nFake Name: " + player.getServerName() + "\nReal Name: " +
                        player.getGamespyName() + "\n\n";
                }
            }

            System.out.println(player.getPid() + "   " + player.getServerName() +
                               "   " + player.getGamespyName());

            
            }
        System.out.println("\n\n");

        if (output.equals("")) {
            System.out.println("No name hackers found on server");
        } else {
            System.out.println(output);
        }
        
    }
}
