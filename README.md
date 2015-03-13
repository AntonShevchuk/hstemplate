# HSTemplate

HSTemplate is a template engine written in PHP. HSTemplate separates PHP, as a business logic, from HTML, a presentation logic.

High Speed Template work with PHP4/5 - it's really very fast template because it's not a "template engine language" wrote on PHP - it's only PHP!

This package implements a template engine with output caching support.

It can assign templates files a name so they can be referenced by that name.

The class loads from a given directory template files which are actual HTML files with embedded PHP code.

It can assign to each template, variables which are stored as class variables.

The templates are processed by turning template variables into local variables and then include the template file scripts.

The results of processed templates can be cached to avoid subsequent template processing overhead.


> I read small article (http://spectator.ru/technology/php/easy_templates) and create this is 'template engine' in 2007 year


# Learn HSTemplate in 10 Minutes (Small tutorial)

## Include the HSTemplate class library
```php
require_once('HSTemplate/HSTemplate.class.php');
```

## Instantiate the HSTemplate object
For options `template_path` and `cache_path` use full path to directory
```php
/* HSTemplate initialization */
$options = array(
                'template_path' => 'templates',
                'cache_path'    => 'cache',
                'debug'         => false,
                );
                
$HSTemplate =& new HSTemplate($options);
```

## Instantiate the HSTemplateDisplay object
```php
// index page
$DisplayIndex = & $HSTemplate->getDisplay('index');
```

## Add Templates
Directory structure:
```
`- templates (directory set as `template_path`)
   `- index  (by display name)
      |- header.html
      |- index.html
      `- footer.html
```

Example:
```php
// add templates
$DisplayIndex->addTemplate('header', 'header.html');
$DisplayIndex->addTemplate('index' , 'index.html' );
$DisplayIndex->addTemplate('footer', 'footer.html');
```

## Assign Variables
You can assign variable to 'Global section' or to 'Display section' or to 'Template section', priority:
1. Global section
2. Display section
3. Template section

Example:
```php
// assign template variables
$DisplayIndex->assign('template',     'DISPLAY',   'index');
// assign display variables
$DisplayIndex->assign('display',     'DISPLAY');
// assign global variables (for all display)
$HSTemplate->assignGlobal('global',  'GLOBAL');
```

## Templates
```php
<h2>Test 1</h2>
Global   Variable: <?=$global?><br/>
Display  Variable: <?=$display?><br/>
Template Variable: <?=$template?><br/>
```

## Use Cache

Call method setCache for enable cache for curent `Display`
* first argument is unique ID for cache (you can use `$_SERVER['REQUEST_URI']`)
* second - it's cache lifetime - default value 3600 seconds (1hour)
```php
$DisplayContent->setCache('test1', 3600);
if (!$DisplayContent->isCached()) {
   $DisplayContent->addTemplate('test1', 'test1.html');
   $DisplayContent->assign('time',     date('H:i:s'), 'test1');
}
```

## Display
```php
// display all non separated 'display'
$HSTemplate->display();
```
