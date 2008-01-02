Readme
======
Check http://gameq.sourceforge.net/ for basic usage information and support.


NOTE
====
Since alpha 2.2, use the gq_online (boolean) variable for each server to check 
if it is online! This is different from previous versions where you could
check if the result array was empty.



Changelog
=========

Alpha 2.2 - November 19, 2007
---------
- Games added:
  + [cod3] Call of Duty 3, thanks to Allstats
  + [cod4] Call of Duty 4, thanks to Allstats
  + [coduo] Call of Duty: United offensive
  + [crysis] Crysis
  + [mohbreak] Medal of Honor: Breakthrough
  + [mohspear] Medal of Honor: Spearhead
  + [rfactor] rFactor
  + [tf2] Team Fortress 2
  + [ut3] Unreal Tournament 3, unknown default port
- Games updated:
  + [aa] America's army now uses gamespy2 protocol
  + [quakewars] Updated for version 1.2
- Protocols updated:
  + [source] Better handling for erroneous responses
  + [gamespy] Improved
  + [gamespy2] Fixed bug for empty player list

- Added GameQ_Buffer::goto
- Modified GameQ_Config::getGame to return game type
- Added some default return values (gq_<name>)
- Partially rewrote the normalise filter
- Added some script examples

Alpha 2.1 - August 18, 2007
-------
- Added a normalising filter
- Added ghost recon: advanced warfighter 2 to list [graw2]
- Added ghost recon: advanced warfighter to list [graw]
- Added vietcong 2 to list [vietcong2]
- Added mta: san andreas to list [mtasa]
- Added hexenworld to list [hexenworld]
- Added generic entry for source [source]
- Added halo 2 entry, untested [halo2]
- Changed fear to use gamespy2 protocol [fear]
- Added a limit on sockets to be used by the script, preventing errors when
  querying large amounts of servers.
  The limit can be set using $gameq->setOption('sockets', <number>);
- Added a GameQ::clearServers() method
- Fixed doom3/quakewars players

Alpha 2 - July 29, 2007
-------
- Added battlefield 2142 support [bf2142]
- Added stalker support [stalker]
- Added alien arena to list [alienarena]
- Added armed assault to list [armedassault]
- Added red orchestra to list [redorchestra]
- Added cross racing championship to list [crossracing]
- Added kiss psycho circus to list [kiss]
- Updated kingpin data [kingpin]
- Fixed player bug for doom3 protocol
- Fixed player bug for gamespy protocol
- Added a filter to strip color tags
- Modified main GameQ and Communicate objects to send challenge-
  response packets over same socket. This caused problems with the new 
  gamespy protocol
- Added some sanity checks to main class

Alpha 1.2 - July 17, 2007
-------
- Added hexen 2 support [hexen2]
- Added silverback engine support [silverback]
- Added partial tribes support [tribes]
- Added partial tribes 2 support [tribes2]
- Added dark messiah to list [messiah]
- Added tremulous to list [tremulous]
- Added savage to list [savage]
- Added ragdoll kung fu to list [ragdoll]
- Added neverwinter nights 2 to list [neverwinter2]
- Added Red Orchestra to list [redorchestra]
- Added this file


Alpha 1.1 - July 05, 2007
-------
- Added Cube engine support [cube]
- Added Sauerbraten / Cube2 engine support [sauerbraten]
- Added limited Ghost Recon support [ghostrecon]
- Added Warsow support [warsow]
- Added Counter-Strike list [cs]
- Added Dod: Source to list [dodsource]
- Modified quake3 protocol, now manually counts players
- Changed filters to accept arguments


Alpha 1 - June 29, 2007
-------
- Initial commit
