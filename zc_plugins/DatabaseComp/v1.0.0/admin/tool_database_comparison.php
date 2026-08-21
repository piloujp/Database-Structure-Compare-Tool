<?php
/**
 * @copyright Copyright 2003-2026 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Piloujp 2026 Aug 21 New in v3.0.0-dev $
 */

require 'includes/application_top.php';

global $db;

$Databases_Query = "SELECT schema_name FROM information_schema.schemata ORDER BY schema_name;";
$result_databases = $db->Execute($Databases_Query);

$excluded_databases = ['information_schema', 'performance_schema', 'mysql'];
$database_list[] = ['id' => '', 'text' => TEXT_SELECT_AN_OPTION];
foreach ($result_databases as $database) {
    if (!in_array($database["SCHEMA_NAME"], $excluded_databases, true)) {
        $database_list[] = ['id' => $database["SCHEMA_NAME"], 'text' => $database["SCHEMA_NAME"]];
    }
}
//array_walk($database_list, function(&$item, $key) {$item['id'] = $key + 1;});
//var_dump($database_list);

$firstDatabase = DB_DATABASE;
$secondDatabase = (isset($_GET['database']) ? substr(zen_db_prepare_input($_GET['database']), 0) : '');
$sortOrder = ($secondDatabase > $firstDatabase) ? 'ASC' : 'DESC' ;
$tablesDb1 = [];
$tablesDb2 = [];

if (!empty($firstDatabase) && !empty($secondDatabase)) {
    $sql_tables_db1 = "SELECT DISTINCT table_name FROM information_schema.columns WHERE table_schema = :firstDatabase ORDER BY table_name;";
    $sql_tables_db1 = $db->bindVars($sql_tables_db1, ':firstDatabase', $firstDatabase, 'string');
    $result_tables_db1 = $db->Execute($sql_tables_db1);
    if (!$result_tables_db1->EOF) {
        foreach ($result_tables_db1 as $tables1) {
            $tablesDb1[] = $tables1['TABLE_NAME'];
        }
    }
    $sql_tables_db2 = "SELECT DISTINCT table_name FROM information_schema.columns WHERE table_schema = :secondDatabase ORDER BY table_name;";
    $sql_tables_db2 = $db->bindVars($sql_tables_db2, ':secondDatabase', $secondDatabase, 'string');
    $result_tables_db2 = $db->Execute($sql_tables_db2);
    if (!$result_tables_db2->EOF) {
        foreach ($result_tables_db2 as $tables2) {
            $tablesDb2[] = $tables2['TABLE_NAME'];
        }
    }

    $commonTables = array_intersect($tablesDb1, $tablesDb2);
    $diffTable[$firstDatabase] = array_diff($tablesDb1, $tablesDb2);
    $diffTable[$secondDatabase] = array_diff($tablesDb2, $tablesDb1);
}
//var_dump($commonTables);
//echo "\n";
//var_dump($diffTable);
//echo "\n";
/*
foreach ($diffTable as $dbName => $tableNames) {
    foreach ($tableNames as $tableName) {
        echo $dbName . ' --> ' . $tableName . "\n";
    }
}
*/


?>
<!doctype html>
<html <?= HTML_PARAMS ?>>
<head>
    <meta charset="<?= CHARSET ?>">
    <title><?= HEADING_TITLE ?></title>
    <?php require DIR_WS_INCLUDES . 'admin_html_head.php'; ?>
    <style>
        .standard-row {
            font-size: 1em;
            padding: 12px;
            box-sizing: border-box;
        }
        .container-fluid {
            display: grid;
            align-items: center;
        }
        .val-dif {
            color: #ff0000;
        }
        .diff-row-value {
            background-color: #d9edf7;
        }
        .left-only {
            background-color: #bae7d6;
        }
        .colored-rectangle-left {
            width: 30px;
            height: 15px;
            background-color: #bae7d6;
        }
        .colored-rectangle-both {
            width: 30px;
            height: 15px;
            background-color: #d9edf7;
        }
        .colored-rectangle-right {
            width: 30px;
            height: 15px;
            background-color: transparent;
            border: 1px solid #cde0ea;
        }
        hr {
            border: none;
            border-top: 2px solid #cde0ea;
            height: 0;
            margin: 2px auto;
        }
        .line-container {
            width: 100%;
            margin: 0 auto;
        }
        .table-list {
            font-size: 1.2em;
        }
        .inline-toggle {
            display: inline;
        }
        .toggle-button {
            display: inline-block;
            padding: 1px 3px;
            background-color: #337ab7;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            user-select: none;
        }

        /* Optional: Remove the default native triangle marker */
        .toggle-button::-webkit-details-marker,
        .toggle-button {
            list-style: none;
        }

        /* Style the revealed text box */
        .toggle-content {
            margin-top: 10px;
            padding: 10px;
            background-color: #f8f9fa;
            border-left: 3px solid #007bff;
        }
    </style>
</head>
<body>
    <?php require DIR_WS_INCLUDES . 'header.php'; ?>
    <div class="container-fluid">
        <h1><?= HEADING_TITLE ?></h1>
        <div class="row">
            <div class="col-sm-4 col-md-4">
                <?php
                $database_par = (isset($_GET['database']) ? substr(zen_db_prepare_input($_GET['database']), 0) : '');
                echo zen_draw_form('databForm', FILENAME_TOOL_DATABASE, '', 'get', 'class="form-horizontal"');
                ?>
                <div class="form-group">
                <?= zen_draw_label(sprintf(TEXT_CHOOSE_DATABASE, DB_DATABASE), 'database', 'class="control-label col-sm-6"') ?>
                <div class="col-sm-4">
                <?= zen_draw_pull_down_menu('database', $database_list, $database_par, 'onChange="this.form.submit();" class="form-control" id="database"') ?>
                </div>
                </div>
                <?php
                echo zen_hide_session_id();
                echo '</form>';
                ?>
            </div>
            <div class="col-sm-3 col-md-6">
                <div class="col-md-1"><?= TEXT_LEGEND ?></div>
                <div  class="colored-rectangle-left col-md-1"></div>
                <div class="col-md-2"><?= sprintf(TEXT_LEGEND_ONLY_LEFT, $firstDatabase) ?></div>
                <div  class="colored-rectangle-both col-md-1"></div>
                <div class="col-md-2"><?= TEXT_LEGEND_BOTH ?></div>
                <div  class="colored-rectangle-right col-md-1"></div>
                <div class="col-md-2"><?= sprintf(TEXT_LEGEND_ONLY_RIGHT, $secondDatabase) ?></div>
            </div>
        </div>

        <?php
            if (!empty($diffTable[$firstDatabase])) {
        ?>
        <div class="row standard-row">
            <?php
            $tables_list = implode(TEXT_SEPARATOR, $diffTable[$firstDatabase]);
            ?>
            <div class="table-list">
                <details class="inline-toggle">
                    <summary class="toggle-button"><?= sprintf(TEXT_TABLES_OWN, count($diffTable[$firstDatabase])) ?></summary>
                    <div class="toggle-content"><?= $tables_list ?></div>
                </details>
            </div>
        </div>
        <?php
            }
        ?>
        <?php
            if (!empty($diffTable[$secondDatabase])) {
        ?>
        <div class="row standard-row">
            <?php
            $tables_list = implode(TEXT_SEPARATOR, $diffTable[$secondDatabase]);
            ?>
            <div class="table-list">
                <details class="inline-toggle">
                    <summary class="toggle-button"><?= sprintf(TEXT_TABLES_OTHER, count($diffTable[$secondDatabase])) ?></summary>
                    <div class="toggle-content"><?= $tables_list ?></div>
                </details>
            </div>
        </div>
        <?php
            }
        ?>

        <div class="row font-weight-bold bg-primary py-3">
            <div class="col-md-1"><?= TABLE_HEADING_DATABASE ?></div>
            <div class="col-md-2"><?= TABLE_HEADING_TABLE ?></div>
            <div class="col-md-3"><?= TABLE_HEADING_COLUMN ?></div>
            <div class="col-md-1"><?= TABLE_HEADING_DEFAULT ?></div>
            <div class="col-md-1"><?= TABLE_HEADING_NULLABLE ?></div>
            <div class="col-md-2"><?= TABLE_HEADING_COLLATION ?></div>
            <div class="col-md-2"><?= TABLE_HEADING_TYPE ?></div>
        </div>
<?php
$precLine = [
    'DB' => '',
    'TABLE_NAME' => '',
    'COLUMN_NAME' => '',
    'COLUMN_DEFAULT' => '',
    'IS_NULLABLE' => '',
    'COLLATION_NAME' => '',
    'COLUMN_TYPE' => '',
];

$tableDifferences = [];
if (!empty($commonTables)) {
    foreach ($commonTables as $commonTable) {

        $sql = "SELECT DB, TABLE_NAME, COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE, COLLATION_NAME, COLUMN_TYPE FROM
        ( SELECT TABLE_SCHEMA as DB, TABLE_NAME, COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE, COLLATION_NAME, COLUMN_TYPE FROM information_schema.COLUMNS WHERE
        ( (TABLE_SCHEMA = :firstDatabase AND TABLE_NAME = :tableName) OR (TABLE_SCHEMA = :secondDatabase AND TABLE_NAME = :tableName) )
        GROUP BY COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE, COLLATION_NAME, COLUMN_TYPE HAVING COUNT(1)=1 ) as A
        ORDER BY TABLE_NAME, COLUMN_NAME, DB :sortOrder ";
        $sql = $db->bindVars($sql, ':firstDatabase', $firstDatabase, 'string');
        $sql = $db->bindVars($sql, ':secondDatabase', $secondDatabase, 'string');
        $sql = $db->bindVars($sql, ':tableName', $commonTable, 'string');
        $sql = $db->bindVars($sql, ':sortOrder', $sortOrder, 'passthru');
        $result = $db->Execute($sql);

        if (!$result->EOF) {
            foreach ($result as $newColumn) {
                if ($precLine['COLUMN_NAME'] === $newColumn['COLUMN_NAME']) {
                    $newColumn['diffIndex'] = '1111';
                    $newColumn['side'] = 'both';
                } else {
                    $newColumn['diffIndex'] = '0000';
                    $newColumn['side'] = ($newColumn['DB'] === $firstDatabase) ? 'left' : 'right';
                }
                $tableDifferences[] = $newColumn;
                $precLine = $newColumn;
            }
        }
    }

    $keys = array_keys($tableDifferences);
    $count = count($keys);
    $step = 1;
    for ($i = 0; $i < $count - 1; $i += $step) {

        $currentKey = $keys[$i];
        $nextKey    = $keys[$i + 1];
        $currentRow = $tableDifferences[$currentKey];
        $nextRow    = $tableDifferences[$nextKey];

        if ($currentRow['COLUMN_NAME'] === $nextRow['COLUMN_NAME'] && $nextRow['diffIndex'] !== '0000') {
            $tableDifferences[$currentKey]['side'] = 'both';
            $tableDifferences[$nextKey]['diffIndex'] = '0000';
            if ($currentRow['COLUMN_DEFAULT'] !== $nextRow['COLUMN_DEFAULT']) {
                $tableDifferences[$currentKey]['diffIndex'] = '1000';
                $tableDifferences[$nextKey]['diffIndex'] = '1000';
            }
            if ($currentRow['IS_NULLABLE'] !== $nextRow['IS_NULLABLE']) {
                    $tableDifferences[$currentKey]['diffIndex'] = substr_replace($tableDifferences[$nextKey]['diffIndex'], '1', 1, 1);
                    $tableDifferences[$nextKey]['diffIndex'] = substr_replace($tableDifferences[$nextKey]['diffIndex'], '1', 1, 1);
            }
            if ($currentRow['COLLATION_NAME'] !== $nextRow['COLLATION_NAME']) {
                    $tableDifferences[$currentKey]['diffIndex'] = substr_replace($tableDifferences[$nextKey]['diffIndex'], '1', 2, 1);
                    $tableDifferences[$nextKey]['diffIndex'] = substr_replace($tableDifferences[$nextKey]['diffIndex'], '1', 2, 1);
            }
            if ($currentRow['COLUMN_TYPE'] !== $nextRow['COLUMN_TYPE']) {
                    $tableDifferences[$currentKey]['diffIndex'] = substr_replace($tableDifferences[$nextKey]['diffIndex'], '1', 3, 1);
                    $tableDifferences[$nextKey]['diffIndex'] = substr_replace($tableDifferences[$nextKey]['diffIndex'], '1', 3, 1);
            }
            $step = 2;
        } else {
            $step = 1;
        }
    }

    $precLine = [
        'DB' => '',
        'TABLE_NAME' => '',
        'COLUMN_NAME' => '',
        'COLUMN_DEFAULT' => '',
        'IS_NULLABLE' => '',
        'COLLATION_NAME' => '',
        'COLUMN_TYPE' => '',
    ];
}

if (!empty($tableDifferences)) {
    foreach ($tableDifferences as $diffColum) {
        echo (($precLine['TABLE_NAME'] !== $diffColum['TABLE_NAME'] || $precLine['COLUMN_NAME'] !== $diffColum['COLUMN_NAME']) && $precLine['TABLE_NAME'] !== '') ? '<div class="line-container"><hr></div>' : '';
?>
        <div class="standard-row<?= ($diffColum['side'] === 'both') ? ' diff-row-value' : (($diffColum['side'] === 'left') ? ' left-only' : '') ?>">
          <div class="col-md-1"><?= $diffColum['DB'] ?></div>
          <div class="col-md-2"><?= $diffColum['TABLE_NAME'] ?></div>
          <div class="col-md-3"><?= $diffColum['COLUMN_NAME'] ?></div>
          <div class="col-md-1<?= (substr($diffColum['diffIndex'], 0, 1) === '1') ? ' val-dif' : '' ?>"><?= $diffColum['COLUMN_DEFAULT'] ?></div>
          <div class="col-md-1<?= (substr($diffColum['diffIndex'], 1, 1) === '1') ? ' val-dif' : '' ?>"><?= $diffColum['IS_NULLABLE'] ?></div>
          <div class="col-md-2<?= (substr($diffColum['diffIndex'], 2, 1) === '1') ? ' val-dif' : '' ?>"><?= $diffColum['COLLATION_NAME'] ?></div>
          <div class="col-md-2<?= (substr($diffColum['diffIndex'], 3, 1) === '1') ? ' val-dif' : '' ?>"><?= $diffColum['COLUMN_TYPE'] ?></div>
        </div>
<?php
        $precLine = $diffColum;
    }
}
?>
    </div>
<!-- footer //-->
<?php require DIR_WS_INCLUDES . 'footer.php'; ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require DIR_WS_INCLUDES . 'application_bottom.php'; ?>
