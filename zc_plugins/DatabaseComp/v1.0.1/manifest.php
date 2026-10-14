<?php

$plugin_folder = basename(dirname(__DIR__));
$version_folder = basename(__DIR__);

$plugin_readme = (defined('DIR_WS_CATALOG') ? DIR_WS_CATALOG : '/') . 'zc_plugins/' . $plugin_folder . '/' . $version_folder . '/readme.html';
$plugin_github = 'https://github.com/piloujp/Database-Structure-Compare-Tool';
$plugin_forum = 'https://www.zen-cart.com/threads/207405';

$button_readme = '<a class="btn btn-primary btn-sm" href="' . $plugin_readme . '" target="_blank"><i class="fa fa-book"></i> Readme</a>';
$button_github = '<a class="btn btn-info btn-sm" href="' . $plugin_github . '" target="_blank"><i class="fa-solid fa-code-branch"></i> GitHub</a>';
$button_forum  = '<a class="btn btn-success btn-sm" href="' . $plugin_forum . '" target="_blank"><i class="fa fa-comments"></i> Forum</a>';

$buttons = '<div class="buttons my-2">' . $button_readme . ' ' . $button_github . ' ' . $button_forum . '</div>';

return [
    'pluginVersion' => 'v1.0.1',
    'pluginName' => "Databases Structure Compare Tool",
    'pluginDescription' => 'This plugin allows you to compare the structures of different database versions in order to identify differences and determine what needs to be updated or corrected.<br> The database user must have access to the \'information_schema\' table.' . $buttons,
    'pluginAuthor' => 'piloujp',
    'pluginId' => 2448, // ID from Zen Cart forum
    'zcVersions' => ['v2.1.0','v2.2.0','v2.2.1','v2.2.2','v2.3.0','v3.0.0'],
    'changelog' => 'https://github.com/piloujp/Database-Structure-Compare-Tool/releases/tag/v1.0.1', // online URL (eg github release tag page, or changelog file there) or local filename only, ie: changelog.txt (in same dir as this manifest file)
    'github_repo' => 'https://github.com/piloujp/Database-Structure-Compare-Tool', // url
    'pluginGroups' => [],
];
