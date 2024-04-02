# LB2 Application with MFA for Microsoft Authenticator
Die Applikation wird im Rahmen der LB2 im [Modul 183](https://gitlab.com/ch-tbz-it/Stud/m183/m183) durch die Lernenden bearbeitet.

## Hinweise zur Installation
Wichtig: die DB wird nicht automatisch erzeugt. Verbinden Sie sich dafür mit einem SQL-Client Ihrer Wahl auf den Datenbankcontainer (localhost port 3306) und verwenden Sie [m183_lb2.sql](./todo-list/includes/m183_lb2.sql), um die Datenbank / Datenstruktur zu erzeugen. Beachten Sie, dass die Datenbank nach einem "neu bauen" des Containers wieder weg sein wird und Sie diese nochmals anlegen müssten. Zudem muss man bei einer ersten Installation den befehl `composer install` innerhalb des Docker containers ausführen damit die MFA funktioniert.

## SQL 
Damit die Applikation funktioniert wird davon ausgegangen, dass jeder Username in der Datenbank nur einmal existiert. Damit dies sichergestellt werden kann in der Zukunft, könnte man beim feature für die User-Erstellung eine Prüfung hinzufügen.

## Gefundene Schwachstellen
Unsanierte Inputfelder 
Unsichere SQL Abfragen
Unsicherer Gebrauch von Cookies
Unzutreffendes / Nicht vorhandenes Error Handling
Fehlerhaftes Routing 
	- Unerwünschte Anzeige von Informationen in der URL 
	- Unerlaubter Zugriff auf Files möglich, welche geschützt sein sollten  (bspw. abrufen des DB File lädt das DB Schema lokal herunter)
Ein Suchfeld erlaubt das Abrufen von beliebigen URL's 
Risiken von XSS und MIME-Sniffing gefunden
Serverinformationen sichtbar
Passwörter sind ungehasht in der Datenbank gespeichert


## Implementierte Funktion
Two Factor Authentication mit Microsoft Authenticator