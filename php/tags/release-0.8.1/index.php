<?php
/**
 * Name Hack Buster. Based on original Java version.
 *
 * @author   Erik Nedwidek  <nedwidek@yahoo.com>
 * @version  $Revision$
 * 
 * This file is part of hackbuster.
 *
 * hackbuster is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * hackbuster is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * $Id$ 
 */

// Set the error reporting to show everything except notices
error_reporting(E_ALL & ~E_NOTICE);
require_once 'GameQ.php';
require_once './config.php';
include_once("./head.php");

?>

<h2>BF2 Name Hack Buster</h2>
<?php

$port=0;
$spyport=0;

$error="";

$procssing_error = "";
$possible = "";

// Validate the ip address
if (isset($ipaddr)) {
    $ipaddr = trim($ipaddr);
    if(preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}(:\d{1,5}){0,2}$/', $ipaddr)) {
        if (strpos($ipaddr, ":") > -1) {
            list($ipaddr, $port, $spyport) = split(":", $ipaddr);
        }
        
        $octets = split(".", $ipaddr);
        foreach($octets as $octet) {
            if ($octet<0 || $octet>255) {
                $error = "Invalid IP Address Format: The octet values can be from 0 to 255";
            }
        }
        if ($port<0 || $port>65535) {
            if ($error!=="") {
                $error .= "<br/>";
            }
            $error .= " Invalid Port: Port value can be from 0 to 65535";
        }
        if ($spyport<0 || $spyport>65535) {
            if ($error!=="") {
                $error .= "<br/>";
            }
            $error .= " Invalid Port: Port value can be from 0 to 65535";
        }

    } else {
        $error = "Invalid IP Address Format: Use 255.255.255.255[:12345][:12345]";
    }
}

// The form
echo '<table width="100%" border="1" id="formtable" bgcolor="1E1C18">';
echo '<tr>';
echo '<td border="0">';
echo "<form method=\"post\" action=\"" . $PHP_SELF . "\">";
if ($error !== "") {
    echo '<span style="color: red; font-size: x-small;">' . $error . '</span><br>';
}
echo "Server IP Address:<br>";
echo "<input type=\"text\" size=\"24\" name=\"ipaddr\" value=\"";
if (isset($ipaddr)) {
    echo $ipaddr . (($port != 0)?":$port":"") . (($spyport != 0)?":$spyport":"");
}
echo  "\"/>";
echo "<input type=\"submit\" name=\"submit\" value=\"Check\"/>";

?>
</form>
</td>
</tr>
</table>

<div id="statusArea"></div>

<?php

if (isset($ipaddr) && ($error === "")) {

    ?>
        <script language="JavaScript">
        <!--
        updateStatus("Querying BF2 server...");
        -->
        </script>
    <?php
    
    // They've entered a valid ip address
    // server to check.
    if ($port == "" || $port == 0) {
        $port = 16567;
    }

    if ($spyport == "" || $spyport == 0) {
        $spyport = 29900 + (16567 - $port);
    }


    $server['check'] = array("bf2", $ipaddr, $spyport);

    $gq = new GameQ;

    try {
        $gq->addServers($server);
    }
    catch (Exception $e) {
        print 'One of the server entries was not defined correctly.';
        exit;
    }

    $gq->setOption('timeout', 5000);     // Socket timeout in ms
    $gq->setOption('raw',     true);   // Return raw or parsed data
    $gq->setOption('sockets', 64);      // The maximum number of sockets used by the script


    // Send requests and parse the data
    try {
        $results = $gq->requestData();
    }
    catch (Exception $e) {
        print 'An error occurred while requesting or processing data.';
        exit;
    }

    echo "<!--";
    str_replace("-->", "*dash*dash*gt*", print_r($results['check']['status'], true));
    echo "-->";

    $info = assembleData($results['check']['status']);

    $server_name = $info['info']['hostname'];
    $server_ip = $ipaddr;
    $server_port = $info['info']['hostport'];
    $server_maxplayers = $info['info']['maxplayers'];
    $server_numplayers = $info['info']['numplayers'];
    $server_map = $info['info']['mapname'];
    $time = date("Y/m/d H:i:s T");
    $i=0;
    foreach($info['players'] as $player) {
        echo "<!--";
        str_replace("-->", "*dash*dash*gt*", print_r($player, true));
        echo "-->";
        if (strpos($player['player'], " ") > -1) {
            list($players[$i]['clan_tag'], $players[$i]['server_name']) = split(" ", $player['player']);
        } else {
            $players[$i]['server_name'] = $player['player'];
            $players[$i]['clan_tag'] = "";
        }
        echo '<script language="JavaScript">' . "\n";
        echo "<!--\n";
        echo 'updateStatus("Querying Gamespy for PID ' . $player['pid'] . ' (' . ($i+1) ."/$server_numplayers)" .'...");' . "\n";
        echo "-->\n";
        echo "</script>\n";
        if (isset($player['pid'])) {
            $players[$i]['pid'] = $player['pid'];
            $players[$i]['gamespy_name'] = getGamespyName($player['pid']);
            if (trim($players[$i]['gamespy_name']) == "") {
                $players[$i]['gamespy_name'] = "Error from gamespy";
            }
        } else {
            $players[$i]['pid'] = "Error in game server reply";
            $players[$i]['gamespy_name'] = "Error in game server reply";
        }
        $i++;
    }

    $report = '<h1>Report for Server</h1>';
    $report .= '<table border="0">';
    $report .= "<tr><td>Name:</td><td>" . htmlspecialchars($server_name) . "</td></tr>";
    $report .= "<tr><td>Address:</td><td>$server_ip:$server_port</td></tr>";
    $report .= "<tr><td>Players</td><td>$server_numplayers/$server_maxplayers</td></tr>";
    $report .= "<tr><td>Map:</td><td>" . htmlspecialchars($server_map) . "</td></tr>";
    $report .= "<tr><td>Report time:</td><td>" . $time . "</td></tr>";
    $report .= "</table>";

    $hackerArray = array();
    $hackers = "";
    $possible = "";

    echo $report;

    $table = "";
    $table .= '<table border="1">';
    $table .= '<thead><tr><th>Server Name</th><th>Gamespy Name</th><th>Clan Tag</th><th>PID</th></tr></thead>';
    $table .= '<tbody>';
    $hackerCount = 0;
    foreach($players as $player) {
        $table .= '<tr><td>' . htmlspecialchars($player['server_name']) . '</td>';
        $table .= '<td>' . htmlspecialchars($player['gamespy_name']) . '</td>';
        $table .= '<td>' . ($player['clan_tag']===""?"&nbsp;":htmlspecialchars($player['clan_tag'])) . '</td>';
        $table .= '<td>' . htmlspecialchars($player['pid']) . '</td></tr>';

        // Check to see if this is a name hack.
        if($player['server_name'] !== $player['gamespy_name']) {
            // If the mismatch is due to our error messages move to the next loop iteration.
            if ($player['gamespy_name'] == "Error from gamespy" || $player['gamespy_name'] == "Error in game server reply") {
                continue;
            }
            if(isFalseHit($player)) {
                $possible .= "<p>Possible false hit<a href=\"#foot\">*</a>";
                $possible .= "<br>Name on server: " . htmlspecialchars($player['server_name']);
                $possible .= "<br>Name from Gamespy: " . htmlspecialchars($player['gamespy_name']);
                $possible .= "<br>PID: " . htmlspecialchars($player['pid']) . "</p>";
            } else {
                $hackerArray[$hackerCount++] = $player;
                $hackers .= "<p>Found a Name Hacker!!!";
                $hackers .= "<br>Name on server: " . htmlspecialchars($player['server_name']);
                $hackers .= "<br>Name from Gamespy: " . htmlspecialchars($player['gamespy_name']);
                $hackers .= "<br>PID: " . htmlspecialchars($player['pid']) . "</p>";
            }
        }
    }
    $table .= '</tbody></table>';

    $report .= $hackers;
    $report .= $possible;
    $report .= $table;

    echo '<script language="JavaScript">' . "\n";
    echo "<!--\n";
    echo 'updateStatus("");' . "\n";
    echo "-->\n";
    echo "</script>\n";

    if ($hackers !== "") {
        $tracker = "http://bf2tracker.com/webspec/index.php?addr=$ipaddr:$port:$spyport";
        echo '<p>Please verify these name hackers at: <a href="' . $tracker . '">' 
            . $tracker . '</a>. Click on the player\'s server name and verify that the user page displays the same PID and Gamespy name.';
    }

    echo $hackers;
    echo $possible;
    echo $table;

    if ($hackers !== "" && $use_database) {
        saveReport(htmlspecialchars($server_name) . " (" . $time . ")", $report,
                   $dbserver, $user, $pass, $database);
    }

    echo "\n<!-- " . count($hackerArray) . " -->\n";

    if ($use_database && count($hackerArray) > 0) {
        saveHackers($hackerArray, $server_name, "$server_ip:$server_port", $dbserver, $user, $pass, $database);
    }
}


function getGamespyName($pid) {
    // URL to find user's gamespy name from pid.
    $loc = 'http://bf2web.gamespy.com/ASP/getplayerinfo.aspx?pid='
            . $pid . '&info=per*,cmb*,twsc,cpcp,cacp,dfcp,kila,heal,rviv,rsup,rpar,tgte,dkas,dsab,cdsc,rank,cmsc,kick,kill,deth,suic,ospm,klpm,klpr,dtpr,bksk,wdsk,bbrs,tcdr,ban,dtpm,lbtl,osaa,vrk,tsql,tsqm,tlwf,mvks,vmks,mvn*,vmr*,fkit,fmap,fveh,fwea,wtm-,wkl-,wdt-,wac-,wkd-,vtm-,vkl-,vdt-,vkd-,vkr-,atm-,awn-,alo-,abr-,ktm-,kkl-,kdt-,kkd-';

    // Must set the user agent to this or else the Gamespy won't give us the info.
    ini_set('user_agent','GameSpyHTTP/1.0');

    $response = file_get_contents($loc);

    $matches = array();
    preg_match('/^D\s+' . $pid . '\s+(\S+)\s+.*/m', $response, $matches);

    echo "<!--";
    echo str_replace("-->", "*dash*dash*gt*", $response);
    echo "-->";
    return $matches[1];

}

function isFalseHit($player) {

    $ret = false;

    if (@stripos($player['gamespy_name'], $player['server_name']) === 0) {
        $ret = true;
    }

    return $ret;
}

function assembleData ($rsp) {

    for($i=0; $i<count($rsp); $i++) {
        $rsp[$i] = substr($rsp[$i], strpos($rsp[$i], "PINGsplitnum") + 13);
    }
    foreach($rsp as $line) {
        echo "<!--" . str_replace("-->", "*dash*dash*gt*", $line) . "-->\n";
    }
    //$rsp=explode((chr(0x00).chr(0x00)."PING"."splitnum".chr(0x00)),(chr(0x00).$rsp));
    //array_shift($rsp);
    sort($rsp);
    foreach($rsp as $i => $j) { 
        $rsp[$i]=substr($j,2); 
    }
    $rsp=implode("/\\=*=.separator.=*=/\\",$rsp);
    $dat_array=Array("info" => Array(), "players" => Array(), "score" => Array());
    $i=1;
    $info = array();
    while (list($cat)=each($dat_array))
    {
    @list($dat_array[$cat],$rsp)=@explode((chr(0).chr(0).chr($i++)),$rsp);
    $dat_array[$cat]=explode("/\\=*=.separator.=*=/\\",$dat_array[$cat]);
    foreach($dat_array[$cat] as $i => $chunk) {
        switch($cat) {
            case "info":
                $dat_array[$cat][$i]=array_chunk(explode(chr(0),$chunk),2);
                foreach ($dat_array[$cat][$i] as $num => $arr)
                {
                    if ($arr[0]) { $dat_array[$cat][$i][$arr[0]]=$arr[1]; }
                    unset($dat_array[$cat][$i][$num]);
                }
                $info=array_merge($info,$dat_array[$cat][$i]);	
            break;
            case "score":
                if (!$i) {
                    $score["count"]=ord($chunk[0]);
                    $dat_array[$cat][$i]=substr($dat_array[$cat][$i],1);
                }
            case "players":
                $dat_array[$cat][$i]=explode((chr(0x00).chr(0x00)),$dat_array[$cat][$i]);
                $cpos=strpos($dat_array[$cat][$i][0],chr(0x00));
                if (($cpos!==false) && (($c=ord($dat_array[$cat][$i][0][$cpos+1]))>0)) {
                    list($dat_array[$cat][$i][-1],$dat_array[$cat][$i][0]) =
                        explode((chr(0x00).chr($c)),$dat_array[$cat][$i][0]);
                    ksort($dat_array[$cat][$i]);
                } else { 
                    $c=0; 
                }
                $dat_array[$cat][$i]=array_chunk($dat_array[$cat][$i],2);
                foreach ($dat_array[$cat][$i] as $num => $arr) {
                    if ($arr[0]) {
                        if ($arr[0][strlen($arr[0])-1]=="_") { 
                            $arr[0]=substr($arr[0],0,strlen($arr[0])-1); 
                        }
                        foreach(explode(chr(0x00),$arr[1]) as $value) { 
                            ${$cat}[$c++][$arr[0]]=$value; 
                        }
                        $c=0;
                    }
                }
            }
        }
    }
    unset($dat_array);

    $return_array = array();
    $return_array['info'] = $info;
    $return_array['players'] = $players;
    $return_array['score'] = $score;

    return $return_array;
}

function saveReport($title, $report, $dbserver, $user, $pass, $database) {
    mysql_connect($dbserver,$user,$pass);
    @mysql_select_db($database);

    $query = sprintf("INSERT INTO reports (title, report) VALUES ('%s', '%s')",
                     mysql_real_escape_string($title),
                     mysql_real_escape_string($report));
    mysql_query($query);
    mysql_close();

    echo "<p>Saved report</p>";

}

function saveHackers($hackerArray, $server_name, $server_addr, 
                     $dbserver, $user, $pass, $database) {
    mysql_connect($dbserver,$user,$pass);
    @mysql_select_db($database);

    foreach($hackerArray as $hacker) {
        
        $query = sprintf("INSERT INTO hackers (pid, gamespy_name) VALUES ('%s', '%s')",
                         mysql_real_escape_string($hacker['pid']),
                         mysql_real_escape_string($hacker['gamespy_name']));
        mysql_query($query);

        echo mysql_error();

        if ($hacker['server_name'] == "") {
            $hacker['server_name'] = " ";
        }

        $query = sprintf("INSERT INTO hacked_names (pid, hacked_name, server_name, server_addr, date_time) VALUES ('%s', '%s', '%s', '%s', '%s')",
                         mysql_real_escape_string($hacker['pid']),
                         mysql_real_escape_string($hacker['server_name']),
                         mysql_real_escape_string($server_name),
                         mysql_real_escape_string($server_addr),
                         mysql_real_escape_string(date("Y/m/d H:i:s T")));
        mysql_query($query);
        echo mysql_error();
    }
    
    mysql_close();
}

?>

<?php
if ($possible) {
?>
<a name="foot"></a>Possible false hits occur because the name reported by the game server may be truncated or not match the case of the name as reported by gamespy.
<?php
}
?>
</body>
</html>
