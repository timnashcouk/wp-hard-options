WP Hard Options
===============

Allows you to set options normally expected in the wp_options table as constants to avoid making calls to DB.

For full usage see - https://timnash.co.uk/wordpress-hard-coded-options/

=== Installation ===

Put in the MU plugins and activate

=== Usage ===

Define a PHP constant using the prefix WP_OPTIONS_XXX where xxx is the option name you want to retrieve (Note is in Capitalised, regardless of case) switches to lowercase.

=== Change Logs ===

0.7 (29/05/15) - Override caching either globally via constant, or per instance via filter, helper functions added to identify if options are hard coded. Fixed bug which caused early exit from get constants for loop due to careless refactoring.

0.5 (20/08/14) - Introducing caching, which maybe self defeating depending on circumstances. Additional filtering to aid using multiple prefixes.

0.4 (20/08/14) - small bug fixes to prevent warnings and improve performance, improved commenting (actually adding some!), some minor filtering improvements.

0.3 (04/08/14) - Initial GitHub commit
