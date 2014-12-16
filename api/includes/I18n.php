<?php
namespace includes;

/**
 * Description of I18n
 *
 * @author artyom
 */
class I18n 
{
	/** @var string mark for english language */
    const LANG_EN = 'en';
	/** @var string mark for ukrainian language */
    const LANG_UA = 'ua';
	/** @var string strings file suffix */
	const LANG_FILE_SUFFIX = 'strings.xml';
	/** @var string relative(from root) path to lang folder */
	const LANG_PATH = '/resources/lang/';

	/** @var string current language */
    private $usedLang = '';

	/** @var array - assoc array with lang mark => translated string */
	private $strings = array();

	/**
	 * @param string $lang - language code
	 */
    public function __construct($lang = self::LANG_EN)
    {
		$this->usedLang = $lang;

		$this->loadStrings($lang);
    }
  
	/**
	 * get translated string
	 * @param string $langMark
	 * @return string
	 */
    public function getString($langMark)
    {
		if (isset($this->strings[$langMark]))
		{
			return $this->strings[$langMark];
		}

		return $langMark;
    }


	private function loadStrings($language)
	{
		if ($language !== self::LANG_EN) //by default always load eng strings
		{
			$this->loadStrings(self::LANG_EN);
		}

		if (is_readable(BASE_ROOT . self::LANG_PATH . $language 
				. self::LANG_FILE_SUFFIX))
		{
			#do stuff
		}
	}
}
