# Joomla Frontend Pages

## Main Menu

- Ambassadors: Fabrik list filtered to active ambassadors.
- Programs: Joomla article intro plus Fabrik program list.
- Events: Fabrik event list ordered by date.
- FAQ: Fabrik FAQ list grouped by FAQ category.
- Contact: Fabrik student inquiry form.
- Language switch: English/German.

## Page Notes

### Ambassador Directory

Use a Fabrik list with card/list layout. Display photo, name, program, country/region, languages, and availability. Link each row to the Fabrik detail view.

### Ambassador Detail

Display full bio, countries/regions, languages, contact preference, and related programs. Public users should not see private email addresses.

### Program Overview

Display program name, degree level, department, description, and related ambassadors.

### Events

Display title, date/time, event type, location/online link, description, assigned ambassadors, optional club, and interested count. Logged-in students can mark themselves as interested.

### Clubs

Display club name, category, description, member count, related club polls, and related club events. Logged-in students can join a club or mark interest in a proposed club poll.

### Ambassador Dashboard

Expose Fabrik forms for ambassadors to create club polls, clubs, and club events. These map to `srh_club_polls`, `srh_clubs`, and `srh_events`.

### Multilingual Demo

The dynamic PHP demo under `/srh-demo/` supports English and German through the `lang` query parameter. In a full Joomla/Fabrik implementation, the same structure should be represented through Joomla language associations and translated menu/module strings.

### FAQ

Display published FAQs grouped by category. Use Joomla language associations or a language filter field to demonstrate multilingual structure.

### Inquiry Form

Public users can submit name, email, country, interested program, preferred language, and message. New records start with status `new`.
