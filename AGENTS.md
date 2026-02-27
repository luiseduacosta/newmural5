# AGENTS.md - Development Guide

CakePHP 5.x application (PHP 8.2+) - a university mural/internship management system.

## Build / Lint / Test Commands

```bash
# Run all tests
composer test
vendor/bin/phpunit

# Run single test file
vendor/bin/phpunit tests/TestCase/ApplicationTest.php

# Run specific test method
vendor/bin/phpunit --filter testBootstrap tests/TestCase/ApplicationTest.php

# Run tests with coverage
vendor/bin/phpunit --coverage-html webroot/coverage
```

### Code Style
```bash
composer run cs-check      # Check code style
composer run cs-fix        # Auto-fix issues
composer run check         # test + cs-check
```

### Static Analysis
```bash
vendor/bin/phpstan  # Level 8
vendor/bin/psalm    # Error level 2
```

## Code Style Guidelines

### General
- PHP 8.2+, strict types (`declare(strict_types=1);`)
- 4 spaces indentation, LF line endings
- Final newline in all files

### Naming Conventions
| Element | Convention | Example |
|---------|-----------|---------|
| Classes | PascalCase | `UsersController`, `UsersTable` |
| Methods/Properties | camelCase | `getUsers()`, `$this->user` |
| Constants | UPPER_SNAKE_CASE | `MAX_RETRY` |
| Tables/DB columns | snake_case | `users`, `created_at` |

### Import Order
1. PHP built-in
2. Composer packages
3. CakePHP framework
4. App classes (local)

### Type Hints
Always use native return types (PHP 8.0+). Controllers excluded from `ReturnTypeHint.MissingNativeTypeHint`.

### DocBlocks
Document all public methods with `@param` and `@return`.

### Error Handling
- `throw new NotFoundException()` for 404s
- `throw new ForbiddenException()` for 403s
- Use validation in Models/Tables, not Controllers

## CakePHP Conventions

### Entity
```php
protected array $_accessible = ['email' => true, 'password' => true];
protected array $_hidden = ['password'];

protected function _setPassword(string $password): ?string
{
    return (new DefaultPasswordHasher())->hash($password);
}
```

### Table
```php
public function initialize(array $config): void
{
    parent::initialize($config);
    $this->setTable('users');
    $this->setAlias('Users');
    $this->setDisplayField('email');
    $this->setPrimaryKey('id');
    $this->belongsTo('Alunos', ['foreignKey' => 'aluno_id']);
}
```

### Controller
- Load components in `initialize()` method
- Use `$this->request->getData()` for POST data
- Use `$this->request->getAttribute('identity')` for authenticated user
- Use `$this->Flash->success/error()` for flash messages

### Authentication & Authorization
- Uses `Authentication\AuthenticationService` and `Authorization\AuthorizationService`
- Define policies in `src/Policy/` directory

## Testing Guidelines

```php
use Cake\TestSuite\TestCase;
use Cake\TestSuite\IntegrationTestTrait;

class MyControllerTest extends TestCase
{
    use IntegrationTestTrait;

    public function testIndex(): void
    {
        $this->get('/my-controller/index');
        $this->assertResponseOk();
    }
}
```

- Uses SQLite: `sqlite://./testdb.sqlite`
- Set `DATABASE_TEST_URL` env var when running tests

## Project Structure
```
src/
  Controller/   # Controllers
  Model/        # Entities, Tables, Behaviors
  Policy/       # Authorization policies
  View/         # Templates, Cells, Helpers
  Service/      # Business logic services
config/         # App configuration
templates/      # View templates (*.ctp)
tests/          # Test files
```

## Common Tasks
```bash
bin/cake bake model Users
bin/cake bake controller Users
bin/cake bake template Users
bin/cake migrations migrate
bin/cake cache clear_all
```

## Configuration Reference
| File | Purpose |
|------|---------|
| `phpunit.xml.dist` | PHPUnit config |
| `phpcs.xml` | PHPCS rules |
| `phpstan.neon` | PHPStan level 8 |
| `psalm.xml` | Psalm error level 2 |
| `.editorconfig` | Editor formatting rules |

## Debugging Tips
- Check `logs/` directory for application logs
- Use `$this->log()` to write debug messages
- Enable debug mode in `config/app_local.php`: `'debug' => true`
- Use CakePHP's `debug()` and `pr()` functions for quick debugging
