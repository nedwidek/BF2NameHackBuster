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
 * $Id: source.php,v 1.3 2007/10/09 20:49:06 tombuskens Exp $  
 */


require_once GAMEQ_BASE . 'Protocol.php';


/**
 * Source Engine Protocol
 *
 * @author      Aidan Lister    <aidan@php.net>
 * @author      Tom Buskens     <t.buskens@deviation.nl>
 * @version     $Revision: 1.3 $
 */
class GameQ_Protocol_source extends GameQ_Protocol
{
    public function details()
    {
        // Header
        $type = $this->header();
        
        // Rules, variables are different according to protocol
        if ($type == 'm') $this->r->add('address', $this->p->readString());
        else              $this->r->add('protocol',    $this->p->readInt8());
        
        $this->r->add('hostname',    $this->p->readString());
        $this->r->add('map',         $this->p->readString());
        $this->r->add('game_dir',    $this->p->readString());
        $this->r->add('game_descr',  $this->p->readString());

        if ($type != 'm') $this->r->add('steamappid',  $this->p->readInt16());

        $this->r->add('num_players', $this->p->readInt8());
        $this->r->add('max_players', $this->p->readInt8());

        if ($type == 'm') $this->r->add('protocol',    $this->p->readInt8());
        else              $this->r->add('num_bots',    $this->p->readInt8());

        $this->r->add('dedicated',   $this->p->read());
        $this->r->add('os',          $this->p->read());
        $this->r->add('password',    $this->p->readInt8());
        $this->r->add('secure',      $this->p->readInt8());
        $this->r->add('version',     $this->p->readInt8());
    }


    public function players()
    {
        // Header
        $this->header();

        // Player count
        $this->r->add('num_players', $this->p->readInt8());

        // Players
        while ($this->p->getLength()) {
            $this->r->addPlayer('id',      $this->p->readInt8());
            $this->r->addPlayer('name',    $this->p->readString());
            $this->r->addPlayer('score',   $this->p->readInt32());
            $this->r->addPlayer('time',    $this->p->readFloat32());
        }
    }


    public function rules()
    {
        // Header
        $this->header();

        // Rule count
        $this->r->add('num_rules', $this->p->readInt16());

        // Rules
        while ($this->p->getLength()) {
            $this->r->add($this->p->readString(), $this->p->readString());
        }
    }

    public function parseChallenge($packet)
    {
        // Header
        $this->header();

        return sprintf($packet, $this->p->read(4));
    }

    protected function header()
    {
        $this->p->skip(4);
        return $this->p->read();
    }

    /*
     * Join multiple packets
     */
    public function preprocess($packets)
    {
        // Only one packet
        if (count($packets) == 1) {

            $packet = $packets[0];

            // Message spans multiple packets, but
            // somehow only one was received, strip header
            if ($packet{0} != "\xFF") {
                $packet = substr($packet, 9);
            }

            return $packet;
        }
        
        $result = array();
        foreach ($packets as $packet) {
            // Make sure it's a valid packet
            if (strlen($packet) < 9) {
                continue;
            }
            
            // Get the low nibble of the 9th bit
            $key = substr(bin2hex($packet{8}), 0, 1);
            
            // Strip whole header
            $packet = substr($packet, 9);
            
            // Order by low nibble
            $result[$key] = $packet;
        }
        
        ksort($result);

        return implode('', $result);
    }
}
?>
