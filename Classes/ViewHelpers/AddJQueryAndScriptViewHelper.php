<?php
/*                                                                        *
 * This script belongs to the fluid_css extension.                        *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

namespace T3Ext\T3jquery\ViewHelpers;

use T3Ext\T3jquery\Utility\T3jqueryUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

/**
 * ViewHelper which allows to jquery and additional files
 *
 * = Examples =
 *
 * <code title="Simple">
 *   {namespace t3jquery=Tx_T3jquery_ViewHelpers}
 *
 *   <t3jquery:AddJQueryAndScript jsfile="EXT:example/main.js"/>
 * </code>
 * <output>
 *
 * See paramlist for more options, these are oriented on typoscript options
 *
 * </output>
 *
 *
 * @author Kay Strobach <typo3@kay-strobach.de>
 * @license http://www.gnu.org/copyleft/gpl.html
 */

class AddJQueryAndScriptViewHelper extends AbstractTagBasedViewHelper
{
    /**
     * @param string $jsfile
     * @param string $jsurl
     * @param string $jsdata
     * @param string $jsready
     * @param boolean $forceOnTop
     * @param string $compress
     * @param string $type
     * @param boolean $tofooter
     * @param boolean $renderChildrenToData
     * @return string
     */

    public function render($jsfile = null, $jsurl = null, $jsdata = null, $jsready = null, $forceOnTop = null, $compress = null, $type = "text/javascript", $tofooter = null, $renderChildrenToData = false)
    {
        $buffer_data = null;
        $buffer_ready = null;
        if ($renderChildrenToData === true) {
            $buffer_data = $this->renderChildren();
        } else {
            $buffer_ready = $this->renderChildren();
        }
        // checks if t3jquery is loaded
        if (T3JQUERY === true) {
            $config = array();
            if ($jsfile !== null) {
                $config['jsfile'] = $jsfile;
            }
            if ($jsurl !== null) {
                $config['jsurl'] = $jsurl;
            }
            if ($jsdata !== null) {
                $config['jsdata'] = $buffer_data . "\n" . $jsdata;
            } else {
                $config['jsdata'] = $buffer_data;
            }
            if ($jsready !== null) {
                $config['jsready'] = $buffer_ready . "\n" . $jsready;
            } else {
                $config['jsready'] = $buffer_ready;
            }
            if ($forceOnTop !== null) {
                $config['forceOnTop'] = $forceOnTop;
            }
            if ($compress !== null) {
                $config['compress'] = $compress;
            }
            if ($type !== null) {
                $config['type'] = $type;
            }
            if ($tofooter !== null) {
                $config['tofooter'] = $tofooter;
            }
            T3jqueryUtility::addJS('', $config);
        }
        return '';
    }
}
