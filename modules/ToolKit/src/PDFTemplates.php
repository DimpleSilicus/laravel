<?php

/**
 * This middleware run after compleation of all other middleware.
 *
 * @name       PDFTemplates
 * @category   Middleware
 * @package    Toolkit
 * @author     Vivek Kale <vivek.kale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */

namespace Modules\ToolKit;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Modules\PDFTemplates\Model\PDFTemplate;
use mikehaertl\wkhtmlto\Pdf;

/**
 * PDFTemplates class to add / edit / delete PDF Templates
 *
 * @name       PDFTemplates.php
 * @category   PDFTemplate
 * @package    PDFTemplate
 * @author     Vivek Kale <vivek.kale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id: 617aad48ff59b42d2b47fd72bac931e80d0f2e0a $
 * @link       None
 * @filesource
 */
class PDFTemplates
{

    /**
     *  Crates pdf file for respective template id
     *
     * @name   makePDF
     * @access public
     * @author Vivek Kale <vivek.kale@silicus.com>
     *
     * @param Request $templateId templateId details
     * @param Request $data       data details
     *
     * @return void
     */
    static function makePDF($templateId, $data)
    {
        $templateDetails  = PDFTemplate::find($templateId);
        $abbreviations    = explode(',', $templateDetails->abbreviations);
        $templateContents = $templateDetails->content;
        $cnt              = count($abbreviations);

        $binaryPath  = Config::get('pdftemplate.BINARY_PATH');
        $orientation = Config::get('pdftemplate.PDF_TEMPLATES.ORIENTATION');
        $pageSize    = Config::get('pdftemplate.PDF_TEMPLATES.PAGE_SIZE');

        for ($i = 0; $i < $cnt; $i++) {
            foreach ($data as $key => $dataList) {
                if ($abbreviations[$i] == '@!!' . $key . '!!@') {
                    $templateContents = str_replace($abbreviations[$i], $dataList, $templateContents);
                }
            }
        }

        $pdf           = new Pdf([
            'commandOptions' => [
                'useExec'     => true,
                'escapeArgs'  => false,
                'procOptions' => array (
                    // This will bypass the cmd.exe which seems to be recommended on Windows
                    'bypass_shell'    => true,
                    // Also worth a try if you get unexplainable errors
                    'suppress_errors' => true,
                ),
            ],
        ]);
        $globalOptions = array (
            'no-outline', // Make Chrome not complain
            // Default page options
            'page-size'          => $pageSize,
            'no-pdf-compression' => '',
            'orientation'        => $orientation,
        );
        $pdf->setOptions($globalOptions);
        $pdf->addPage($templateContents);
        $pdf->binary   = $binaryPath; // set the binary wkhtmltopdf path
        $fileName      = $templateDetails->name . '_' . time();
        //$pdf->saveAs('pdf_templates/' . $fileName . '.pdf'); // to download pdf file
        if (!$pdf->send()) {
            throw new Exception('Could not create PDF: ' . $pdf->getError());
        }
    }

}
