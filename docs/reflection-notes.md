# Reflection Notes

## What Was Easy

- Defining the shared SRH Ambassador data model.
- Mapping public pages to CMS lists and forms.
- Creating a simple inquiry workflow.

## What Was Hard

- Joomla/Fabrik is more GUI-driven, so not every configuration is naturally represented as source code.
- Many-to-many relationships need careful join-table naming and form/list setup.
- Ambassador self-editing is possible but requires extra ACL and row-filter configuration.

## What Broke Or Needed Care

- The local machine needs a PHP stack or Docker to run Joomla.
- Fabrik must be installed manually through Joomla administrator if no CLI deployment flow is available.
- Public inquiry creation must be permissioned carefully so public users cannot see all inquiries.

## What Joomla/Fabrik Is Good At

- Traditional integrated CMS administration.
- Menu-driven public pages.
- Mature Joomla ACL and multilingual concepts.
- Quick form/list management after the extension is installed.

## What Strapi Is Good At

- Schema-as-code content modeling.
- API-first access.
- Clean separation between admin backend and frontend.
- Developer-friendly version control.

## Better Fit

Strapi is a better long-term fit for the SRH Ambassador platform because it can expose ambassador, program, event, and inquiry data to multiple future channels. Joomla/Fabrik is useful when SRH wants a single integrated CMS with less custom frontend engineering.

## Improvements With More Time

- Finish row-level ambassador self-editing in Joomla/Fabrik.
- Add screenshots from both admin panels.
- Deploy both systems to a public preview environment.
- Add multilingual German/English content for each FAQ and page.
