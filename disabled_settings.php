<?php

/**
 * Disabled Settings
 *
 * For configuration options, see config.inc.php.dist!
 *
 * @version @package_version@
 * @license GNU GPLv3+
 * @author Juan Pablo Hurtado
 */
class disabled_settings extends rcube_plugin
{
	public $task = 'settings';

	static private $plugin = 'Disabled Settings';

    function init()
    {			
		$this->add_hook('settings_actions', array($this, 'startup'));
    }

    function startup($args)
    {
		$this->load_config();			
		if (rcmail::get_instance()->config->get('disabled_settings_all') == 'true')
		{
			//Access to settings is disabled (no exceptions)
			header('Location: ./?' . $this->query);
			exit;
		}
		else if (rcmail::get_instance()->config->get('disabled_settings_qs_key') != '')
		{
			//Access to settings granted providing specific QueryString Values
			$this->query = $_SERVER['QUERY_STRING'];
			$this->qs_key = rcmail::get_instance()->config->get('disabled_settings_qs_key');
			$this->qs_value = rcmail::get_instance()->config->get('disabled_settings_qs_value');
			$this->pos = strrpos($this->query, $this->qs_key.'='.$this->qs_value);
			//echo '['.$this->query.']['.$this->qs_key.']['.$this->qs_value.']['.(int)$this->pos.']';exit;
			if ((int)$this->pos == 0) {
				header('Location: ./?');
				exit;
			}
		}
        return $args;
    }
}