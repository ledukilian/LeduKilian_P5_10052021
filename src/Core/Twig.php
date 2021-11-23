<?php

namespace App\Core;

use App\Exceptions\ConfigException;
use App\Exceptions\TwigException;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Extension\DebugExtension;
use Twig\Extra\Intl\IntlExtension;
use Twig\Loader\FilesystemLoader;
use Twig\Extra\Markdown\DefaultMarkdown;
use Twig\Extra\Markdown\MarkdownRuntime;
use Twig\RuntimeLoader\RuntimeLoaderInterface;
use Twig\Extra\Markdown\MarkdownExtension;
use App\Services\TwigGlobals;
use App\Services\MessageHandler;

class Twig {
    /** @var Environment */
    private $twig;
    /** @var mixed */
    private $config;

    /**
     * Twig constructor.
     * @throws ConfigException
     * @throws LoaderError
     */
   public function __construct() {
     try {
         $this->config = yaml_parse_file(CONF_DIR . '/config.yml');
     } catch (\Exception $e) {
         throw new ConfigException($e->getMessage());
     }

     $loader = new FilesystemLoader(TEMPLATE_DIR);

     $loader->addPath(TEMPLATE_DIR . '/client', 'client');
     $loader->addPath(TEMPLATE_DIR . '/admin', 'admin');

     $twig = new Environment($loader, [
         'debug' => $this->config['env'] === 'dev',
         'cache' => $this->config['env'] === 'dev' ? false : ROOT_DIR . '/var/cache'
     ]);

     $twig->addRuntimeLoader(new class implements RuntimeLoaderInterface {
         public function load($class)
         {
             if (MarkdownRuntime::class === $class) {
                 return new MarkdownRuntime(new DefaultMarkdown());
             }
             return null;
         }
     });

     self::addTwigExtensions($twig);
     self::addTwigGlobals($twig);

     $this->twig = $twig;
   }

   public function addTwigExtensions($twig) {
      $twig->addExtension(new DebugExtension());
      $twig->addExtension(new IntlExtension());
      $twig->addExtension(new MarkdownExtension());
   }

   public function addTwigGlobals($twig) {
      $twig->addGlobal('uri', $_SERVER['REQUEST_URI']);
      $twigGlobals = new TwigGlobals();
      $twig->addGlobal('admin', $twigGlobals->getAdmin());
      $twig->addGlobal('session', $twigGlobals->getSession());
      $twig->addGlobal('socials', $twigGlobals->getSocials());
      $twig->addGlobal('_session', $_SESSION);
      $twig->addGlobal('_post', $_POST);
      $twig->addGlobal('_get', $_GET);
      $messageHandler = new MessageHandler();
      $messageHandler->resetMessages();
   }

    /**
     * @param $template
     * @param $array
     * @return string
     * @throws TwigException
     */
    public function twigRender($template, $array): ?string {
        try {
            return $this->twig->render($template, $array);
        } catch (\Exception $e) {
           echo $e;
           throw new TwigException("Une erreur est survenue pendant le rendu de la page." . $e);
        }
    }
}