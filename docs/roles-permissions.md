# Roles And Permissions

## User Groups

- Admin: full Joomla super user/admin access.
- Coordinator/Staff: can create, edit, and review all SRH Ambassador content in Fabrik.
- Ambassador: can view assigned events/inquiries and, if configured, edit their own ambassador profile.
- Public: can view published public pages and submit student inquiries.

## Joomla/Fabrik ACL Concept

- Public can view published ambassador, program, event, and FAQ lists.
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
5. Explanation of ambassador self-editing as a documented extension if it is not fully configured.
