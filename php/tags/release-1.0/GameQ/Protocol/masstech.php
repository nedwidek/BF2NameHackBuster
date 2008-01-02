<?php
/**
 * This file is part of GameQ.
 *
 * GameQ is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * GameQ is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * $Id: gamespy3.php,v 1.1 2007/07/29 18:39:19 tombuskens Exp $  
 */
 
require_once GAMEQ_BASE . 'Protocol.php';


/**
 * Masstech engine protocol
 *
 * @author         Tom Buskens <t.buskens@deviation.nl>
 * @version        $Revision: 1.1 $
 */
class GameQ_Protocol_masstech extends GameQ_Protocol
{

    public function status()
    {
        //echo $this->p->readInt32();
        $data = explode("\x00", $this->p->getBuffer());
        foreach ($data as $key => $d) {
            echo '<h3>' . $key . ' - ' . strlen($d) . '</h3>';
            hexdump($d);
        }

    }

    public function status2()
    {
        $this->status();
    }
}
