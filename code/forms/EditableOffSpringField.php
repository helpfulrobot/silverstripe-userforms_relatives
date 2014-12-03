<?php
/**
 *
 * @package userforms
 * @subpackage relatives
 */

class EditableOffSpringField extends EditableFormField {

	static $singular_name = 'Offspring field';

	static $plural_name = 'Offspring fields';

	function getFieldConfiguration() {
		$fields = parent::getFieldConfiguration();
		return $fields;
	}

	function getFormField() {
		return new OffSpringField($this->Name, $this->Title);
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
	 *
	 * @return String
	 */
	function getValueFromData($data) {
		$value = (isset($data[$this->Name])) ? $data[$this->Name] : false;
		if($value) {
			$sexySex = isset($value["sex"]) ?  ($value["sex"] == 0 ? "female" : "male") : "-- not entered --";
			$name = isset($value["name"]) ? $value["name"] : "-- not entered --";
			$dob = isset($value["dob"]) ? $value["dob"] : "-- not entered --";
			return "Name: $name | dob: $dob | sex: $sexySex";
		}
	}

	public function Icon() {
		return 'userforms_relatives/images/icons/' . strtolower($this->class) . '.png';
	}

}
