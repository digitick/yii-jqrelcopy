<?php
/**
 * JQRelcopy.php
 *
 * A wrapper for the jquery plugin 'relCopy'
 *
 * @link http://www.andresvidal.com/labs/relcopy.html
 *
 * @author Joe Blocher <yii@myticket.at>
 * @copyright 2011 myticket it-solutions gmbh
 * @license New BSD License
 * @category User Interface
 * @version 1.1
 */
class JQRelcopy extends CWidget
{
	/**
	 * The text for the remove link
	 * Can be an image tag too.
	 * Leave empty to disable removing.
	 *
	 * @var string $removeText
	 */
	public $removeText;

	/**
	 * The htmlOptions for the remove link
	 *
	 * @var array $removeHtmlOptions
	 */
	public $removeHtmlOptions = array();

	/**
	 * Available options
	 *
	 * string excludeSelector - A jQuery selector used to exclude an element and its children
	 * integer limit - The number of allowed copies. Default: 0 is unlimited
	 * string append - Additional HTML to attach at the end of each copy.
	 * string copyClass - A class to attach to each copy
	 * boolean clearInputs - Option to clear each copies text input fields or textarea
	 *
	 * @var array $options
	 */
	public $options = array();

	/**
	 * The javascript code jsBeforeClone,jsAfterClone ...
	 * This allows to handle widgets on cloning.
	 * Important: 'this' is the current handled jQuery object
	 *
	 */
	public $jsBeforeClone; // 'jsBeforeClone' => "alert(this.attr('class'));";
	public $jsAfterClone;  // 'jsAfterClone' => "alert(this.attr('class'));";
	public $jsBeforeNewId;  // 'jsBeforeNewId' => "alert(this.attr('id'));";
	public $jsAfterNewId;  // 'jsAfterNewId' => "alert(this.attr('id'));";
	public $jsFinish;  // 'jsFinish' => "alert(this.attr('class'));";

	/**
	 * The assets url
	 *
	 * @var string $_assets
	 */
	private $_assets;

	/**
	 * Initialize the widget
	 *
	 * @return
	 */
	public function init()
	{
		$this->_assets = Yii::app()->assetManager->publish(dirname(__FILE__).DIRECTORY_SEPARATOR.'assets');

		Yii::app()->clientScript->registerCoreScript('jquery')
		          ->registerScriptFile($this->_assets.'/js/jquery.relcopy.1.1.js');

		if (!empty($this->removeText))
		{
			$onClick = '$(this).parent().remove(); return false;';
			$htmlOptions = array_merge(array('onclick'=>$onClick),$this->removeHtmlOptions);
			$append = CHtml::link($this->removeText,'#',$htmlOptions);

			$this->options['append'] = empty($this->options['append']) ? $append : $append .' '.$this->options['append'];
		}

		if (!empty($this->jsBeforeClone))
			$this->options['beforeClone'] = $this->jsBeforeClone;

		if (!empty($this->jsAfterClone))
			$this->options['afterClone'] = $this->jsAfterClone;
		
		if (!empty($this->jsBeforeNewId))
			$this->options['beforeNewId'] = $this->jsBeforeNewId;

		if (!empty($this->jsAfterNewId))
			$this->options['afterNewId'] = $this->jsAfterNewId;
		
		if (!empty($this->jsFinish))
			$this->options['finish'] = $this->jsFinish;

		$options = CJavaScript::encode($this->options);
		Yii::app()->getClientScript()->registerScript(__CLASS__.'#'.$this->id,"jQuery('#{$this->id}').relCopy($options);");
		parent::init();
	}
}
?>