# ImpactHub Role Matrix

ImpactHub has three authenticated roles. A guest is included below because public access is also part of the security design.

| Action | Guest | Volunteer | Organiser | Administrator |
|---|---:|---:|---:|---:|
| Browse opportunities | Yes | Yes | Yes | Yes |
| Search and filter opportunities | Yes | Yes | Yes | Yes |
| View opportunity details | Yes | Yes | Yes | Yes |
| Register for an opportunity | No | Yes | No | Optional |
| Cancel own registration | No | Yes | No | Optional |
| View own registrations | No | Yes | No | Optional |
| Create an organisation | No | No | Yes | Yes |
| Edit own organisation | No | No | Yes | Yes |
| Create an opportunity | No | No | Yes | Yes |
| View own opportunities | No | No | Yes | Yes |
| Edit own opportunity | No | No | Yes | Yes |
| Delete own opportunity | No | No | Yes | Yes |
| Edit another organiser's opportunity | No | No | No | Yes |
| Delete another organiser's opportunity | No | No | No | Yes |
| View registrations for own opportunities | No | No | Yes | Yes |
| Manage categories | No | No | No | Yes |
| Manage skills | No | No | No | Yes |
| Moderate organisations | No | No | No | Yes |
| Access administrator dashboard | No | No | No | Yes |

## Enforcement Plan

### Authentication middleware

The `auth` middleware blocks guests from routes that require a logged-in user. A guest should be redirected to the login page instead of seeing an authenticated page.

### Role middleware

Role middleware checks the authenticated user's role on the server. It must reject a volunteer who manually types an organiser or administrator URL.

Examples:

```text
/organiser/events/create -> organiser role required
/admin -> admin role required
```

### Ownership authorization

Role checking alone is not enough. Two organisers have the same role, so the application must also check whether the requested event belongs to the current organiser's organisation.

The ownership decision is:

```text
current user
    owns event.organisation
        therefore may edit or delete event
```

If the ownership check fails, the server must return an authorization failure even when the user manually changes the event ID in the URL.

## Registration Rules

1. Only volunteers may register through the normal registration workflow.
2. The event must exist.
3. The event must have available capacity.
4. The current volunteer must not already have a registration for that event.
5. The server, not only the interface, enforces all four rules.

## Viva Security Demonstrations

We should be prepared to demonstrate these cases during the viva:

1. A guest attempts to open an organiser page and is redirected to login.
2. A volunteer attempts to open the administrator dashboard and is rejected.
3. Organiser A attempts to edit an event owned by Organiser B and is rejected.
4. A volunteer submits invalid registration data and the server rejects it.
5. A volunteer attempts to register twice and the server prevents a duplicate record.