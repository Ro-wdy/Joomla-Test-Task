<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Content.joomlaorg
 *
 * @copyright   (C) 2026 Joomla Organisation. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Extension\PluginInterface;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use Joomla\Event\DispatcherInterface;
use Joomla\Plugin\Content\Joomlaorg\Extension\Joomlaorg;

/**
 * Service provider for the joomlaorg content plugin
 *
 * @since  1.0.0
 */
return new class implements ServiceProviderInterface
{
	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  void
	 *
	 * @since   1.0.0
	 */
	public function register(Container $container)
	{
		$container->set(
			PluginInterface::class,
			function (Container $container) {
				$dispatcher = $container->get(DispatcherInterface::class);
				$plugin     = new Joomlaorg(
					$dispatcher,
					(array) PluginHelper::getPlugin('content', 'joomlaorg')
				);

				return $plugin;
			}
		);
	}
};
