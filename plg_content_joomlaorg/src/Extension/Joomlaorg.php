<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Content.joomlaorg
 *
 * @copyright   (C) 2026 Joomla Organisation. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Plugin\Content\Joomlaorg\Extension;

\defined('_JEXEC') or die;

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Event\Event;
use Joomla\Event\SubscriberInterface;
use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;

/**
 * Joomlaorg Content Plugin
 *
 * @since  1.0.0
 */
class Joomlaorg extends CMSPlugin implements SubscriberInterface
{
	/**
	 * Load the language file on instantiation.
	 *
	 * @var    boolean
	 * @since  1.0.0
	 */
	protected $autoloadLanguage = true;

	/**
	 * Returns an array of events this subscriber will listen to.
	 *
	 * @return  array
	 *
	 * @since   1.0.0
	 */
	public static function getSubscribedEvents(): array
	{
		return [
			'onContentPrepareForm' => 'onContentPrepareForm',
			'onAjaxJoomlaorg'      => 'onAjaxJoomlaorg',
		];
	}

	/**
	 * Prepare form and add script.
	 *
	 * @param   Event  $event  The event object
	 *
	 * @return  void
	 *
	 * @since   1.0.0
	 */
	public function onContentPrepareForm(Event $event)
	{
		/** @var Form $form */
		$form = $event->getArgument('0');
		$data = $event->getArgument('1');

		// We only want to handle the com_content article form
		if (!$form instanceof Form || $form->getName() !== 'com_content.article') {
			return;
		}

		// Only apply logic for new articles (when 'id' is empty or 0)
		$id = isset($data['id']) ? (int) $data['id'] : 0;
		if ($id !== 0) {
			return;
		}

		$app = Factory::getApplication();

		// Ensure we are in the backend/frontend where WebAssetManager is available
		if (!method_exists($app->getDocument(), 'getWebAssetManager')) {
			return;
		}

		/** @var \Joomla\CMS\WebAsset\WebAssetManager $wa */
		$wa = $app->getDocument()->getWebAssetManager();

		// Register the script and depend on core to ensure Joomla JS API is loaded if needed
		$wa->registerScript('plg_content_joomlaorg', 'plg_content_joomlaorg/joomlaorg.js', [], ['core'], ['type' => 'module']);
		$wa->useScript('plg_content_joomlaorg');
	}

	/**
	 * Ajax listener for com_ajax triggered requests
	 *
	 * URL: index.php?option=com_ajax&plugin=joomlaorg&group=content&format=json
	 *
	 * @return  string  The default title configured in plugin parameters
	 *
	 * @since   1.0.0
	 */
	public function onAjaxJoomlaorg()
	{
		// Fetch the textfield parameter value. Fallback strictly to 'Default Title' if empty.
		$defaultTitle = $this->params->get('default_title_text', 'Default Title');
		
		return $defaultTitle;
	}
}
