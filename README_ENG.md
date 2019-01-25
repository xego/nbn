OJS NBN: IT
===========
Plug-in for version 3 of OJS.
v. 2.0.0 alpha
------------

Plugin for the automatic assignment of identifiers [urn: nbn] (http://www.depositolegale.it/national-bibliography-number/) in the namespace NBN:IT to the articles published with [Open Journal Systems] (http: // pkp.sfu.ca/?q=ojs) v. 3.

Functionality
-------------
1. Adds two tables to the DB to allow registration of NBNs.
2. Add an interface to set the plugin in ** Settings-> Website-> Plugin-> Public Identifier Plugins **
3. Add a link to request the NBN:IT and the checkbox to assign it to a single published article in ** Submission-> workflow-> Metadata-> Identifiers **.
4. Add a link to request NBN:IT for all the articles of a published issue/volume in ** Issues-> BackIssues-> Edit-> Identifiers **.
5. Establishes a dialogue with the Magazzini Digitali APIs. Before being enabled to use the API must be forwarded request to enable an account to access the NBN service (v below).

System requirements
--------------------
1. OJS version 3.1.1.-4 or higher
2. PHP 'curl' extension installed
3. PHP extension 'dom' installed

Known Bugs
---------------
The link for the generation of NBN seems to do nothing, instead reloading the page we see that the NBN was created correctly.
A spinner should appear after the request until a response is obtained.

Installation
-------------
Upload the files to the server using the appropriate OJS module dedicated to installing the plugins (the plugin must be in compressed format .tar.gz)

Credentials
-----------
The authentication credentials to the webservice are issued after joining the service [MD] (http://www.depositolegale.it/nbn-flusso-di-lavoro/)

License
-------
The plugin is developed by alfredo.cosco@gmail.com from the previous version of [CILEA] (http://www.cilea.it) and is released under [GNU General Public License v2] (http: // www. .gnu.org / licenses / gpl-2.0.html)
