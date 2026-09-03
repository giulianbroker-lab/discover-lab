# Partner Sales Hub

MVP della piattaforma di affiliazione/reseller per la vendita dei servizi digitali.

## Stack V1
- PHP 8.2+
- PDO SQLite
- Session authentication
- Responsive HTML/CSS senza framework obbligatori

## Funzioni V1
- Admin e Partner
- Catalogo servizi
- Commissione configurabile (default 40%)
- Landing page personalizzata per partner
- Tracking referral tramite cookie/sessione
- Form lead collegato al partner
- Dashboard partner con lead e commissioni
- Sales Center per ogni servizio
- Upload PDF/immagini da estendere nella V2

## Installazione
1. Caricare i file su un server con PHP 8.2+ e SQLite abilitato.
2. Aprire `/install.php` una sola volta.
3. Creare l'account amministratore.
4. Eliminare o rinominare `install.php` dopo l'installazione.
5. Accedere a `/`.

Account demo partner: può essere creato dal pannello Admin.

## URL
- `/` dashboard/login
- `/service.php?id=1` pagina pubblica del servizio
- `/p.php?u=partner-slug&s=service-slug` landing page del partner
- `/admin.php` pannello Admin
- `/partner.php` pannello Partner

## Roadmap
V2: MySQL, Laravel, builder visuale, PDF/immagini, offerte commerciali, ordini, pagamenti, commissioni approvate/pagate, AI Sales Assistant, WhatsApp, email, API e analytics avanzate.
