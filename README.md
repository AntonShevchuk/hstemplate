# HSTemplate

HSTemplate is a web template system written in PHP. HSTemplate separates PHP, as a business logic, from HTML, a presentation logic.

High Speed Template work with PHP4/5 - it's really very fast template because it's not a "template engine language" wrote on PHP - it's only PHP!

This package implements a template engine with output caching support.

It can assign templates files a name so they can be referenced by that name.

The class loads from a given directory template files which are actual HTML files with embedded PHP code.

It can assign to each template, variables which are stored as class variables.

The templates are processed by turning template variables into local variables and then include the template file scripts.

The results of processed templates can be cached to avoid subsequent template processing overhead.


> I read small article (http://spectator.ru/technology/php/easy_templates) and create this is 'template engine' in 2007 year
