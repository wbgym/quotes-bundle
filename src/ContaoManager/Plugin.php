<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
 */

/**
 * Wbgym/ApiBundle
 *
 * @author Webteam WBGym <webteam@wbgym.de>
 * @package Quotes Bundle
 * @license LGPL-3.0+
 */

namespace Wbgym\QuotesBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Wbgym\QuotesBundle\WbgymQuotesBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;

/**
 * Plugin for the Contao Manager.
 */
class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(WbgymQuotesBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class])
                ->setReplace(['LSP'])
        ];
    }
}