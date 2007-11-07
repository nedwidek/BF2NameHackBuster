package info.raycaster.nhb;
import java.lang.String;

public class PlayerNames {

    private String pid;
    private String serverName;
    private String gamespyName;

    public void setPid(String pid) {
        this.pid = pid;
    }

    public String getPid() {
        return pid;
    }
    
    public void setServerName(String serverName) {
        this.serverName = serverName;
    }

    public String getServerName() {
        return serverName;
    }

    public void setGamespyName(String gamespyName) {
        this.gamespyName = gamespyName;
    }

    public String getGamespyName() {
        return gamespyName;
    }
}
