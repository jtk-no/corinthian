# Corinthian

Nettsiden **https://corinthian.no**. Jan Thore kjøpte domenet fordi han liker navnet. Første leveranse er **bare en forside med logo og navn**: ingen meny, ingen andre sider.

## Kommunikasjon
- Svar alltid på **norsk**, kort og i et enkelt språk. Jan Thore er ikke utvikler til daglig, så forklar fagord første gang de brukes.
- Når noe må gjøres manuelt i Plesk eller GitHub, gi en nummerert steg-for-steg-liste.
- Spør før du gjør noe som ikke kan angres.

## Profil
- **Corinthian for Jan Thore:** høye søyler, moderne og elegant på samme tid. Navnet kommer fra et utested i Glasgow rundt 2005, men det er bare bakgrunn: **designet skal ikke bygge på bygningen i Glasgow.**
- **Farger:** nattblå `#14232A` (bunn), marmorhvit `#F4F5F2` (linjer og tekst), gull `#D2A066` (én detalj). Variablene står øverst i `public/assets/css/site.css`.
- **Skrift:** Marcellus, lagt på egen server (`public/assets/fonts/`), ikke hentet fra Google Fonts.
- **Logo:** midlertidig er variant A1 fra logovalget (søyle med kapitél, gull i de innerste bladene) i `public/assets/img/logo-mark.svg` og `public/favicon.svg`. Ikke endelig valgt. Når logoen endres, lages `public/apple-touch-icon.png` (180 × 180) på nytt fra `favicon.svg`.
- Siden før denne var svart med «CORINTHIAN» i en seriff mellom to tynne, grå streker.

## Fremdrift
- [ ] Første versjon: forside med logo og navn (bygget 23.10.2026, venter på at Claude får tilgang til repoet og på endelig logo).

## Beslutninger
- Ren PHP (8.2+) uten rammeverk og uten byggesteg. Ingen database ennå; MariaDB kan kobles på via `config/config.php` senere.
- Bare `public/` er synlig på nett (document root `corinthian.no/public`). Ingen `.htaccess` i rotmappen; `config/` har egen sperre. `DirectoryIndex index.php` i `public/.htaccess` fordi Plesk lager en egen `index.html`.
- `index.php` sender sikkerhetsoverskrifter (CSP uten skript og uten eksterne kilder) og gir 404 på alle andre adresser enn `/`.
- `apple-touch-icon` ligger inne i siden som data:-adresse, slik som på Huskdagen (iPhone hentet ellers ikke ikonet riktig).
- Arbeidsflyt: Claude pusher til en arbeidsgren og lager en pull request. Jan Thore fletter inn i `main`, og Plesk henter koden automatisk.

## Hosting – ServeTheWorld med Plesk
- Ingen SSH og ingen Node.js på serveren. Alt som kjører der må være PHP, og alt må ligge ferdig i repoet.
- Publisering: privat GitHub-repo `jtk-no/corinthian` → **Git i Plesk** (grenen `main`).
