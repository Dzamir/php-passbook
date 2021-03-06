<?php

/*
 * This file is part of the Passbook package.
 *
 * (c) Eymen Gunay <eymen@egunay.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Passbook\Pass;

/**
 * BarcodeInterface
 *
 * @author Eymen Gunay <eymen@egunay.com>
 */
interface BarcodeInterface
{
    /**
     * Sets barcode format
     *
     * @param string
     */
    public function setFormat($format);

    /**
     * Returns barcode format
     *
     * @return string
     */
    public function getFormat();

    /**
     * Sets barcode message
     *
     * @param string
     */
    public function setMessage($message);

    /**
     * Returns barcode message
     *
     * @return string
     */
    public function getMessage();

    /**
     * Sets barcode message encoding
     *
     * @param string
     */
    public function setMessageEncoding($messageEncoding);

    /**
     * Returns barcode message encoding
     *
     * @return string
     */
    public function getMessageEncoding();

    /**
     * Sets barcode alt text
     *
     * @param string
     */
    public function setAltText($altText);

    /**
     * Returns barcode alt text
     *
     * @return string
     */
    public function getAltText();
}
