# ImpactHub Route Map

This is the planned HTTP interface. The route names and controller names may be refined during implementation, but every route must remain connected to the application purpose.

## Public Routes

| Method | URI | Name | Purpose |
|---|---|---|---|
| GET | `/` | `home` | Show the ImpactHub landing page and featured opportunities |
| GET | `/events` | `events.index` | Browse, search, filter, and paginate opportunities |
| GET | `/events/{event}` | `events.show` | View one opportunity and its weather information |

## Authentication Routes

| Method | URI | Name | Middleware | Purpose |
|---|---|---|---|---|
| GET | `/register` | `register` | guest | Show registration form |
| POST | `/register` | `register.store` | guest | Create a volunteer account |
| GET | `/login` | `login` | guest | Show login form |
| POST | `/login` | `login.store` | guest | Authenticate a user |
| POST | `/logout` | `logout` | auth | End the authenticated session |

## Authenticated Volunteer Routes

| Method | URI | Name | Middleware | Purpose |
|---|---|---|---|---|
| POST | `/events/{event}/registrations` | `events.registrations.store` | auth, role:volunteer | Register for an opportunity |
| DELETE | `/events/{event}/registrations` | `events.registrations.destroy` | auth, role:volunteer | Cancel the current user's registration |
| GET | `/my-registrations` | `registrations.index` | auth, role:volunteer | View the current user's registrations |

## Organiser Routes

| Method | URI | Name | Middleware | Purpose |
|---|---|---|---|---|
| GET | `/organiser/events` | `organiser.events.index` | auth, role:organiser | List the organiser's own opportunities |
| GET | `/organiser/events/create` | `organiser.events.create` | auth, role:organiser | Show the creation form |
| POST | `/organiser/events` | `organiser.events.store` | auth, role:organiser | Create an opportunity |
| GET | `/organiser/events/{event}/edit` | `organiser.events.edit` | auth, role:organiser, ownership | Show the edit form |
| PUT/PATCH | `/organiser/events/{event}` | `organiser.events.update` | auth, role:organiser, ownership | Update an opportunity |
| DELETE | `/organiser/events/{event}` | `organiser.events.destroy` | auth, role:organiser, ownership | Delete an opportunity |
| GET | `/organiser/events/{event}/registrations` | `organiser.events.registrations` | auth, role:organiser, ownership | View registrations for an owned opportunity |

## Administrator Routes

| Method | URI | Name | Middleware | Purpose |
|---|---|---|---|---|
| GET | `/admin` | `admin.dashboard` | auth, role:admin | Show the protected administration dashboard |
| CRUD | `/admin/categories` | `admin.categories.*` | auth, role:admin | Manage opportunity categories |
| CRUD | `/admin/skills` | `admin.skills.*` | auth, role:admin | Manage skills |
| CRUD | `/admin/organisations` | `admin.organisations.*` | auth, role:admin | Moderate organisations |
| CRUD | `/admin/events` | `admin.events.*` | auth, role:admin | Moderate opportunities |

## Route Security Rules

1. Public browsing routes do not expose private organiser or volunteer information.
2. Registration and organiser actions require authentication.
3. Role middleware blocks users who do not have the required role.
4. Ownership authorization is checked on the server for event edit, update, delete, and organiser registration views.
5. Forms that change data use `POST`, `PUT`, `PATCH`, or `DELETE`, not `GET`.
6. Laravel CSRF protection applies to state-changing web forms.
7. Route model binding must not replace ownership checks.

## Planned Controller Boundaries

| Controller | Responsibility |
|---|---|
| `EventController` | Public event list and details |
| `OrganiserEventController` | Organiser-owned event CRUD |
| `RegistrationController` | Volunteer registration and cancellation |
| `OrganiserRegistrationController` | Registrations for an organiser's events |
| `AdminCategoryController` | Administrator category management |
| `AdminSkillController` | Administrator skill management |
| `AdminOrganisationController` | Administrator organisation moderation |
| `WeatherController` or `WeatherService` | Retrieve and prepare third-party weather data |