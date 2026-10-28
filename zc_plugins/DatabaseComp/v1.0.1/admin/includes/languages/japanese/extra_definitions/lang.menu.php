<?php
/**
 * @copyright Copyright 2003-2026 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: piloujp 2026 Oct 28 Modified in v3.0.0-Dev $
*/

$define = [
    'ADMIN_PLUGIN_MANAGER_NAME_FOR_DATABASECOMP' => 'データベース構造比較ツール',
    'ADMIN_PLUGIN_MANAGER_DESCRIPTION_FOR_DATABASECOMP' => 'このプラグインを使用すると、異なるデータベースバージョンの構造を比較して、差異を特定し、更新や修正が必要な箇所を判断できます。<br> データベースユーザーには、「information_schema」テーブルへのアクセス権限が必要です。' .
    '<div class="buttons my-2">' .
    '<a class="btn btn-primary btn-sm" href="' . DIR_WS_CATALOG . 'zc_plugins/DatabaseComp/' . basename(dirname(__DIR__, 5)) . '/readme.html " target="_blank"><i class="fa fa-book"></i> はじめにお読みください</a> ' .
    '<a class="btn btn-info btn-sm" href="https://github.com/piloujp/Database-Structure-Compare-Tool" target="_blank"><i class="fa-solid fa-code-branch"></i> GitHub</a> ' .
    '<a class="btn btn-success btn-sm" href="https://www.zen-cart.com/threads/207405" target="_blank"><i class="fa fa-comments"></i> フォーラム</a>' .
    '</div>',
];

return $define;
