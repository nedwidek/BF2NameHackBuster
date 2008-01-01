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
 * $Id: Exceptions.php,v 1.3 2007/08/18 15:16:01 tombuskens Exp $  
 */
 
 
/*
 * @author    Tom Buskens    <t.buskens@deviation.nl>
 * @version   $Revision: 1.3 $
 */
class GameQ_Exception extends Exception
{
    protected $format = '%s';
    
    public function __toString()
    {
        $txt  = 'exception \'' . get_class($this) . '\' with message \'';
        $txt .= sprintf($this->format, $this->getMessage()) . '\' ';
        $txt .= 'in ' . $this->getFile() . ':' . $this->getLine() . "\n";
        $txt .= "Stack trace:\n" . $this->getTraceAsString();

        return $txt;
    }
}
    
class GameQ_ParsingException extends Exception
{
    private $packet;
    protected $format = 'Could not parse packet for server "%s"';

    function __construct($packet = null)
    {
        $this->packet = $packet;
        parent::__construct('');
    }

    public function getPacket()
    {
        return $packet;
    }
}

class GameQ_ArgumentException extends GameQ_Exception
{
    protected $format = 'Wrong arguments given for server "%s", need an array with at least 2 arguments';
}

class GameQ_ServerAddressException extends GameQ_Exception
{
    protected $format = 'Could not resolve network address for server "%s"';
}

class GameQ_InvalidProtocolException extends GameQ_Exception
{
    protected $format = 'Could not load protocol "%s"';
}

class GameQ_InvalidFilterException extends GameQ_Exception
{
    protected $format = 'Could not load filter "%s"';
}

class GameQ_InvalidParserException extends GameQ_Exception
{   
    protected $format = 'Could not load parser object "%s"';
}

class GameQ_InvalidConfigException extends GameQ_Exception
{
    protected $format = 'Could not read configuration file "%s"';
}

class GameQ_InvalidGameException extends GameQ_Exception
{
    protected $format = 'Unknown game identifier "%s"';
}

class GameQ_InvalidPacketException extends GameQ_Exception
{
    protected $format = 'Unknown packet identifier "%s"';
}
?>
