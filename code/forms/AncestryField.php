<?php
/**
 *
 * @package userforms
 * @subpackage relatives
 */
class AncestryField extends FormField {

	/**
	 * @var nameField
	 */
	//level 1
	protected static $array_of_ancestors = array(
		"m" => "Mother",
		"f" => "Father",
	//level 2
		"mm" => "Mother's Mother",
		"mf" => "Mother's Father",
		"fm" => "Father's Mother",
		"ff" => "Father's Father",
	//level 3
		"mmm" => "Mother's Mother's Mother",
		"mmf" => "Mother's Mother's Father",
		"mfm" => "Mother's Father's Mother",
		"mff" => "Mother's Father's Father",
		"fmm" => "Father's Mother's Mother",
		"fmf" => "Father's Mother's Father",
		"ffm" => "Father's Father's Mother",
		"fff" => "Father's Father's Father",
	//level 4
		"mmmm" => "Mother's Mother's Mother's Mother",
		"mmmf" => "Mother's Mother's Mother's Father",
		"mmfm" => "Mother's Mother's Father's Mother",
		"mmff" => "Mother's Mother's Father's Father",
		"mfmm" => "Mother's Father's Mother's Mother",
		"mfmf" => "Mother's Father's Mother's Father",
		"mffm" => "Mother's Father's Father's Mother",
		"mfff" => "Mother's Father's Father's Father",
		"fmmm" => "Father's Mother's Mother's Mother",
		"fmmf" => "Father's Mother's Mother's Father",
		"fmfm" => "Father's Mother's Father's Mother",
		"fmff" => "Father's Mother's Father's Father",
		"ffmm" => "Father's Father's Mother's Mother",
		"ffmf" => "Father's Father's Mother's Father",
		"fffm" => "Father's Father's Father's Mother",
		"ffff" => "Father's Father's Father's Father"
	);
	static function get_array_of_ancestors() {return self::$array_of_ancestors;}
	static function set_array_of_ancestors($a) {self::$array_of_ancestors = $a;}
	public function titleForAncestor($k) {
		$k = str_replace("Field", "", $k);
		return self::$array_of_ancestors[$k];
	}

	protected $fieldHolder = array();

	function __construct($name, $title = null, $value = ""){
		foreach(self::get_array_of_ancestors() as $key => $fieldTitle) {
			$this->fieldHolder[$key] = new TextField($name . '['.$key.'Field]', $fieldTitle);
		}
		parent::__construct($name, $title, $value);
	}

	function setForm($form) {
		parent::setForm($form);
		foreach(self::get_array_of_ancestors() as $key => $fieldTitle) {
			$this->fieldHolder[$key]->setForm($form);
		}
	}

	function Field() {
		Requirements::themedCSS("AncestryField");
		Requirements::javascript(THIRDPARTY_DIR."/jquery/jquery.js");
		Requirements::javascript("userforms_relatives/javascript/AncestryField.js");
		$html = "";
		foreach(self::get_array_of_ancestors() as $key => $fieldTitle) {
			$levelClass = "level".(strlen($key));
			$nextLevels = ".{$key}mField, .{$key}fField";
			$html .= "<div class=\"{$key}Field $levelClass ancestorNode \" rel=\"$nextLevels\">".$this->fieldHolder[$key]->SmallFieldHolder()."</div>";
		}
		return $html;
	}

	/**
	 */
	function setValue($val) {
		if(empty($val)) {
			foreach(self::get_array_of_ancestors() as $key => $fieldTitle) {
				$this->fieldHolder[$key]->setValue(null);
			}
		}
		else {
			// String setting is only possible from the database, so we don't allow anything but ISO format
			if(is_string($val)) {
				//TO DO
			}
			// Setting from form submission
			elseif(is_array($val)) {
				foreach(self::get_array_of_ancestors() as $key => $fieldTitle) {
					$myValue = isset($val[$key]) ? $val[$key] : "";
					$this->fieldHolder[$key]->setValue($myValue);
				}
			}
			else {
				$this->nameField->setValue($val);
				$this->dobField->setValue($val);
				$this->sexField->setValue($val);
			}
		}
	}

	function dataValue() {
		$array = array();
		foreach(self::get_array_of_ancestors() as $key => $fieldTitle) {
			$array[$key] = $this->fieldHolder[$key]->dataValue();
		}
		return $array;
	}

	public function Icon() {
		return 'userforms/images/' . strtolower($this->class) . '.png';
	}

}

