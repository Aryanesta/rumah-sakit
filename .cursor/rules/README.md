# Cursor Rules Index

Project conventions live in **`.cursor/rules/*.mdc`**. Cursor auto-attaches rules when you edit files matching each rule's `globs`. Cross-cutting app rules use intelligent apply (no `app/**` glob) to avoid context bloat.

When adding a convention, edit or create the matching `.mdc` and add a row here.

## Database & Eloquent

| Target File Glob | Rule File | Description |
| :--- | :--- | :--- |
| `app/Models/**` | `database-models-core.mdc`, `database-models-relationships.mdc` | Eloquent Models & Relationships |
| `database/migrations/**` | `database-migrations.mdc` | Database Migrations & Schema |
| `database/factories/**` | `database-factories.mdc` | Model Factories & State |
| `database/seeders/**` | `database-seeders.mdc` | Database Seeders |
| `app/Casts/**` | `database-casts.mdc` | Custom Attribute Casts |
| `app/Observers/**` | `database-observers.mdc` | Model Observers & Events |
| `database/**` | `database-database.mdc` | Database General Guidelines |

## HTTP & Routing

| Target File Glob | Rule File | Description |
| :--- | :--- | :--- |
| `app/Http/Controllers/**` | `http-controllers.mdc` | Controllers & Action Methods |
| `app/Http/Requests/**` | `http-requests.mdc` | Form Request Validation & Authorization |
| `app/Http/Resources/**` | `http-resources.mdc` | API Resources & JSON Formatting |
| `app/Http/Middleware/**` | `http-middleware.mdc` | HTTP Middleware |
| `routes/**` | `http-routes.mdc` | Routing, Rate Limiting & Named Routes |

## Domain & Business Logic

| Target File Glob | Rule File | Description |
| :--- | :--- | :--- |
| `app/Actions/**` | `domain-actions.mdc` | Single-Purpose Action Classes |
| `app/Services/**` | `domain-services.mdc` | Domain & Integration Services |
| `app/Enums/**` | `domain-enums.mdc` | PHP 8.1+ Enums |
| `app/Contracts/**` | `domain-contracts.mdc` | Interfaces & Contracts |
| `app/Concerns/**` | `domain-concerns.mdc` | Shared Traits & Concerns |
| `app/Support/**` | `domain-support.mdc` | Support Utilities & Helpers |
| `app/States/**` | `domain-states.mdc` | State Machine & Transitions |
| `app/Data/**` | `domain-data.mdc` | Data Transfer Objects (DTOs) |
| `app/Policies/**` | `domain-policies.mdc` | Authorization Policies & Gates |
| `app/Rules/**` | `domain-validation-rules.mdc` | Custom Validation Rules |

## Asynchronous & Messaging

| Target File Glob | Rule File | Description |
| :--- | :--- | :--- |
| `app/Jobs/**` | `async-jobs.mdc` | Queue Jobs & Background Processing |
| `app/Events/**` | `async-events.mdc` | Application Domain Events |
| `app/Listeners/**` | `async-listeners.mdc` | Queued & Synchronous Listeners |
| `app/Notifications/**` | `async-notifications.mdc` | Channel Notifications |
| `app/Mail/**` | `async-mail.mdc` | Mailable Classes & Views |
| `app/Broadcasting/**` | `async-broadcasting.mdc` | WebSockets & Event Broadcasting |

## Frontend & Presentation

| Target File Glob | Rule File | Description |
| :--- | :--- | :--- |
| `resources/views/**` | `frontend-views.mdc` | Blade Templates & Alpine.js |
| `resources/views/components/**` | `frontend-blade-components.mdc` | Anonymous Blade Components |
| `app/View/Components/**` | `frontend-php-components.mdc` | Class-based View Components |
| `lang/**` | `frontend-localization.mdc` | Translation Files & Strings |

## Testing

| Target File Glob | Rule File | Description |
| :--- | :--- | :--- |
| `tests/**` | `testing-foundation.mdc`, `testing-pest-patterns.mdc` | Test suite architecture |
| `tests/Feature/**` | `testing-feature.mdc` | Feature & HTTP Integration Tests |
| `tests/Unit/**` | `testing-unit.mdc` | Isolated Unit Tests |
| `tests/Architecture/**` | `testing-architecture.mdc` | Architecture & Design Tests |

## Core & Cross-cutting

| Target File Glob | Rule File | Description |
| :--- | :--- | :--- |
| (intelligent) | `app-logic-placement.mdc` | Action vs Job vs Event vs Service |
| (intelligent) | `app-domain-namespaces.mdc` | Domain subfolders under `app/` |
| (intelligent) | `app-naming-security.mdc` | Naming, DI, security, style |
| `config/**` | `core-config.mdc` | Configuration Values & Files |
| `app/Providers/**` | `core-providers.mdc` | Service Providers |
| `app/Console/Commands/**` | `core-console.mdc` | Artisan CLI Commands |
| `app/Exceptions/**` | `core-exceptions.mdc` | Exception Handling |
| `app/Features/**` | `core-features.mdc` | Pennant Feature Flags |
| `app/Livewire/**`, `resources/views/livewire/**` | `reference-livewire.mdc` | Livewire 4 (when used) |

Always-on: `00-project-bootstrap.mdc` · Manual map: `rules-index.mdc` (`@rules-index`)
