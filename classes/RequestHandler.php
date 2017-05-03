<?php
/**
 * Vendor: TerOganisyan
 * Author: arsen
 */

namespace Main;

/**
 * Class RequestHandler
 *
 * @package Main
 */
class RequestHandler
{

    /**
     * @var string
     */
    private $table = "orders";

    /**
     * @var int
     */
    private $nameMaxLength = 50;

    /**
     * @var int
     */
    private $telMaxLength = 150;

    /**
     * @var int
     */
    private $descrMaxLength = 400;

    /**
     * @var string
     */
    private $reg = "/((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}/";

    /**
     * @var string
     */
    private $telCode = "812";

    /**
     * @var int
     */
    private $digits = 7;

    /**
     * @var mixed
     */
    private $countryCode = "8";

    /**
     * @var int
     */
    private $fullDigits = 11;

    /**
     * @var int
     */
    private $withoutCountryCodeDigits = 10;

    /**
     * @var string
     */
    private $countryCodeAnotherFormat = "+7";

    /**
     * RequestHandler constructor.
     *
     * @param array $config config
     */
    public function __construct(array $config)
    {
        if (isset($config['name_max_lenth'])) {
            $this->nameMaxLength = $config['name_max_lenth'];
        }

        if (isset($config['name_max_lenth'])) {
            $this->telMaxLength = $config['tel_max_lenth'];
        }

        if (isset($config['descr_max_lenth'])) {
            $this->descrMaxLength = $config['descr_max_lenth'];
        }

        if (isset($config['tel_code'])) {
            $this->telCode = $config['tel_code'];
        }

        if (isset($config['digits'])) {
            $this->digits = $config['digits'];
        }

        if (isset($config['full_digits'])) {
            $this->fullDigits = $config['full_digits'];
        }

        if (isset($config['country_code'])) {
            $this->countryCode = $config['country_code'];
        }

        if (isset($config['without_country_code_digits'])) {
            $this->withoutCountryCodeDigits = $config['without_country_code_digits'];
        }

        if (isset($config['country_code_anotherFormat'])) {
            $this->countryCodeAnotherFormat = $config['country_code_another_format'];
        }
    }

    /**
     * @param array $request request
     *
     * @return string
     */
    public function getSQL(array $request)
    {
        $sql = "insert into {$this->table} (`c_name`, `c_tel`, `c_desc`) values";
        $sql .= "({$this->getValues($request)})";
        return $sql;
    }

    /**
     * @param $tel
     *
     * @return array|mixed
     */
    public function getTelList($tel)
    {
        $matches = [];
        preg_match_all($this->reg, $tel, $matches);
        $matches = $matches[0];

        if (count($matches) === 0) {
            throw new UndefinedCustomerException();
        }

        foreach ($matches as $key => $match) {
            $matches[$key] = $this->format($match);
        }
        return $matches;
    }

    /**
     * @param array $request
     *
     * @return string
     */
    private function getValues(array $request)
    {
        $values = [];
        $values[] = '"' . addslashes(substr($request['name'], 0, $this->nameMaxLength)) .'"';
        $values[] = '"' . addslashes(substr($request['tel'], 0, $this->telMaxLength)) .'"';
        $values[] = '"' . addslashes(substr($request['descr'], 0, $this->descrMaxLength)) .'"';
        return implode(',', $values);
    }

    /**
     * @param $tel
     *
     * @return mixed|string
     */
    private function format($tel)
    {
        $tel = str_replace([' ', '-', '(', ')', $this->countryCodeAnotherFormat], ['', '', '', '', $this->countryCode], $tel);

        if (strlen($tel) === $this->digits) {
            return $this->countryCode . $this->telCode . $tel;
        }

        if (count($tel) === $this->withoutCountryCodeDigits) {
            return $this->countryCode . $tel;
        }

        return $tel;
    }
}