# Digi-HAK API-Workshop 2024

## Recap UX-Workshop

- Figma-Prototyp ansehen
- Wir kümmern uns heute um die Daten und bauen eine API

## Definition API

- Application Programming Interface = Programmierschnittstelle
- ermöglicht Anwendungen miteinander zu kommunizieren
- !== DB oder Server, sondern Code, der Zugangspunkte für Server regelt und Kommunikation ermöglicht
- APIs sind überall - wir nutzen sie täglich (Wettervorhersage, E-Commerce (Bestandsdaten), Terminvereinbarungen, etc...)

### Arten von APIs

- Internal API – geschützter Zugang
- Partner / Customer APIs – eingeschränkter Zugang
- Open Source API – öffentlich zugänglich für Dritte (z.B.: https://pokeapi.co/)
- verschiedene Architekturtypen (REST, SOAP, GraphQL, etc.)

## REST API

- Youtube-Video ansehen
- Welche Endpunkte werden wir benötigen?

---

### Benötigte Endpunkte

1. GET brands
2. GET models
3. GET registrations
4. GET fuels
5. GET rating

---

## Start Programming

- Starter-Project klonen https://github.com/vivid-planet/digihak-car-search-api-starter
- DB-Setup vorzeigen

### URL-Rewriting für RESTful URLs

<mark> index.php <mark>

```php
var_dump($_SERVER["REQUEST_URI"]);
```

- im Postman arufren:
  - http://localhost:8080/digihak-car-search-api-starter/index.php -> 200
  - http://localhost:8080/digihak-car-search-api-starter/brands -> 404

> Für restful-URLs benötigen wir URL-rewriting!

<mark>.htaccess<mark>

```
RewriteEngine On
RewriteRule . index.php
```

> Jede URL wird so das index.php File aufrufen!
> '.' = matcht alle Pfade

---

> **MVC**
>
> - Model = enthält Daten
> - View = Ansicht für Darstellung der Daten
> - Controller verwaltet Ansicht und Modell (= steuert den Response)
