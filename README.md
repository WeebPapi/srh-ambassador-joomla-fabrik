# SRH Ambassador Platform - Joomla/Fabrik CMS

Traditional CMS implementation for the SRH Ambassador digital service platform using Joomla 5.4.5 and Fabrik.

## What This Repo Contains

- Docker-based Joomla 5.4.5 + MariaDB local setup
- Fabrik data model plan for ambassadors, programs, countries, languages, events, inquiries, FAQs, and FAQ categories
- Importable SQL schema and sample data for the SRH Ambassador MVP
- Role and permission concept for Admin, Coordinator/Staff, Ambassador, and Public users
- Frontend page map for the public Joomla demo
- Static public demo prototype in `public-demo/` for quick review before the Joomla/Fabrik build is clicked together
- Reflection and comparison notes for the course deliverables

## Run Locally

1. Copy `.env.example` to `.env` if you want to adjust ports or passwords.
2. Start the stack:

```powershell
docker compose up -d
```

3. Open Joomla at `http://localhost:8081`.
4. Finish the Joomla installer with:
   - Database host: `db`
   - Database user: `joomla`
   - Database password: `joomla`
   - Database name: `joomla`
5. Install Fabrik from the Joomla administrator panel.
6. Create Fabrik lists/forms using `fabrik/build-plan.md`.
7. Import the optional sample schema/data from `database/srh_ambassador_sample.sql` into MariaDB or recreate the fields through Fabrik.

## Demo Pages To Create In Joomla

- Ambassador directory
- Ambassador detail page
- Program overview
- Event list
- FAQ page
- Inquiry/contact form

The public page structure and sample copy are documented in `docs/frontend-pages.md`.

## Known Limitations

- Fabrik installation is a manual administrator step because Joomla extensions are normally installed through the Joomla backend.
- Ambassador self-editing is documented as an intended permission setup. It can be enabled with Fabrik ACL row filters after user accounts are mapped to ambassador records.
- The static `public-demo/` is not a replacement for Joomla. It is included only as a lightweight preview of the public-facing content.
