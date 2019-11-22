# ipfsmap
Tile server system based on IPFS

This is a small project that unifies https://openstreetmap.org along with https://ipfs.io

The aim is to create a free X/Y/Z tile system for developers who are creating map featured apps and have not enough resources to host a raster server or to pay for a similar service.

Resources for this pourpose are heavy in data storage, transmission and service availability. Now they can be, somewhat, soften.

The strength of IPFS is in static content storage and transmission, very helpful indeed, and OpenStreetMap gives you the data for free. You cannot use OSM as YOUR application tile server, yet you can access the data if you do it reasonably often. It is important to note that maps privided by OSM are dynamic, meaning that they change over time.

Work In Progress :)

For now, you can try a live demo here: http://pulsartronic.duckdns.org/ don’t expect speed, specially if it is the first time your region is accessed. Gateway list is short and sometimes they fail.
It basically access links like this one http://pulsartronic.duckdns.org/tile.php?z=7&x=66&y=46 for every tile it needs.


