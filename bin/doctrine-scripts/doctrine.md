# Doctrine Command Line Interface 2.13.1.0

## Usage:

```
command [options] [arguments]
```

## Options:

<pre>
-h, --help            Display help for the given command. When no command is given display help for the list command
-q, --quiet           Do not output any message
-V, --version         Display this application version
--ansi|--no-ansi      Force (or disable --no-ansi) ANSI output
-n, --no-interaction  Do not ask any interactive question
-v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug
</pre>

## Available commands:

<pre>
completion                         Dump the shell completion script
help                               Display help for a command
list                               List commands
</pre>

### dbal

<pre>
dbal:reserved-words                Checks if the current database contains identifiers that are reserved.
dbal:run-sql                       Executes arbitrary SQL directly from the command line.
</pre>

### orm

<pre>
orm:clear-cache:metadata           Clear all metadata cache of the various cache drivers
orm:clear-cache:query              Clear all query cache of the various cache drivers
orm:clear-cache:region:collection  Clear a second-level cache collection region
orm:clear-cache:region:entity      Clear a second-level cache entity region
orm:clear-cache:region:query       Clear a second-level cache query region
orm:clear-cache:result             Clear all result cache of the various cache drivers
orm:convert-d1-schema              [orm:convert:d1-schema] Converts Doctrine 1.x schema into a Doctrine 2.x schema
orm:convert-mapping                [orm:convert:mapping] Convert mapping information between supported formats
orm:ensure-production-settings     Verify that Doctrine is properly configured for a production environment
orm:generate-entities              [orm:generate:entities] Generate entity classes and method stubs from your mapping 
                                    information
orm:generate-proxies               [orm:generate:proxies] Generates proxy classes for entity classes
orm:generate-repositories          [orm:generate:repositories] Generate repository classes from your mapping information
orm:info                           Show basic information about all mapped entities
orm:mapping:describe               Display information about mapped objects
orm:run-dql                        Executes arbitrary DQL directly from the command line
orm:schema-tool:create             Processes the schema and either create it directly on EntityManager Storage 
                                    Connection or generate the SQL output
orm:schema-tool:drop               Drop the complete database schema of EntityManager Storage Connection or generate the
                                    corresponding SQL output
orm:schema-tool:update             Executes (or dumps) the SQL needed to update the database schema to match the current
                                    mapping metadata
orm:validate-schema                Validate the mapping files
</pre>
