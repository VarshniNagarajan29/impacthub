# ImpactHub Project Blueprint

## Purpose

ImpactHub helps community organisations publish volunteer opportunities and helps people discover, register for, and manage volunteering activities.

## Target Users

### Volunteer

- Browse volunteer opportunities
- Search and filter opportunities
- View opportunity details
- Register for an opportunity
- Cancel their own registration
- View their registrations

### Organiser

- Create and manage an organisation
- Create volunteer opportunities
- Upload opportunity images
- Select required skills
- Edit and delete their own opportunities
- View registrations for their opportunities

### Administrator

- Access the protected administration area
- Manage categories and skills
- Moderate organisations and opportunities
- Perform actions unavailable to volunteers and organisers

## Main User Journey

1. An organiser creates a volunteer opportunity.
2. The organiser selects a category and required skills.
3. The organiser uploads an opportunity image.
4. A volunteer searches and filters available opportunities.
5. The volunteer views the opportunity details.
6. The volunteer registers for the opportunity.
7. The organiser views the registrations.
8. An administrator manages protected moderation actions.

## Main Resource

The main CRUD resource is `Event`.

In the application, an event represents a volunteer opportunity.

## Initial Database Tables

- `users`
- `organisations`
- `events`
- `categories`
- `skills`
- `event_skill`
- `registrations`

## Rubric Feature Targets

- Core 1: Authentication
- Core 2: Three or more related Eloquent tables
- Core 3: Full CRUD for events
- Core 4: Server-side validation
- Core 5: Ownership authorization
- Feature 6: Image upload
- Feature 7: Search and pagination
- Feature 8: Coherent and usable application
- Feature 9: Fourth related table
- Feature 10: Fifth related table
- Feature 11: Many-to-many skills pivot
- Feature 12: Roles and middleware
- Feature 14: Automated feature tests
- Feature 15: Third-party weather API

Feature 13, asynchronous UI, is deferred until the assessed application is stable.

## Initial Laravel Learning Map

| Django concept | Laravel concept |
|---|---|
| Models and QuerySets | Eloquent models and relationships |
| URL patterns | Routes |
| Views | Controllers and Blade views |
| Forms and validation | Form Requests and validation rules |
| Decorators and permissions | Middleware and policies |
| Migrations and fixtures | Migrations, factories, and seeders |
| Django tests | Laravel feature tests |