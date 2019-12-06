# osm ipfs proxy

Tile server system based on IPFS

This small project tries to unify https://openstreetmap.org raster tiles along with https://ipfs.io

You can take a first glance here https://pulsartronic.com/map.html browse the code, you are going find some implemented things below described.
It is a map application in which image storage is distributed, play with it, reload the page several times, change position and zoom, till your region is fully introduced and replicated throughout enough ipfs nodes (including yours), then it will be fast enough to be fully functional even to other users.

map.html and proxy.php are in a cheap VPS.
ipfstile.php is in a separate server, with more disk capacity.

The aim is to create a free X/Y/Z tile system for developers who are making map featured apps and have not enough resources to host a raster server nor to pay for a similar service.
Example tile /Z/X/Y output: http://a.tile.openstreetmap.org/5/17/12.png

Resources for this pourpose are heavy in data storage, transmission and service availability. Now they can be, somewhat, soften.

The strength of IPFS is in static content storage and transmission, very helpful indeed, and OpenStreetMap gives you the data for free. You cannot use OSM as YOUR application tile server, yet you can access the data if you do it reasonably often as a single user. It is important to note that maps provided by OSM are dynamic, meaning that they change over time.

IPFS offers several options to help in this task, i would like to try them all.

A client application can ask for /Z/X/Y tiles to several sources:
1) directly to openstreetmap.org (which we are triyng to avoid as much as possible)
2) to a proxy server (.php files play that role)
3) to a ipfs/ipns gateway (ie [ipns/ipfs]/Qm-cid-or-keyhash/X/Y/Z)
4) directly through a instantiated ipfs node (using js-ipfs in this case). this item hides one or two important things :)

As efficiently as possible, the client application tries all available options.

A proxy server:
1) Makes (if needed) a request to a raster tile server, connects to a ipfs node, adds requested file, stores its cid (and modification date) and responds it to clients.
Example output https://pulsartronic.com/proxy.php?z=5&x=17&y=10 it will be also possible to access the same data by referencig it as [ipns/ipfs]/Qm-cid-or-keyhash/X/Y/Z (WIP).
To have stored cids and modification data is much lighter than to have all tiles on disk, making it suitable for cheap VPS.
2) Does not respond with image data, it responds with a few bytes containing the cid and some other metadata. Image data is accessed through the ipfs network.
3) Can also be itself a ipfs node, or it can connect to an external one, depending on available resources.
4) Helps in mantaining tiles up to date.

Once enough tiles are introduced to ipfs, temporary unavailability of raster tile servers, proxy servers or even gateways, wouldn't make the system unusable.

Replication of proxy servers is also good for the system health, no matter to what proxy you are asking for a tile, if it was already added by another proxy server, you are going to receive it faster and the proxy server you are connecting to, would have made data replication, which is good.

ok, it is a work in progress ... 

Contribute :P

