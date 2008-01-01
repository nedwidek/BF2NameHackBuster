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
require_once './config.php';

include_once 'head.php';

mysql_connect($dbserver,$user,$pass);
@mysql_select_db($database);

if ($pid) {
    $query = sprintf("SELECT gamespy_name, hackers.pid, hacked_name, server_name, server_addr, date_time FROM hackers, hacked_names WHERE hackers.pid = hacked_names.pid AND hackers.pid = '%s'",
                     mysql_real_escape_string($pid));

    $result = mysql_query($query);

    $num=mysql_numrows($result);

    for ($i=0; $i<$num; $i++) {
        if ($i == 0) {
            $name = mysql_result($result, $i, "gamespy_name");
            $pid = mysql_result($result, $i, "hackers.pid");

            echo "<h2>Wall of Shame</h2>";
            echo "<h3>" . htmlspecialchars($name) . " (" . htmlspecialchars($pid) . ")</h3>";
            echo "<hr/><ul>";
        }

        $name=mysql_result($result,$i,"hacked_name");
        $server_name=mysql_result($result,$i,"server_name");
        $server_addr=mysql_result($result,$i,"server_addr");
        $date_time=mysql_result($result,$i,"date_time");

        echo "<li> Caught on " . htmlspecialchars($server_name) . " (" . htmlspecialchars($server_addr) . ")<br/>";
        echo "Playing as " . htmlspecialchars($name);
        echo "<br/>" . htmlspecialchars($date_time) . "</li>";
    }
    echo "</ul>";
} else {
    $query = "SELECT pid, gamespy_name FROM hackers";

    $result = mysql_query($query);

    $num=mysql_numrows($result);

    echo "<h2>Wall of Shame</h2>";
    echo "<ul>";
    for ($i=0; $i<$num; $i++) {
        $pid=mysql_result($result,$i,"pid");
        $gamespy_name=mysql_result($result,$i,"gamespy_name");

        echo "<li> <a href=\"" . $PHP_SELF . "?pid=" . $pid . "\">" . htmlspecialchars($gamespy_name) . "</a></li>";
    }
    echo "</ul>";

}

mysql_close();

?>

</body>
</html>


