# Status Messages

A general status message module for the frontend.

## Usage

### Install

1. Install with composer or contao manager

    ```composer require heimrichhannot/contao-status_messages```
    
1. Update database

### In a module

Simply add the following to your template:

```php
<?php echo \HeimrichHannot\StatusMessages\StatusMessage::generate($this->id); ?>
```

To add new Messages use the appropriate function in StatusMessage:

```php
StatusMessage::addError('An error has happened', $this->id);
```

### By using the global frontend module ModuleStatusMessages

Simply add the module to your page. The contained javascript gets all messages thrown in your modules and adds
it to the global markup element. It's necessary to use javascript here since else you get problems with order and redirects.