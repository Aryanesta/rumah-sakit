# Agent Rules Index

This index organizes all project guidelines into **functional category folders** under `.ai/rules/`.
When an agent creates or modifies files matching a glob, it MUST consult the corresponding rule file.

## Database & Eloquent

| Target File Glob | Rule Document | Description |
| :--- | :--- | :--- |
| `app/Models/**` | [models.md](./database/models.md) | Eloquent Models & Relationships |
| `database/migrations/**` | [migrations.md](./database/migrations.md) | Database Migrations & Schema |
| `database/factories/**` | [factories.md](./database/factories.md) | Model Factories & State |
| `database/seeders/**` | [seeders.md](./database/seeders.md) | Database Seeders |
| `app/Casts/**` | [casts.md](./database/casts.md) | Custom Attribute Casts |
| `app/Observers/**` | [observers.md](./database/observers.md) | Model Observers & Events |
| `database/**` | [database.md](./database/database.md) | Database General Guidelines |

## HTTP & Routing

| Target File Glob | Rule Document | Description |
| :--- | :--- | :--- |
| `app/Http/Controllers/**` | [controllers.md](./http/controllers.md) | Controllers & Action Methods |
| `app/Http/Requests/**` | [requests.md](./http/requests.md) | Form Request Validation & Authorization |
| `app/Http/Resources/**` | [resources.md](./http/resources.md) | API Resources & JSON Formatting |
| `app/Http/Middleware/**` | [middleware.md](./http/middleware.md) | HTTP Middleware |
| `routes/**` | [routes.md](./http/routes.md) | Routing, Rate Limiting & Named Routes |

## Domain & Business Logic

| Target File Glob | Rule Document | Description |
| :--- | :--- | :--- |
| `app/Actions/**` | [actions.md](./domain/actions.md) | Single-Purpose Action Classes |
| `app/Services/**` | [services.md](./domain/services.md) | Domain & Integration Services |
| `app/Enums/**` | [enums.md](./domain/enums.md) | PHP 8.1+ Enums |
| `app/Contracts/**` | [contracts.md](./domain/contracts.md) | Interfaces & Contracts |
| `app/Concerns/**` | [concerns.md](./domain/concerns.md) | Shared Traits & Concerns |
| `app/Support/**` | [support.md](./domain/support.md) | Support Utilities & Helpers |
| `app/States/**` | [states.md](./domain/states.md) | State Machine & Transitions |
| `app/Data/**` | [data.md](./domain/data.md) | Data Transfer Objects (DTOs) |
| `app/Policies/**` | [policies.md](./domain/policies.md) | Authorization Policies & Gates |
| `app/Rules/**` | [rules.md](./domain/rules.md) | Custom Validation Rules |

## Asynchronous & Messaging

| Target File Glob | Rule Document | Description |
| :--- | :--- | :--- |
| `app/Jobs/**` | [jobs.md](./async/jobs.md) | Queue Jobs & Background Processing |
| `app/Events/**` | [events.md](./async/events.md) | Application Domain Events |
| `app/Listeners/**` | [listeners.md](./async/listeners.md) | Queued & Synchronous Listeners |
| `app/Notifications/**` | [notifications.md](./async/notifications.md) | Channel Notifications (Mail/SMS/Database) |
| `app/Mail/**` | [mail.md](./async/mail.md) | Mailable Classes & Views |
| `app/Broadcasting/**` | [broadcasting.md](./async/broadcasting.md) | WebSockets & Event Broadcasting |

## Frontend & Presentation

| Target File Glob | Rule Document | Description |
| :--- | :--- | :--- |
| `resources/views/**` | [views.md](./frontend/views.md) | Blade Templates & Alpine.js Interactions |
| `resources/views/components/**` | [components.md](./frontend/components.md) | Anonymous Blade Components |
| `app/View/Components/**` | [php_components.md](./frontend/php_components.md) | Class-based View Components |
| `lang/**` | [localization.md](./frontend/localization.md) | Translation Files & Strings |

## Testing & Quality Assurance

| Target File Glob | Rule Document | Description |
| :--- | :--- | :--- |
| `tests/**` | [testing.md](./testing/testing.md) | Test Suite Architecture & PHPUnit Base |
| `tests/Feature/**` | [feature.md](./testing/feature.md) | Feature & HTTP Integration Tests |
| `tests/Unit/**` | [unit.md](./testing/unit.md) | Isolated Unit Tests |
| `tests/Architecture/**` | [architecture.md](./testing/architecture.md) | Architecture & Design Tests |

## Core Framework & Infrastructure

| Target File Glob | Rule Document | Description |
| :--- | :--- | :--- |
| `app/**` | [app.md](./core/app.md) | Core Application Layer Guidelines |
| `config/**` | [config.md](./core/config.md) | Configuration Values & Files |
| `app/Providers/**` | [providers.md](./core/providers.md) | Service Providers & Bootstrapping |
| `app/Console/Commands/**` | [console.md](./core/console.md) | Artisan CLI Commands |
| `app/Exceptions/**` | [exceptions.md](./core/exceptions.md) | Exception Handling & Reporting |
| `app/Features/**` | [features.md](./core/features.md) | Pennant Feature Flags |

