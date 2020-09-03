## API Services
_Please note: this project is still in development state and may not work properly. I'm planning
to finish this, add more docs and PHPUnit tests_  
  
Additional services for Logopony.com API  
### Visit card module
A visit card module is intended for generating visit cards by replacing 
placeholders in existing templates.  
A module listens for HTTP POST requests with JSON body where user passes input values that should
take place instead of placeholders.  
Module should be configured via `config.php` file, where user
can define template sources (specific file or directory), define type of template and define placeholders
inside every template.  
`placeholders` is an array, where the key is user request key from JSON body, and value is
placeholder config, where user can define `id` for placeholder in document, and specific `type` which
may be handled differently _todo docs_ 
