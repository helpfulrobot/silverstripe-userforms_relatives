<?php
/**
 *
 * @package userforms
 * @subpackage relatives
 */

class EditableAncestryField extends EditableFormField {

	static $singular_name = 'Ancestry field';

	static $plural_name = 'Ancestry fields';

	function getFieldConfiguration() {
		$fields = parent::getFieldConfiguration();
		return $fields;
	}

	function getFormField() {
		return new AncestryField($this->Name, $this->Title);
	}

	/**
	 * Return the validation information related to this field. This is
	 * interrupted as a JSON object for validate plugin and used in the
	 * PHP.
	 *
	 * @see http://docs.jquery.com/Plugins/Validation/Methods
	 * @return Array
	 */
	public function getValidation() {
		$options = array();
		return $options;
	}

	/**
	 * Return the Value of this Field
	 * Grid of four cols and 16 rows
	 *
	 * @return String
	 */
	function getValueFromData($data) {
		$maxCols = 4;
		$colourArray = array(
			"f" => "darkBlue",
			"m" => "grey"
		);
		$backgroundColourArray = array(
			"f" => "white",
			"m" => "white"
		);
		$generationKeyArray = array();
		for($col = 1; $col <= $maxCols; $col++) {
			$generationKeyArray[$col] = "m";
		}
		$maxRows = pow(2, $maxCols);
		$returnValue = "";
		$value = (isset($data[$this->Name])) ? $data[$this->Name] : false;
		$formField = $this->getFormField();
		if($value) {
			if(is_array($value)) {
				$html = "<table cellpadding=\"5\" cellspacing=\"5\" border=\"0\"><tbody>";
				for($row = 1; $row <= $maxRows; $row++) {
					$html .= "<tr>";
					for($col = 1; $col <= $maxCols;$col++) {
						$myRowColAdjuster = floor($maxRows / (pow(2, $col)));
						$myRowSpan = $myRowColAdjuster;
						$skipCell = ($row - 1) % $myRowColAdjuster ? TRUE : FALSE;
						if($skipCell) {
							//do nothing
						}
						else {
							if(($row-1) == round($maxRows / 2) && $col == 1) {
								$html .= "<td colspan=\"$maxCols\" style=\"background-color: #ccc\"></td></tr><tr>";
							}
							$currentKey = $generationKeyArray[$col];
							if($generationKeyArray[$col] == "m") {
								$generationKeyArray[$col] = "f";
							}
							else {
								$generationKeyArray[$col] = "m";
							}
							$myKey = "";
							for($colsForKey = 1; $colsForKey < $col; $colsForKey++) {
								$myKey .= $generationKeyArray[$colsForKey];
							}
							$myKey .= $currentKey."Field";
							$title = $name = "";
							$colour = $colourArray[$currentKey];
							$backgroundColour = $backgroundColourArray[$currentKey];
							if(isset($value[$myKey])) {
								$title = $formField->titleForAncestor($myKey);
								$name = $value[$myKey];
								if(!$name) {
									$name = "not entered";
								}
							}
							$html .= "<td rowspan=\"$myRowSpan\" class=\"col$col row$row\" style=\"background-color: $backgroundColour; border-top: 2px solid $colour; border-bottom: 2px solid $colour; border-left: 1px solid $colour; border-right: 1px solid $colour\" border=\"1\">
								<strong style=\"color: $colour; text-transform: uppercase; font-size: 75%; font-weight: bold;\">$title:</strong>
								<div style=\"font-size: 100%; color:$colour \"><u>$name</u></div></td>";
						}
					}
					$html .= "</tr>";
				}
				$html .= "</tbody></table>";
			}
		}
		die($html);
		return $html;
	}

	public function Icon() {
		return 'userforms_relatives/images/icons/' . strtolower($this->class) . '.png';
	}

}
