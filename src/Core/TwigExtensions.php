<?php

namespace App\Core;

use App\Manager\SocialManager;
use App\Services\Session;
use Symfony\Component\Yaml\Yaml;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

final class TwigExtensions extends AbstractExtension
{
    /** @var mixed */
    private $config;
    /** @var Session */
    private Session $session;

    public function __construct()
    {
        $this->config  = Yaml::parseFile(CONF_DIR . '/config.yml');
        $this->session = new Session();
    }

    /**
     * @return array|TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('asset', [$this, 'getAssetPath']),
        ];
    }
}