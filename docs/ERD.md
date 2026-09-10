# ImpactHub Entity Relationship Design

This document describes the database structure before we create Laravel migrations.

## Relationship Map

The plain-text map below is intentionally included because it is visible even when Mermaid diagrams are not rendered:

```text
USERS
  |
  | one user owns many organisations
  v
ORGANISATIONS -------------- one organisation publishes many events
                                  |
                                  | each event belongs to one category
                                  v
                              EVENTS
                               /   \
                              /     \
             many events require   many registrations belong to an event
                            many skills          |
                              |                  |
                              v                  v
                         EVENT_SKILL         REGISTRATIONS
                              ^                  ^
                              |                  |
                          SKILLS          one user makes many registrations
                                                 |
                                                 v
                                               USERS

CATEGORIES
    |
    | one category classifies many events
    v
  EVENTS
```

## Mermaid ERD

GitHub and Mermaid-enabled Markdown previews render the diagram below visually.

```mermaid
erDiagram
    USERS ||--o{ ORGANISATIONS : owns
    USERS ||--o{ REGISTRATIONS : makes
    ORGANISATIONS ||--o{ EVENTS : publishes
    CATEGORIES ||--o{ EVENTS : classifies
    EVENTS ||--o{ REGISTRATIONS : receives
    EVENTS ||--o{ EVENT_SKILL : requires
    SKILLS ||--o{ EVENT_SKILL : describes

    USERS {
        bigint id PK
        string name
        string email UK
        string password
        string role
        timestamp created_at
        timestamp updated_at
    }

    ORGANISATIONS {
        bigint id PK
        bigint user_id FK
        string name
        text description
        string logo_path nullable
        timestamp created_at
        timestamp updated_at
    }

    EVENTS {
        bigint id PK
        bigint organisation_id FK
        bigint category_id FK
        string title
        text description
        string location
        timestamp starts_at
        unsigned_integer capacity
        string image_path nullable
        decimal latitude nullable
        decimal longitude nullable
        timestamp created_at
        timestamp updated_at
    }

    CATEGORIES {
        bigint id PK
        string name UK
        timestamp created_at
        timestamp updated_at
    }

    SKILLS {
        bigint id PK
        string name UK
        timestamp created_at
        timestamp updated_at
    }

    EVENT_SKILL {
        bigint event_id FK
        bigint skill_id FK
        timestamp created_at
    }

    REGISTRATIONS {
        bigint id PK
        bigint event_id FK
        bigint user_id FK
        string status
        timestamp registered_at
        timestamp created_at
        timestamp updated_at
    }
```

## Tables and Responsibilities

| Table | Responsibility | Important constraints |
|---|---|---|
| `users` | Authentication, role, and ownership identity | `email` is unique; `role` is controlled by the server |
| `organisations` | Community organisations that publish opportunities | `user_id` references the owning user |
| `events` | Main CRUD resource representing volunteer opportunities | Belongs to an organisation and category; capacity must be positive |
| `categories` | Classifies opportunities | Category name is unique |
| `skills` | Skills that volunteers may need | Skill name is unique |
| `event_skill` | Connects events and skills | `event_id` and `skill_id` are unique together |
| `registrations` | Records a volunteer joining an event | `event_id` and `user_id` are unique together |

## Eloquent Relationship Plan

| Model | Relationship | Laravel method |
|---|---|---|
| `User` | Has many organisations | `organisations()` with `hasMany()` |
| `User` | Has many registrations | `registrations()` with `hasMany()` |
| `Organisation` | Belongs to a user | `user()` with `belongsTo()` |
| `Organisation` | Has many events | `events()` with `hasMany()` |
| `Event` | Belongs to an organisation | `organisation()` with `belongsTo()` |
| `Event` | Belongs to a category | `category()` with `belongsTo()` |
| `Event` | Belongs to many skills | `skills()` with `belongsToMany()` |
| `Event` | Has many registrations | `registrations()` with `hasMany()` |
| `Category` | Has many events | `events()` with `hasMany()` |
| `Skill` | Belongs to many events | `events()` with `belongsToMany()` |
| `Registration` | Belongs to a user | `user()` with `belongsTo()` |
| `Registration` | Belongs to an event | `event()` with `belongsTo()` |

## Key Design Decisions

### Why use `event_skill`?

An event can require multiple skills, and one skill can apply to multiple events. A pivot table is the normal relational design for a many-to-many relationship. It also directly supports Feature 11 of the marking rubric.

### Why use `registrations` instead of a direct user-event link?

Registration is a real domain action. It can store status and registration time, prevent duplicate registrations, and support future cancellation or approval behaviour.

### Why is event ownership indirect?

An event belongs to an organisation, and an organisation belongs to a user. The server can therefore verify ownership through the chain:

```text
authenticated user -> owned organisation -> event
```

### Why are coordinates nullable?

An organiser may not provide coordinates. The event can still exist, while the weather integration displays a fallback message instead of calling the API with invalid data.

## Integrity Rules

1. A new user is created as a volunteer by default.
2. Users cannot assign themselves the administrator role through registration.
3. An event must belong to an existing organisation and category.
4. Event capacity must be greater than zero.
5. A volunteer can register only once for a given event.
6. Only the owning organiser can update or delete an event.
7. A weather request is made only when latitude and longitude are valid.