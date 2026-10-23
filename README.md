# Corinthian

Forsiden til **https://corinthian.no**: logo og navn, ingenting mer.

Ren PHP uten rammeverk og uten byggesteg, publisert fra GitHub til Plesk hos ServeTheWorld, slik som Huskdagen.

## Mapper

| Mappe | Innhold |
| --- | --- |
| `public/` | Det eneste som er synlig på nett (document root): `index.php`, `.htaccess`, `favicon.svg`, `apple-touch-icon.png` og `assets/` |
| `public/assets/` | Stilark (`css/site.css`), logo (`img/logo-mark.svg`) og skrift (`fonts/`, Marcellus, lisens OFL) |
| `config/` | `config.example.php` (mal). `config.php` ligger ikke i Git og trengs ikke ennå |
| `bin/` | `dev-router.php` for lokal testing |

## Kjøre lokalt

```
php -S localhost:8000 -t public bin/dev-router.php
```

Åpne http://localhost:8000.

## Oppsett i Plesk (første gang)

**1. Domene og SSL**
1. *Websites & Domains* → corinthian.no → *Hosting Settings*: PHP 8.2 eller nyere.
2. *SSL/TLS Certificates*: slå på Let's Encrypt for `corinthian.no` og `www.corinthian.no`.

**2. Git**
1. Gå til domenet → *Git* → *Add Repository* → *Remote Git hosting*.
2. Lim inn SSH-adressen til repoet: `git@github.com:jtk-no/corinthian.git`.
3. Plesk viser en **SSH-nøkkel**. Kopier den.
4. Åpne GitHub → repoet → *Settings* → *Deploy keys* → *Add deploy key*. Lim inn nøkkelen og lagre. Ikke huk av for skrivetilgang.
5. Tilbake i Plesk:
   - Sett *Deployment path* til domenemappen, `corinthian.no`.
   - Velg grenen `main`.
   - Velg *Automatic deployment*.
6. Klikk *Create* / *Pull now*.

**3. Document root**
1. *Hosting Settings*: sett *Document root* til `corinthian.no/public`.
2. Gå til *Files* → `corinthian.no/public/`. Slett `index.html` hvis Plesk har laget den.
3. Gamle filer fra den forrige siden som ligger direkte i `corinthian.no/` (f.eks. `index.html`) kan slettes eller flyttes når den nye siden virker.

**4. Konfigurasjon (valgfritt)**
Siden virker uten. Vil du ha riktig adresse når siden deles, kopier `config/config.example.php` til `config/config.php` i *Files*.

## Ny versjon

Ny kode legges i en pull request på GitHub. Når den flettes inn i `main`, henter Plesk koden automatisk. Ellers trykker du *Pull now* under *Git*.

## Database senere

Trengs det database, lages en MariaDB/MySQL-database i Plesk (*Databases* → *Add Database*), og tilkoblingen fylles inn under `db` i `config/config.php`. Passord skal aldri i Git.
