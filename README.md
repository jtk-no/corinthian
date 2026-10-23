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

**2. Git (med token, ikke SSH-nøkkel)**

Webhotellet deler én SSH-nøkkel mellom alle domenene, og den er allerede deploy key for Huskdagen. GitHub tillater én deploy key per repo, så Plesk henter Corinthian med HTTPS og en token (en tilgangsnøkkel som virker som et passord) i stedet.

1. GitHub → profilbildet → *Settings* → *Developer settings* → *Personal access tokens* → *Fine-grained tokens* → *Generate new token*.
   - *Repository access*: *Only select repositories* → `jtk-no/corinthian`.
   - *Permissions* → *Contents*: *Read-only*.
   - Velg en utløpsdato og skriv den ned. Tokenet må fornyes da (se under).
2. Kopier tokenet. Det vises bare én gang, og skal aldri i Git, README eller e-post.
3. Plesk → domenet → *Git* → *Add Repository* → *Remote Git hosting*.
4. Adresse: `https://github.com/jtk-no/corinthian.git`. Brukernavn: GitHub-brukernavnet ditt. Passord: tokenet.
5. *Deployment path*: domenemappen (den som var document root før, f.eks. `httpdocs`). Gren: `main`. *Automatic deployment*.
6. Klikk *Create* / *Pull now*.
7. For automatisk henting når `main` endres: åpne repoet i Plesk → *Repository Settings* og kopier *Webhook URL*. GitHub → repoet → *Settings* → *Webhooks* → *Add webhook*: lim inn adressen, *Content type* `application/json`, bare *push*-hendelser. Uten webhook trykker du *Pull now* etter hver fletting.

**Når tokenet går ut:** lag et nytt token som i steg 1–2, og bytt passordet under *Repository Settings* for repoet i Plesk.

**3. Document root**
1. *Hosting Settings*: sett *Document root* til domenemappen + `/public`, f.eks. `httpdocs/public`.
2. Gå til *Files* → `httpdocs/public/`. Slett `index.html` hvis Plesk har laget den.
3. Gamle filer fra den forrige siden som ligger direkte i domenemappen (f.eks. `index.html`) kan slettes eller flyttes når den nye siden virker.

**4. Konfigurasjon (valgfritt)**
Siden virker uten. Vil du ha riktig adresse når siden deles, kopier `config/config.example.php` til `config/config.php` i *Files*.

## Ny versjon

Ny kode legges i en pull request på GitHub. Når den flettes inn i `main`, henter Plesk koden automatisk. Ellers trykker du *Pull now* under *Git*.

## Database senere

Trengs det database, lages en MariaDB/MySQL-database i Plesk (*Databases* → *Add Database*), og tilkoblingen fylles inn under `db` i `config/config.php`. Passord skal aldri i Git.
