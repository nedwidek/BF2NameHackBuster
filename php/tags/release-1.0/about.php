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
?>

<h2>About BF2 Name Hack Buster</h2>
<p>A while back one of my clanmates (yup|Patriots) posted a pointer to information on how to check to see if a player is using a hack package that allows them to change their in game name. Basically you go to any site that links the players on a server to their stats via their PID (bf2tracker.com). Find the server, click on the player's name and see if the name is different on the stats page. If it is you just found a name hacker.</p>
<p>A long process when you need to check everyone on a server. So I wrote a java program that could be run from the command line to check an entire server. It had the following problems:
<ol>
    <li>It was in Java.
    <li>It was command line with no GUI.
    <li>You needed to have Java, setup paths and classpaths, and the command was a long string.
    <li>It was in Java.
</ol></p>
<p>So I rewrote it as this PHP program. PHP made it simple and accessible. And did I mention it's not Java.</p>
<h2>Why does this work?</h2>
<p>Hackers are cowards! Often they just don't have the guts to use their real BF2 name. So they change it by using their hack package to transmit a forged name to the game server when they join. They can't change their PID though because that is how their stats get recorded.</p>
<p>The tool first connects to the game server to ask for a list of who is playing and their associated PIDs. Then the central gamespy server is queried for the official name of each player using the PID. Each name on the game server is compared to the gamespy name and differences are flagged as hackers or a false positive.</p>
<h2>False positives?</h2>
<p>The game server will chop off some of a long name or the name will be in all lower case. Why the game servers do this, you'd need to ask Dice. There is a check in place to flag these cases as possible false positives. First all of the hackers are listed and then all of the false positives. Use your best judgement on the false positives and don't worry they're easy to tell if they are innocent or a hacker (I've never seen one that wasn't a false hit).</p>
<h2>No hits, so nobody is hacking?</h2>
<p>Either that or the hacker is brave enough to use their real name. If they use their real name my tool won't flag them.<p>
<h2>What to do when you find a hacker?</h2>
<p>Simplest answer is: Don't play on the server. If an admin is on talk to them and point out the name hacker and show them how they can verify this information. They should ban them. If they don't, leave the server as it just isn't worth the grief.</p>
<h2>In conclusion</h2>
<p>There are hackers and then there are cases where predictive lag makes you think someone is hacking. Do they have a wall hack going on or did your ping combined with their ping give them a sneak peek you didn't get (Yes, I'm a networking geek)? Simple answer is that the name hackers are simple to catch now. If they're not name hacking you need to hope you can get a pb screenshot or do some after the fact reviewing of demo files.</p>
<p>Me I like the ones I can easily catch.</p>
<p>[UTAC] Raycaster 2007/12/30</p>
</body>
</html>


