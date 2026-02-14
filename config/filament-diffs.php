<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default File Name
    |--------------------------------------------------------------------------
    |
    | The default file name used when rendering diffs. This affects syntax
    | highlighting detection when no explicit language is set.
    |
    */

    'default_file_name' => null,

    /*
    |--------------------------------------------------------------------------
    | Default Language
    |--------------------------------------------------------------------------
    |
    | The default syntax highlighting language for diffs. When set, this
    | will be used unless overridden per-component. Uses Shiki language
    | identifiers (e.g., 'php', 'javascript', 'markdown', 'json').
    |
    */

    'default_language' => null,

    /*
    |--------------------------------------------------------------------------
    | Default Options
    |--------------------------------------------------------------------------
    |
    | Default options passed to the @pierre/diffs FileDiff component.
    | These are merged with any per-component options, with per-component
    | values taking precedence.
    |
    | See https://diffs.com/docs for available options.
    |
    */

    'default_options' => [],

];
