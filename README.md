# HSTemplate

HSTemplate is a web template system written in PHP for old PHP. HSTemplate separates PHP, as a business logic, from HTML, a presentation logic.


This package implements a template engine with output caching support.

It can assign templates files a name so they can be referenced by that name.

The class loads from a given directory template files which are actual HTML files with embedded PHP code.

It can assign to each template, variables which are stored as class variables.

The templates are processed by turning template variables into local variables and then include the template file scripts.

The results of processed templates can be cached to avoid subsequent template processing overhead.
