<?php
/**
 * Vendor: TerOganisyan
 * Author: arsen
 */

namespace Main;

/**
 * Class UndefinedCustomerException
 *
 * @package Main
 */
class UndefinedCustomerException extends \RuntimeException implements Displayable
{

    /**
     * @var string
     */
    protected $message = "Invalid request, because telephone is not defined and we can't identify a custumer";

    /**
     * UndefinedCustomerException constructor.
     *
     * @param string $message
     *
     * @param int $code
     *
     * @param \Exception|null $previous
     */
    public function __construct($message = "", $code = 0, \Exception $previous = null)
    {
        parent::__construct($this->message, $code, $previous);
    }

    /**
     * @return string
     */
    public function display()
    {
        return $this->getMessage();
    }
}