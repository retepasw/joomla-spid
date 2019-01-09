<?php

defined('JPATH_BASE') or die;

class JFormFieldAjax extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  3.8.6
	 */
	protected $type = 'Ajax';

	protected function getLabel()
	{
		return;
	}

	/**
	 * Method to get the field input markup.
	 *
	 * @return  string	The field input markup.
	 *
	 * @since   3.8.6
	 */
	protected function getInput()
	{
		JLog::add(new JLogEntry(__METHOD__, JLog::DEBUG, 'plg_system_spid'));

		$allowedElement = array('button', 'a');
		
		if (in_array($this->element['htmlelement'], $allowedElement))
		{
			$type = $this->element['htmlelement'];
		}
		else
		{
			$type = 'button';
		}

		JLog::add(new JLogEntry(print_r($this->element, true), JLog::DEBUG, 'plg_system_spid'));
		if (!$this->element['group']) return;
		if (!$this->element['plugin']) return;
		$format  = $this->element['format'] ? (string) $this->element['format'] : 'json';
		$text    = $this->element['text'];
		$class   = $this->element['class'] ? (string) $this->element['class'] : '';
		$icon    = $this->element['icon'] ? (string) $this->element['icon'] : '';
		$label   = $this->element['label'] ? JText::_((string) $this->element['label']) : '';
		$title   = $this->element['description'] ? JText::_((string) $this->element['description']) : '';
		$title   = $title ? 'title="' . $title . '"' : '';

		$data = "{'option':'com_ajax',".
			"'group':'{$this->element['group']}',".
			"'plugin':'{$this->element['plugin']}',";
		foreach (explode(',', $this->element['fields']) as $field)
		{
			$v = $this->getId($this->getAttribute('name') . '_' . $field, $this->getName($this->getAttribute('name') . '_' . $field));
			$data .= "'{$field}':jQuery('#{$v}')[0].value,";
		}
		$data .= "'format':'{$format}'}";
		
		JLog::add(new JLogEntry($data, JLog::DEBUG, 'plg_system_spid'));
		
		$onclick = ' onclick="jQuery.getJSON(\'index.php\',' . $data . ').done(function(r){Joomla.renderMessages(r.messages);});return false;"';
		
		JLog::add(new JLogEntry($onclick, JLog::DEBUG, 'plg_system_spid'));

		if ($icon)
		{
			$icon = '<span class="icon ' . $icon . '"></span>';
		}

		return '<' . $type . ' id="' . $this->id . '" class="btn ' . $class . '" ' .
				$onclick . $title . '>' .
				$icon .
				htmlspecialchars($label, ENT_COMPAT, 'UTF-8') .
				'</' . $type . '>';
	}
}
