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

**2. Git (offentlig repo over HTTPS, uten innlogging)**

Repoet er **offentlig**. Det inneholder bare forsiden; passord og nøkler skal aldri i Git uansett.
SSH-nøkkel og token virket ikke på webhotellet: webhotellet har én SSH-nøkkel for alle domenene, og den er allerede deploy key for Huskdagen (GitHub tillater én deploy key per repo), og Plesk kan ikke sende passord/token over HTTPS (`pass-from-env.sh: Permission denied`, 23.10.2026).

1. Plesk → domenet → *Git* → *Add Repository* → *Remote Git hosting*.
2. Adresse: `https://github.com/jtk-no/corinthian.git`. La brukernavn og passord stå tomme.
3. *Deployment path*: domenemappen (den som var document root før, f.eks. `httpdocs`). Gren: `main`. *Automatic deployment*.
4. Klikk *Create* / *Pull now*.
5. For automatisk henting når `main` endres: åpne repoet i Plesk → *Repository Settings* og kopier *Webhook URL*. GitHub → repoet → *Settings* → *Webhooks* → *Add webhook*: lim inn adressen, *Content type* `application/json`, *Just the push event*. Uten webhook trykker du *Pull now* etter hver fletting.

**3. Document root**
1. *Hosting Settings*: sett *Document root* til domenemappen + `/public`, f.eks. `httpdocs/public`.
2. Gå til *Files* → `httpdocs/public/`. Slett `index.html` hvis Plesk har laget den.
3. Gamle filer fra den forrige siden som ligger direkte i domenemappen (f.eks. `index.html`) kan slettes eller flyttes når den nye siden virker.

**4. Konfigurasjon (valgfritt)**
Siden virker uten. Vil du ha riktig adresse når siden deles, kopier `config/config.example.php` til `config/config.php` i *Files*.

## Ny versjon

Ny kode legges i en pull request på GitHub. Når den flettes inn i `main`, henter Plesk koden automatisk. Ellers trykker du *Pull now* under *Git*.

### Når repoet er privat

Plesk henter uten innlogging, så *Pull now* feiler med «Repository not found» mens repoet er privat. Siden på nett lever videre som den er.

Slik legger du ut en ny versjon:
1. GitHub → repoet → *Settings* → helt nederst *Change visibility* → *Make public*.
2. Plesk → corinthian.no → *Git* → *Pull now*. Sjekk https://corinthian.no.
3. GitHub → *Settings* → *Change visibility* → *Make private*.

Varig løsning: ServeTheWorld retter `pass-from-env.sh: Permission denied` i Git-utvidelsen i Plesk. Da kan Plesk hente det private repoet med en fine-grained token (bare lesetilgang til `jtk-no/corinthian`), og *Pull now* og webhook virker som før.

## Database senere

Trengs det database, lages en MariaDB/MySQL-database i Plesk (*Databases* → *Add Database*), og tilkoblingen fylles inn under `db` i `config/config.php`. Passord skal aldri i Git.
