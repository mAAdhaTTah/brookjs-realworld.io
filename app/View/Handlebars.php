<?php

namespace App\View;

use Exception;
use LightnCandy\LightnCandy;
use Psr\Http\Message\ResponseInterface;

class Handlebars
{
    /**
     * Path to client dir.
     *
     * @var string
     */
    private $client;

    /**
     * Handlebars constructor.
     *
     * @param string $client
     */
    public function __construct(string $client)
    {
        $this->client = $client;
        $this->helpers = [
            'json' => function ($args) {
                return json_encode($args);
            }
        ];
    }

    /**
     * Renders the provided template with a given context.
     *
     * @param string $template
     * @param array  $context
     *
     * @return mixed
     * @throws Exception
     */
    public function fetch(string $template, array $context = []) : string
    {
        $phpStr = LightnCandy::compile(file_get_contents($this->client . $template . '.hbs'), [
            'flags' => LightnCandy::FLAG_HANDLEBARSJS_FULL | LightnCandy::FLAG_RUNTIMEPARTIAL,
            'partialresolver' => function ($cx, $name) {
                $filename = $this->client . $name . '.hbs';

                if (file_exists($filename)) {
                    return file_get_contents($filename);
                }

                return "[partial (file:$filename) not found]";
            },
            'helpers' => $this->helpers,
        ]);

        // @todo swap out deprecated prepare for custom solution
        $render = LightnCandy::prepare($phpStr);

        if (!($render instanceof \Closure)) {
            throw new Exception('Invalid PHP generated. Check Handlebars template for invalid syntax.');
        }

        return $render($context);
    }

    /**
     * Renders the provided Handlebars template string with a given context.
     *
     * @param string $string
     * @param array  $context
     *
     * @return mixed
     * @throws Exception
     */
    public function fetchFromString(string $string = '', array $context = []) : string
    {
        $phpStr = LightnCandy::compile($string, [
            'flags' => LightnCandy::FLAG_HANDLEBARSJS_FULL | LightnCandy::FLAG_RUNTIMEPARTIAL,
            'partialresolver' => function ($cx, $name) {
                $filename = $this->client . $name . '.hbs';

                if (file_exists($filename)) {
                    return file_get_contents($filename);
                }

                return "[partial (file:$filename) not found]";
            },
            'helpers' => $this->helpers,
        ]);

        // @todo swap out deprecated prepare for custom solution
        $render = LightnCandy::prepare($phpStr);

        if (!($render instanceof \Closure)) {
            throw new Exception('Invalid PHP generated. Check Handlebars template for invalid syntax.');
        }

        return $render($context);
    }

    /**
     * Write the rendered template with the given context to the a Response.
     *
     * @param ResponseInterface $response
     * @param string            $template
     * @param array             $context
     *
     * @return ResponseInterface
     */
    public function render(
        ResponseInterface $response,
        string $template,
        array $context = []
    ) {
        $response->getBody()->write($this->fetch($template, $context));

        return $response;
    }
}