<?php




class ViewSubmittedForm extends Controller {

	public static $allowed_actions = array(
		"show" => "Admin"
	);

	function init(){
		parent::init();
		if(!Permission::check("CMS_ACCESS_CMSMain")) {
			Security::permissionFailure($this, _t('Security.PERMFAILURE',' This page is secured and you need administrator rights to access it. Enter your credentials below and we will send you right along.'));
		}
	}

	/**
	 *
	 * @var Int
	 */
	protected $submissionID;

	/**
	 * show the submission
	 *
	 */
	function show($request){
		$this->submissionID = intval($request->param("ID"));
		Requirements::themedCSS("ViewSubmittedForm");
		return $this->renderWith("ViewSubmittedForm");
	}

	function SubmittedForm(){
		return $submittedForm = DataObject::get_by_id("SubmittedForm", $this->submissionID);
	}


}
