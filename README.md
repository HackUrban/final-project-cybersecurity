## SELFWORK 1: Rate limiter mancante

### Scenario:
Creare ed eseguire uno script (es. in bash con curl) che lancia moltissime richieste sulla stessa rotta con il pericolo di un denial of service: 
ho eseguito 
## ATTACCO: 
1. scheda terminale windows bash aperta con il server PHP 8.3.12 Development Server (http://localhost:8002) in esecuzione per simulare la macchina dell'attacker;

2. scheda terminale dove mi posiziono in XXX-AttackTools e lancio lo script "for i in {1..1000}; do curl -X GET http://external.user:8000/articles/search & done" --> mi restituisce moltissime richieste;

3. ultima scheda terminale dove ho lanciato il comando $ php artisan serve --host=cyber.blog --port=8000 
ed è in esecuzione. qui si vedono le richieste generate dallo script. 
Conseguenza: Da Gestione attività, vedo che l'attività della CPU aumenta notevolmente, oltre al rumore fisico del PC, inoltre si blocca il sito web come screenshot nella cartella XXX-AttackTools/dos/screenshot/dos riuscito.png

### MITIGAZIONE:
- Rate limiter su /careers/submit
- Rate limiter su /article/search
- Rate limiter globale

CONCLUSIONE: inserito il rate limiter locale sulla rotta http://external.user:8000/articles/search e globale, e creato il midlleware app/Http/Middleware/RateLimit.php
Implementando di nuovo l'attacco, la pagina browser restituisce l'errore 429 - too many requests, e i log mostrano le richieste bloccate dal rate limiter, come da screenshot in allegato nella cartella XXX-AttackTools/dos/screenshot/dos riuscito.png 


## SELFWORK 2: Logging mancante per operazioni critiche

### Scenario:
Sui tentativi precedenti di DoS non si può risalire al colpevole violando il principio di accountability e no repudiation

### Mitigazione:
Log di:
- login/registrazione/logout
- creazione/modifica/eliminazione articolo
- assegnazione/cambi di ruolo

appunti: 
- i log in laravel vengono gestiti dalla libreria Monolog, impostati in config/logging.php 
- ci sono log "normali" o con processor (più automatizzati e valgono globalmente) 
- i processor "controllano" le richieste e aggiungono informazioni a quelle raccolte prima di salvare il log 
- quando imposti in logging.php i log o i processor indichi il file o il canale dove andrà salvato il log 

## 14/03 
creato il middleware LogCustomRoutes; devi inserire i path delle 3 routes da verificare 

+ dopo valuta soluzione globale con un processor, magari che raccolga meno info per non spammare logging.php 
[vedi chat gpt per processo] 

// primo errore: bloccato processo per errore in php artisan serve: non si visualizza la pagina in broswer ma solo routes con "formatta il codice"

//secondo errore: Log classe non riconosciuta 

## SELFWORK 3: Operazioni critiche in post e non in get

### Scenario: 
Ci si espone a possibili attacchi CSRF portando in questo caso ad una vertical escalation of privileges.
Provare un attacco csrf creando un piccolo server php che visualizzi una pagina html in cui in background scatta una chiamata ajax ad una rotta potenzialmente critica e non protetta (es. /admin/{user}/set-admin). Partendo dal browser dell'utente è possibile che l'azione vada in porto in quanto l'utente ha i privilegi adeguati.

### Mitigazione
Cambiare da get a post, facendo i dovuti controlli

## ATTACCO: 
1. ho implementato l'attacco disattivando i middleware già presenti in routes/web.php per le rotte vulnerabili ('admin', 'admin.local');

2. ho copiato il file XXX-AttackTools/csrf/index.html in public/csrf/index.html per renderla visibile al browser

3. all'interno di public/csrf/index.html ho modificato: 
- il link della pagina di distrazione in http://cyber.blog:8000/csrf/index.html
- il link di redirect per far scattare la funzione onclick in http://cyber.blog:8000/admin/2/set-admin 
- nel link di redirect ho inserito utente 3 cioè user@aulab.it [ corrisponde al record dell'utente nel db locale ] 
- ho usato cyber.blog come server per far andare a buon fine l'attacco sulla stessa rete 

4. ho cercato direttamente nel browser la pagina http://cyber.blog:8000/csrf/index.html , senza compiere alcuna azione dopo 5s il browser ti reindirizza sulla rotta http://cyber.blog:8000/admin/3/set-admin e Steve Manson (user@aulab.it) guadagna privilegi admin e si modifica anche il record nel database (come da screenshot salvati in XXX-AttackTools/csrf/screenshot) 

5. ho commentato temporaneamente il middleware 'admin' per tutte le rotte admin per far andare a buon fine l'attacco 

6. dopo aver modificato le rotte da get a patch, non è più possibile implementare attacco: restituisce errore laravel come da screenshot in allegato. 

7. nella dashboard admin è possibile vedere i form di richiesta ruoli, dopo aver modificato il file resources/views/admin/request-table.blade.php decommentando i form ed eliminando i link href 

## SELFWORK 4: Uso non corretto di fillable nei modelli

### Scenario 
Un utente malevolo può provare a indovinare campi tipici di ruoli utente tipo isAdmin, is_admin etc.. alterando il form dal browser 

### Mitigazione
Nella proprietà fillable del modello in questione inserire tutti solo i campi gestiti nel form



## SELFWORK 5: ssrf attack per api delle news

### Scenario
Esiste la funzionalità di suggerimento news recenti in fase di scrittura dell'articolo per prendere ispirazione. E' presente un menu a scelta facilmente alterabile da ispeziona elemento. L'utente malintenzionato con un minimo di conoscenza del sistema cambia l'url e prova a far lanciare al server una richiesta che lui non sarebbe autorizzato.
Per esempio il server recupera dei dati sugli utenti da un altro server in esecuzione sulla porta 8001. 


### Mitigazione
Rimodellare la funzionalità in modo tale da non poter lasciare spazio di modifica dell'url da parte di utenti malevoli. Implementare o migliorare la validazione delgli input.

https://newsapi.org/docs/endpoints/top-headlines
NewsAPI - api key 5fbe92849d5648eabcbe072a1cf91473



## SELFWORK 6: Stored XSS Attack

### Scenario
Durante la creazione di un articlo si può manomettere il body della richiesta con un tool tipo burpsuite in modalità proxy in modo da evitare l'auto escape eseguito dall'editor stesso e far arrivare alla funzionalità di creazione articolo uno script malevelo nel testo.
Questo script verra memorizzato ed eseguito quando un utente visualizza l'articolo infettato.
Supponiamo che ci sia una misconfiguration a livello di CORS (config/cors.php) che quindi permetta richieste da domini esterni, utile quando frontend e backend sono separati ma se non opportunamente configurato risulta essere un grave problema.

### Mitigazione
Creare un meccanismo che filtri il testo prima di salvarlo e per essere sicuri anche in fase di visualizzazione dell'articolo.
