# osm ipfs proxy
Tile server system based on IPFS

This is a small project that unifies https://openstreetmap.org raster tiles along with https://ipfs.io

The aim is to create a free X/Y/Z tile system for developers who are creating map featured apps and have not enough resources to host a raster server or to pay for a similar service.

Resources for this pourpose are heavy in data storage, transmission and service availability. Now they can be, somewhat, soften.

The strength of IPFS is in static content storage and transmission, very helpful indeed, and OpenStreetMap gives you the data for free. You cannot use OSM as YOUR application tile server, yet you can access the data if you do it reasonably often. It is important to note that maps provided by OSM are dynamic, meaning that they change over time.

Ok ... let's try to make a free, dynamic and distributed system (while trying to not to overload any server) to make a world map available for everybody, composed of raster files right now (it can also be done with vector tiles)

IPFS offers several options to help in this task, let's try to use them all.

A client application can ask for /X/Y/Z tiles to several sources:
1) directly to openstreetmap.org (which we are triyng to avoid as much as possible)
2) to a proxy server (.php files play that role)
3) to a ipfs/ipns gateway
4) directly through a instantiated ipfs node (using js-ipfs in this case)

As efficiently as possible, the client application tries all four options.

A proxy server:
1) Makes request to a raster tile server, connects to a ipfs node, adds requested files, stores its cid (and modification date) and responds it to clients. To have stored cids and modification data is much lighter than to have all tiles on disk, making it suitable for cheap VPS.
2) Does not respond with image data, it responds with a few bytes containing the cid and some other metadata.
3) Can also be itself a ipfs node, or it can connect to an external one, depending on available resources.
4) Helps in mantaining tiles up to date.

Once enough tiles are introduced to ipfs, temporary unavailability of raster tile servers, proxy servers or even gateways, wouldn't make the system completly unusable, yet free and up to date.

Replication of proxy servers is good for the system health, no matter to whom you are asking for a tile, if it was already added by another proxy server, you are going to receive it faster and the proxy server you are connecting to, would have made data replication (or not, depending to what ipfs node it is talking to) which is again, good.

ok, work in progress ... you can take a first glance here https://pulsartronic.com/map.html browse its code, you will find some (not much elegant) implemented things above described.

!!!! Code here is not up to date !!!! and code in the link is not something to be proud of :) yet it works.

