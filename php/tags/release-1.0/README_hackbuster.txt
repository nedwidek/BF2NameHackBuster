Requirements
------------
A web server running PHP 5.
MySQL (optional)

Installation Directions
-----------------------
Unpack the distribution to your webserver in the desired directory.

Edit config.php. Determine if you want to save the reports and have a wall of shame. Set
$use_database to false if you do not. Edit the other variables with information for your database,
database user, and password.

Database setup: Create a database table for the information or use an existing table. Run the
following command.
   mysql -D <database name> -u <user> -p < setup.sql

Everything should be set to go.


Includes
--------
GameQ library <<http://gameq.sourceforge.com/>>

License
-------
hackbuster is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

hackbuster is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
