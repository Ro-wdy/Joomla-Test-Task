/**
 * @package     Joomla.Plugin
 * @subpackage  Content.joomlaorg
 *
 * @copyright   (C) 2026 Joomla Organisation. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

document.addEventListener('DOMContentLoaded', () => {
	// The ID for the article title field in Joomla is typically "jform_title"
	const titleField = document.getElementById('jform_title');

	// Only apply the ajax call if the field exists and its value is empty
	if (titleField && titleField.value.trim() === '') {
		const url = 'index.php?option=com_ajax&plugin=joomlaorg&group=content&format=json';

		fetch(url)
			.then(response => {
				if (!response.ok) {
					throw new Error('Network response was not ok');
				}
				return response.json();
			})
			.then(data => {
				// com_ajax returns a JSON object where the 'data' property contains an array
				// of responses from all matching plugins. In this case, there will be only one.
				if (data && data.success && data.data && data.data.length > 0) {
					const defaultValue = data.data[0];
					if (defaultValue) {
						titleField.value = defaultValue;
						// Trigger change event just in case there are other scripts listening
						titleField.dispatchEvent(new Event('change', { bubbles: true }));
					}
				}
			})
			.catch(error => {
				console.error('Error fetching data for joomlaorg plugin:', error);
			});
	}
});
