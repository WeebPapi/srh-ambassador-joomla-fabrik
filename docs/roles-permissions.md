# Roles And Permissions

## User Groups

- Admin: full Joomla super user/admin access.
- Coordinator/Staff: can create, edit, and review all SRH Ambassador content in Fabrik.
- Ambassador: can use a separate dashboard to create club interest polls, create clubs after enough interest, add club events, view assigned events/inquiries, and edit their own ambassador profile if configured.
- Student: can view clubs, member counts, club events, and event interest counts after login.
- Public: can view published public pages and submit student inquiries.

## Joomla/Fabrik ACL Concept

- Public can view published ambassador, program, event, and FAQ lists.
- Logged-in students can view club lists, club polls, club members, and club event interest counts.
- Ambassadors can create records in `srh_club_polls`, `srh_clubs`, and club-scoped `srh_events`.
- Public can create student inquiry records, but cannot list all submitted inquiries.
- Coordinator/Staff can access Fabrik lists, forms, and records for all entities.
- Admin can manage users, Joomla configuration, Fabrik lists/forms, and all structured data.
- Ambassador self-editing can be configured by adding a Joomla user reference field to `srh_ambassadors` and applying Fabrik row-level ACL filters.

## Practical Course Demo

For the live demonstration, show:

1. Public ambassador directory.
2. Public inquiry form submission.
3. Coordinator view of submitted inquiry in Joomla administrator/Fabrik.
4. Admin view of Fabrik forms/lists and relationships.
5. Ambassador dashboard creating a club interest poll.
6. Ambassador converting a popular poll into a club and adding a club event.
7. Logged-in student club directory with members and event interest counts.
8. Explanation of ambassador self-editing as a documented extension if it is not fully configured.
