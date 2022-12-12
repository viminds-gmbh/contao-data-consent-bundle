<?php

/**
 * Qbus Data Consent Integration for Contao
 *
 * @author  Alex Wuttke <alw@qbus.de>
 * @license LGPL-3.0+
 */

namespace Qbus\DataConsentBundle\Controller;

use Contao\FrontendTemplate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/iframe-placeholder")
 */
class IframePlaceholderController extends AbstractController
{
    /**
     * @Route("/lang/{lang}", name="index")
     */
    public function indexAction($lang, Request $request)
    {
        $this->container->get('contao.framework')->initialize();

        $url = $request->query->get('original-url');
        $escapedUrl = \htmlspecialchars($url);
        $parsed = \parse_url($url);
        $escapedHost = \htmlspecialchars($parsed['host']);
        $type = 'marketing';

        $title = 'Content';
        if ($escapedHost === 'www.youtube.com' || $escapedHost === 'player.vimeo.com') {
            $title = 'Video';
        }

        $params = [
            'url' => $url,
            'host' => $parsed['host'],
            'type' => $type,
            'title' => $title,
            'lang' => $lang
        ];

        $template = new FrontendTemplate('dataconsent_iframePlaceholder');
        $template->setData($params);

        $response = new Response($template->parse());
        $response->headers->set('X-Robots-Tag', 'noindex');

        return $response;
    }
}
