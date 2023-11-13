# Car-Search API

API für das Demo-Projekt "Fahrzeugsuche" im Zuge des Praxisworkshops an der DigiHAK Neumarkt.

**Inhalt:**

- [Car-Search API](#car-search-api)
  - [TECHNOLOGIEN](#technologien)
  - [DEV-SETUP](#dev-setup)
    - [Datenbank-Setup](#datenbank-setup)
      - [1. Datenbank erstellen](#1-datenbank-erstellen)
      - [2. Tabellen inkl. Daten importieren](#2-tabellen-inkl-daten-importieren)
      - [3. DB-config eintragen](#3-db-config-eintragen)
  - [DEV-URLS](#dev-urls)
  - [API-URLS](#api-urls)

## TECHNOLOGIEN

-   php REST-API
-   MVC Muster (Model View Controller)
-   MySQL Datenbank

## DEV-SETUP

1. XAMPP (= Apache WebServer + MySQL-Server) downloaden und installieren https://www.apachefriends.org/de/index.html

2. Apache Web Server Port auf 8080 ändern

3. Postman (= API client) downloaden: https://www.postman.com/downloads/   

### Datenbank-Setup

Am einfachsten geht das Setup via phpMyAdmin-Oberfläche (sie [phpMyAdmin](#dev-urls)).

#### 1. Datenbank erstellen

Eine neue Datenbank mit dem Namen `car_search` erstellen.

> Im ordner *sql*, in der Datei *database.sql* ist das entsprechende SQL-Statement zum erstellen der Datenbank zu finden.

#### 2. Tabellen inkl. Daten importieren

![table_import](./img/table_import.png)

- Datebank `car_search` auswählen
- in der oberen Menüleiste auf *Importieren* klicken
- die KOMPRIMIERTE Datei *car_search.sql.zip* (aus dem Ordner *sql*) hochladen
- auf "Importieren" klicken

Die Tabellen sollten nun angelegt und befüllt worden sein:

![tables](./img/tables.png)

#### 3. DB-config eintragen

- Direkt im Root-Verzeichnis (auf der selben Ebene wie das `index.php`) eine neue Datei `config.php` erstellen.
- Den Inhalt aus der Datei *config.dist.php* kopieren und die enstprechenden Werte für die eigene Datenbank eintragen.


## DEV-URLS

- Webserver: http://localhost:8080
- phpMyAdmin: http://localhost:8080/phpmyadmin/
- MySQL DB: Port 3306

## API-URLS

`/digihak-car-search/brands`

**Parameter:** keine

**&rarr;** gibt alle verfügbaren Marken zurück
___

`/digihak-car-search/cars`

**Parameter:**
- brandId (= required)
- model
- registration
- mileage
- fuelId

**&rarr;** gibt alle Fahrzeuge die den Filter-Kriterien (= Parameter) entsprechen zurück
___

`/digihak-car-search/cars/models`

**Parameter:**
- brandId (= required)

**&rarr;** gibt alle Modelle einer Marke zurück
___

`/digihak-car-search/cars/registrations`

**Parameter:**
- brandId (= required)
- model (= required)

**&rarr;** gibt alle Erstzulassungsjahre die den Filter-Kriterien (= Parameter) entsprechen zurück
___

`/digihak-car-search/cars/fuels`

**Parameter:**
- brandId (= required)
- model (= required)
- registration (= required)

**&rarr;** gibt alle Krafstoffarten die den Filter-Kriterien (= Parameter) entsprechen zurück
___

`digihak-car-search/cars/rating`

**Parameter:**
- brandId (= required)
- model (= required)
- registration (= required)
- mileage (= required)
- fuelId (= required)

**&rarr;** gibt alle Fahrzeuge die den Filter-Kriterien (= Parameter) entsprechen mit der entsprechenden Fahrzeugbewertung zurück.
___

Alle API-Endpunkte sind auch in dieser Postman-Collection zu finden:

[![Run in Postman](https://run.pstmn.io/button.svg)](https://app.getpostman.com/run-collection/28200076-3b6dc5f4-ac12-4636-9799-e8c93465a708?action=collection%2Ffork&source=rip_markdown&collection-url=entityId%3D28200076-3b6dc5f4-ac12-4636-9799-e8c93465a708%26entityType%3Dcollection%26workspaceId%3D2b5eebae-b17c-45b9-8021-c40dbdf44df7)
