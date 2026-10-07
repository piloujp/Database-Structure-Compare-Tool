<?php
return [
    'pluginVersion' => 'v1.0.0',
    'pluginName' => "Databases Structure Compare Tool",
    'pluginDescription' => 'This plugin allows you to compare the structures of different database versions in order to identify differences and determine what needs to be updated or corrected.<br> The database user must have access to the \'information_schema\' table.',
    'pluginAuthor' => 'piloujp',
    'pluginId' => 2448, // ID from Zen Cart forum
    'zcVersions' => ['v2.1.0','v2.2.0','v2.2.1','v2.2.2','v2.3.0','v3.0.0'],
    'changelog' => 'https://github.com/piloujp/Database-Structure-Compare-Tool/releases/tag/v1.0.1', // online URL (eg github release tag page, or changelog file there) or local filename only, ie: changelog.txt (in same dir as this manifest file)
    'github_repo' => 'https://github.com/piloujp/Database-Structure-Compare-Tool', // url
    'pluginGroups' => [],
];
