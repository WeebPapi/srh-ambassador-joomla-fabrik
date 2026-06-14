# Joomla/Fabrik Compared With Strapi

## Setup Difficulty

Joomla needs a PHP/MySQL web stack and an extension install workflow. Docker makes the base CMS repeatable, but Fabrik configuration is still mostly GUI-driven.

Strapi is easier to reproduce from source because content types, relations, and frontend code can live directly in Git.

## Data Modeling

Fabrik provides structured lists/forms inside Joomla and works well for relational form-driven data. Complex many-to-many relationships require careful join table setup.

Strapi models the same entities as API content types with explicit schema files and relation definitions.

## Roles And Permissions

Joomla has mature ACL and menu-level access control. Fabrik adds list/form permissions and can support row-level logic.

Strapi has clear admin roles and public/authenticated API permissions. Fine-grained ambassador self-editing requires custom policies or controllers.

## Frontend Flexibility

Joomla is integrated: backend, content, menus, templates, and frontend live together.

Strapi is headless: the separate frontend gives more freedom but also adds another app to build and deploy.

## Multilingual Support

Joomla has mature multilingual features through language packs, language filters, and associations.

Strapi can model language as a relation and can also use internationalization plugins.

## Media And Documents

Joomla media manager and Fabrik upload fields cover ambassador photos and optional documents.

Strapi has a built-in upload plugin and exposes media through the API.

## API Support

Joomla can expose APIs, but this is not the default mental model of a Joomla/Fabrik build.

Strapi is API-first and therefore stronger for mobile apps, external websites, or integration with other SRH systems.

## Deployment Complexity

Joomla deploys as one traditional CMS plus database.

Strapi deploys backend, database, media storage, and frontend separately.

## Maintainability

Joomla/Fabrik is convenient for non-developer administrators once configured.

Strapi is more maintainable for developer teams because schemas and frontend code are versioned directly.

## Recommendation

For the SRH Ambassador platform, Strapi is the better long-term technical fit because the platform benefits from API access, custom frontend UX, and future integrations. Joomla/Fabrik is a strong course comparison because it shows how quickly a traditional CMS can provide backend administration and public pages.
