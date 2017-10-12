<?php

/**
 * Seo class to set application meta data.
 *
 * @name       Seo.php
 * @category   ToolKit
 * @package    Seo
 * @author     Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */

namespace Modules\ToolKit;

/**
 * Seo class to set application meta data.
 *
 * @name     Seo
 * @category ToolKit
 * @package  Seo
 * @author   Ajay Bhosale <ajay.bhosalesilicus.com>
 * @license  Silicus http://www.silicus.com
 * @version  Release:<v.1>
 * @link     None
 */
class Seo
{

    /**
     * Defined list of meta data
     *
     * @var array
     */
    public $metaTags = ['Title' => null, 'Description' => null, 'Keywords' => null];

    /**
     * Set page title
     *
     * @name   setTitle
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @param string $title description
     *
     * @return void
     */
    public function setTitle($title)
    {
        $this->metaTags['title'] = $title;
    }

    /**
     * Set page description
     *
     * @name   setDescription
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @param string $description description
     *
     * @return void
     */
    public function setDescription($description)
    {
        $this->metaTags['description'] = $description;
    }

    /**
     * Set page kewords
     *
     * @name   setKewords
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @param string $keywords Comma separated keywords
     *
     * @return void
     */
    public function setKewords($keywords)
    {
        $this->metaTags['keywords'] = $keywords;
    }

    /**
     * Generate meta data block
     *
     * @name   render
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @return void
     */
    public function render()
    {
        $html = '';
        foreach ($this->metaTags as $metaTag => $value) {

            if ($metaTag == 'title') {
                $html .= '<title>' . $value . '</title>' . PHP_EOL;
            } elseif (empty($value)) {

            } else {
                $html .= '<meta name="' . $metaTag . '" content="' . $value . '" />' . PHP_EOL;
            }
        }

        return $html;
    }

}
