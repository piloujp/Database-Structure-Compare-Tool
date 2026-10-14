<?php
/**
 * @copyright Copyright 2003-2026 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: piloujp 2026 Aug 20 Modified in v3.0.0-Dev $
*/

$define = [
    'ADMIN_PLUGIN_MANAGER_NAME_FOR_DATABASECOMP' => 'Outil de comparaison de structures de bases de données',
    'ADMIN_PLUGIN_MANAGER_DESCRIPTION_FOR_DATABASECOMP' => 'Ce plugin vous permet de comparer les structures de différentes versions de bases de données afin d’identifier les différences et de déterminer ce qui doit être mis à jour ou corrigé.<br> L’utilisateur de la base de données doit avoir accès à la table « information_schema ».' .
    '<div class="buttons my-2">' .
    '<a class="btn btn-primary btn-sm" href="' . DIR_WS_CATALOG . 'zc_plugins/DatabaseComp/' . basename(dirname(__DIR__, 5)) . '/readme.html " target="_blank"><i class="fa fa-book"></i> Lisez-moi</a> ' .
    '<a class="btn btn-info btn-sm" href="https://github.com/piloujp/Database-Structure-Compare-Tool" target="_blank"><i class="fa-solid fa-code-branch"></i> GitHub</a> ' .
    '<a class="btn btn-success btn-sm" href="https://www.zen-cart.com/threads/207405" target="_blank"><i class="fa fa-comments"></i> Forum</a>' .
    '</div>',
];

return $define;
