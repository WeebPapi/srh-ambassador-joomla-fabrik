# Fabrik Build Plan

## Lists And Tables

Create the following Fabrik lists, each backed by the matching database table from `database/srh_ambassador_sample.sql`.

- Ambassadors: `srh_ambassadors`
- Programs: `srh_programs`
- Countries/Regions: `srh_countries`
- Languages: `srh_languages`
- Events: `srh_events`
- Clubs: `srh_clubs`
- Club Polls: `srh_club_polls`
- Club Members: `srh_club_members`
- Student Inquiries: `srh_student_inquiries`
- FAQs: `srh_faqs`
- FAQ Categories: `srh_faq_categories`

## Join Tables

- Ambassador Programs: `srh_ambassador_programs`
- Ambassador Countries: `srh_ambassador_countries`
- Ambassador Languages: `srh_ambassador_languages`
- Event Ambassadors: `srh_event_ambassadors`
- Club Members: `srh_club_members`

## Field Types

- Photo: Fabrik image/upload element.
- Status fields: dropdown/radio element.
- Dates: date element.
- Long text: textarea/editor element.
- Relations: database join or cascading dropdown where appropriate.

## Frontend Menu Items

Create Joomla menu items that point to Fabrik list or form views:

- Ambassadors -> Fabrik list `Ambassadors`
- Programs -> Fabrik list `Programs`
- Events -> Fabrik list `Events`
- Clubs -> Fabrik list `Clubs`
- Ambassador Dashboard -> Fabrik forms `Club Polls`, `Clubs`, and `Events`
- FAQ -> Fabrik list `FAQs`
- Contact -> Fabrik form `Student Inquiries`

## Filters

- Public ambassador list: `status = active`.
- Public FAQ list: `published = 1`.
- Event list: sort by `starts_at`.
- Club list: filter `status = active`.
- Club poll list: sort open/popular polls first.
- Inquiry admin list: sort by newest first and filter by status.
