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
 * Gamespy 3 Protocol
 *
 * @author         Tom Buskens <t.buskens@deviation.nl>
 * @version        $Revision: 1.1 $
 */
class GameQ_Protocol_gamespy3 extends GameQ_Protocol
{

    public function status()
    {
        // Var / value pairs
        $this->info();

        // Players and teams
        while ($this->p->getLength() and ($type = $this->p->readInt8())) {
            if ($type == 1) $this->getSub('players');
            else if ($type == 2) $this->getSub('teams');
            else {
                $this->getSub('players');
                $this->getSub('teams');
            }
        }
    }

    private function info()
    {
        while ($this->p->getLength()) {
            $var = $this->p->readString();

            if (empty($var)) break;

            $this->r->add($var, $this->p->readString());
        }
    }

    private function getSub($type)
    {
        while ($this->p->getLength()) {

            // Get the header
            $header = $this->p->readString();
            if ($header == "") break;
            $this->p->skip();

            // Get the values
            while ($this->p->getLength()) {
                $value = $this->p->readString();
                if ($value === '') break;
                $this->r->addSub($type, $header, $value);
            }
        }
    }


    public function preprocess($packets)
    {
        // Strip headers
        $result = array();
        foreach ($packets as $packet) {
            $result[] = substr($packet, 16);
        }
        return implode("\x00", $result);
    }

    public function parseChallenge($packet)
    {
        $this->p->skip(5);
        $cc = (int) $this->p->readString();
        $x = pack( "H*", sprintf("%08X", $cc));

        return sprintf($packet, $x);
    }
}
?>
