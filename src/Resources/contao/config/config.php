<?php

/**
 * Qbus Data Consent Integration for Contao
 *
 * @author  Alex Wuttke <alw@qbus.de>
 * @license LGPL-3.0+
 */

$GLOBALS['TL_HOOKS']['outputFrontendTemplate'][] = ['dataconsent.listener.output_frontend_template', 'onOutputFrontendTemplate'];
