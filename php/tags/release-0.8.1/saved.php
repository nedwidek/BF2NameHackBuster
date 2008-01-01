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

if ($id) {
    $query = sprintf("SELECT report FROM reports where id = '%s'",
                     mysql_real_escape_string($id));

    $result = mysql_query($query);

    $num=mysql_numrows($result);

    for ($i=0; $i<$num; $i++) {
        $report=mysql_result($result,$i,"report");

        echo $report;
    }
} else {
    $query = "SELECT id, title FROM reports";

    $result = mysql_query($query);

    $num=mysql_numrows($result);

    echo "<h2>Reports</h2>";
    echo "<ul>";
    for ($i=0; $i<$num; $i++) {
        $id=mysql_result($result,$i,"id");
        $title=mysql_result($result,$i,"title");

        echo "<li> <a href=\"" . $PHP_SELF . "?id=" . $id . "\">" . htmlspecialchars($title) . "</a></li>";
    }
    echo "</ul>";

}

mysql_close();

?>


</body>
</html>


