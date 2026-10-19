<?php
use Zencart\PluginSupport\ScriptedInstaller as ScriptedInstallBase;

class ScriptedInstaller extends ScriptedInstallBase
{

    protected function executeInstall()
    {
        zen_register_admin_page('toolsDatabaseComparison', 'BOX_TOOLS_DATABASE_COMP', 'FILENAME_TOOL_DATABASE', '', 'tools', 'Y');

        parent::executeInstall();
    }

    // Note: This (https://github.com/zencart/zencart/pull/6498) Zen Cart PR must
    // be present in the base code or a PHP Fatal error is generated due to the
    // function signature difference.
    //
    protected function executeUpgrade($oldVersion)
    {
        parent::executeUpgrade($oldVersion);
    }

    protected function executeUninstall()
    {
        zen_deregister_admin_pages(['toolsDatabaseComparison']);

        parent::executeUninstall();
    }
}
