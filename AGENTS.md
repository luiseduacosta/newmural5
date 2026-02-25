# AGENTS.md - Development Guide

## Project Overview

CakePHP 5.x application (PHP 8.2+) - a university mural/internship management system.

## Build / Lint / Test Commands

### Testing
```bash
# Run all tests
composer test
vendor/bin/phpunit

# Run single test file
vendor/bin/phpunit tests/TestCase/ApplicationTest.php

# Run specific test method
vendor/bin/phpunit --filter testBootstrap tests/TestCase/ApplicationTest.php
```

### Code Style (PHPCS)
```bash
# Check code style
composer run cs-check
vendor/bin/phpcs --colors -p

# Auto-fix issues
composer run cs-fix
vendor/bin/phpcbf --colors -p
```

### Static Analysis
```bash
vendor/bin/phpstan     # Level 8
vendor/bin/psalm      # Error level 2
```

### Combined Check
```bash
composer run check  # test + cs-check
```

---

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
Always use native return types (PHP 8.0+):
```php
public function initialize(array $config): void
public function getUser(): ?User
```
Note: Controllers excluded from `ReturnTypeHint.MissingNativeTypeHint` in phpcs.xml.

### DocBlocks
Document all methods with `@param` and `@return`:
```php
/**
 * Get user by ID.
 *
 * @param int $id User ID
 * @return \App\Model\Entity\User|null
 */
public function getUser(int $id): ?User
```

### Error Handling
- `throw new NotFoundException()` for 404s
- `throw new ForbiddenException()` for 403s
- Use validation in Models/Tables, not Controllers

### Entity Conventions
```php
protected array $_accessible = [
    'email' => true,
    'password' => true,
];

protected array $_hidden = ['password'];

protected function _setPassword(string $password): ?string
{
    return (new DefaultPasswordHasher())->hash($password);
}
```

### Table Conventions
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

### Controller Conventions
- Load components in `initialize()` method
- Use `$this->request->getData()` for POST data
- Use `$this->request->getAttribute('identity')` for authenticated user

### Authentication & Authorization
- Uses `Authentication\AuthenticationService` and `Authorization\AuthorizationService`
- Define policies in `src/Policy/` directory

---

## Testing Guidelines

### Test Structure
```php
<?php
declare(strict_types=1);

namespace App\Test\TestCase;

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

### Database for Tests
- Uses SQLite: `sqlite://./testdb.sqlite`
- Set `DATABASE_TEST_URL` env var when running tests

---

## Configuration Reference

| File | Purpose |
|------|---------|
| `phpunit.xml.dist` | PHPUnit config |
| `phpcs.xml` | PHPCS rules (CakePHP standard) |
| `phpstan.neon` | PHPStan level 8 |
| `psalm.xml` | Psalm error level 2 |
| `.editorconfig` | Editor formatting rules |

---

## Common Tasks
```bash
# Bake new table/model/controller
bin/cake bake model Users
bin/cake bake controller Users
bin/cake bake template Users

# Run migrations
bin/cake migrations migrate

# Clear caches
bin/cake cache clear_all
```
