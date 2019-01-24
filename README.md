OJS NBN:IT
===========
Plug-in per la versione 3 di OJS.
v. 2.0.0 alpha
------------

Plugin per l'assegnazione automatica di identificatori [urn:nbn](http://www.depositolegale.it/national-bibliography-number/) nel namespace NBN:IT agli articoli pubblicati con [Open Journal Systems](http://pkp.sfu.ca/?q=ojs) v. 3.

Funzionalita'
-------------
1. Aggiunge due tabelle al db per permettere la registrazione degli NBN.
2. Aggiunge un'interfaccia per settare il plugin in **Settings->Website->Plugin->Public Identifier Plugins**
3. Aggiunge in **Submission->workflow->Metadata->Identifiers** un link per richiedere l'NBN:IT e la checkbox per assegnarlo a un singolo articolo pubblicato.
4. Aggiunge in **Issues->BackIssues->Edit->Identifiers** un link per richiedere gli NBN:IT per tutti gli articoli di un volume pubblicato.
5. Stabilisce un dialogo con le API di Magazzini Digitali. Prima di essere abilitati all'utilizzo della API deve essere inoltrata richiesta di abilitazione di un account di accesso al servizio NBN (v sotto).

Requisiti di sistema
--------------------
1. OJS versione 3.1.1.-4 o superiore
2. Estensione PHP 'curl' installata
3. Estensione PHP 'dom' installata 

Known Bugs
---------------
Il link per la generazione del NBN sembra non far nulla, invece ricaricando la pagina si vede che l'NBN è stato creato correttamente.
Dopo la richiesta dovrebbe apparire uno spinner finché non si ottiene una risposta.

Installazione  
-------------
L'installazione prevede due step:
1. Apportare le modifiche al DB descritte nel file schema.xml
2. Caricare i file sul server utilizzando l'apposito modulo di OJS dedicato all'installazione dei plugin (il plugin deve essere in formato compresso .tar.gz)

Credenziali
-----------
Le credenziali di autenticazione al webservice vengono rilasciate a seguito dell'adesione al servizio [MD](http://www.depositolegale.it/nbn-flusso-di-lavoro/)

Licenza
-------
Il plugin e' sviluppato da alfredo.cosco@gmail.com partedo dal precedente versione di [CILEA](http://www.cilea.it) ed e' rilasciato sotto [GNU General Public License v2](http://www.gnu.org/licenses/gpl-2.0.html)
