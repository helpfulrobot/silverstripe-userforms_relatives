<?php
/**
 *
 * @package userforms
 * @subpackage relatives
 */

class EditableAncestryField extends EditableFormField {

	static $singular_name = 'Ancestry field';

	static $plural_name = 'Ancestry fields';

	static $repeated_fields = array();

	function getFieldConfiguration() {
		$fields = parent::getFieldConfiguration();
		return $fields;
	}

	static $max_cols = 4;

	static $colour_array = array(
		"f" => "black",
		"m" => "grey"
	);

	static $background_colour_array = array(
		"f" => "#eee",
		"m" => "white"
	);

	static $alternating_letters = array(
		"f",
		"m"
	);

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
		$html = "<div class=\"editableAncestryField\">";

		$extraFieldArray = array();
		foreach(self::$repeated_fields as $field) {
			if(!empty($data[$field])) {
				$extraFieldArray[] = $data[$field];
			}
		}
		if(count($extraFieldArray)) {
			$html .= "<h2 class=\"extraFieldArray\">".implode(" " , $extraFieldArray)."</h2>";
		}

		$maxCols = self::$max_cols;

		$colourArray = self::$colour_array;

		$backgroundColourArray = self::$background_colour_array;

		for($col = 1; $col <= $maxCols; $col++) {
			$generationKeyArray[$col] = self::$alternating_letters[0];
		}
		$maxRows = pow(2, $maxCols);
		$returnValue = "";
		$value = (isset($data[$this->Name])) ? $data[$this->Name] : false;
		$formField = $this->getFormField();
		if($value) {
			if(is_array($value)) {
				$html .= "<table cellpadding=\"3\" cellspacing=\"3\" border=\"0\" width=\"95%\" class=\"ancestryTable\"><tbody>";
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
								$html .= "<td colspan=\"$maxCols\" style=\"background-color: #ccc\" class=\"endOfRow\"></td></tr><tr>";
							}
							$currentKey = $generationKeyArray[$col];
							if($generationKeyArray[$col] == self::$alternating_letters[0]) {
								$generationKeyArray[$col] = self::$alternating_letters[1];
							}
							else {
								$generationKeyArray[$col] = self::$alternating_letters[0];
							}
							$myKey = "";
							for($colsForKey = 1; $colsForKey < $col; $colsForKey++) {
								$myKey .= $generationKeyArray[$colsForKey];
							}
							$myKey .= $currentKey."Field";
							$title = $name = "";
							$colour = $colourArray[$currentKey];
							$backgroundColour = $backgroundColourArray[$currentKey];
							$completionClass = "emptyCell";
							if(isset($value[$myKey])) {
								$title = $formField->titleForAncestor($myKey);
								$name = $value[$myKey];
								$completionClass = "completedCell";
								if(!$name) {
									$name = "not entered";
									$completionClass = "noNameEnteredCell";
								}
							}
							$html .= "<td rowspan=\"$myRowSpan\" class=\"col$col row$row $completionClass\" style=\"background-color: $backgroundColour; border-top: 2px solid $colour; border-bottom: 2px solid $colour; border-left: 1px solid $colour; border-right: 1px solid $colour\" border=\"1\">
								<strong style=\"color: $colour; text-transform: uppercase; font-size: 75%; font-weight: bold;\">$title:</strong>
								<div style=\"font-size: 100%; color:$colour \"><u>$name</u></div></td>";
						}
					}
					$html .= "</tr>";
				}
				$html .= "</tbody></table>";
			}
		}
		$latestSubmissions = DataObject::get("SubmittedForm", "", "Created DESC", "", 1);
		//this is a hack as I could not find a way to link this editableformfield to a submission...
		//it will not work when two people are submitting at the same time!
		foreach($latestSubmissions as $latestSubmission) {
			$html .= "<h3 class=\"printLinkForAncestryForm\"><a href=\"".Director::absoluteBaseURL()."/viewsubmissionfromuserform/show/".$latestSubmission->ID."/\">view (and print) submission online ... </a></h3>";
		}
		$html .= "</div>";
		return $html;
	}

	public function Icon() {
		return 'userforms_relatives/images/icons/' . strtolower($this->class) . '.png';
	}

}
