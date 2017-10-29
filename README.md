# SPiD for Joomla!
Package per l'integrazione nel CMS Joomla! di SPID, il Sistema Pubblico di Identità Digitale per l’accesso ai servizi online delle Pubbliche Amministrazioni italiane.

## Prerequisiti
* Joomla! 3.7+
* Dominio con certificazione SSL e protocollo https
* Preinstallazione della libreria [SimpleSpidPhp](https://github.com/retepasw/simplespidphp-pasw)
* Avvio "Procedura Tecnica" prevista AGiD e generazione del metadata rif. [https://www.spid.gov.it/sei-una-pubblica-amministrazione](https://www.spid.gov.it/sei-una-pubblica-amministrazione)

## Installazione
Procedura di installazione e aggiornamento secondo gli standard previsti dal CMS Joomla!

## Configurazione
Il package utilizza il core di Joomla! per le operazioni di autenticazione utente e registrazione nuovo utente. Le impostazioni di Joomla! sono quelle standard accessibili attraverso le opzioni della Gestione Utenti e del plugin User - Joomla!
Agli utenti registrati con SPiD for Joomla! sono attribuiti il codice fiscale come username e l'indirizzo Email di registrazione all'IdP

## Developer e manteiner
Helios Ciancio [eshiol](https://github.com/eshiol)

## Note
Il package include il bottone di scelta dell'Identity Provider per l'accesso ai servizi dei Service Provider [spid-sp-access-button](https://github.com/italia/spid-sp-access-button) v1.4

