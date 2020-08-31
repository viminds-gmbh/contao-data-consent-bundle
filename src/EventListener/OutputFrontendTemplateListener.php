<?php

/**
 * Qbus Data Consent Integration for Contao
 *
 * @author  Alex Wuttke <alw@qbus.de>
 * @license LGPL-3.0+
 */

namespace Qbus\DataConsentBundle\EventListener;

use Contao\FrontendTemplate;

class OutputFrontendTemplateListener
{
    public function onOutputFrontendTemplate($content, $template)
    {
        return $this->setIframePlaceholder($content);
    }

    protected function setIframePlaceholder($content)
    {
        global $objPage;

        $lang = $objPage->rootLanguage ?: 'en';

        $content = \preg_replace_callback(
            '/(<iframe[^>]*) src="([^"]*)"/i',
            function ($matches) use ($lang) {
                return sprintf(
                    '%s src="iframe-placeholder/lang/%s?original-url=%s" data-src="%s"',
                    $matches[1],
                    \rawurlencode($lang),
                    \rawurlencode($matches[2]),
                    $matches[2]
                );
            },
            $content
        );

        return $content;
    }
}
