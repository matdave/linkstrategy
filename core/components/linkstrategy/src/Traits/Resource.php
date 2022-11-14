<?php

namespace LinkStrategy\Traits;

use LinkStrategy\Model\Links;
use LinkStrategy\Model\ResourceLinks;
use MODX\Revolution\modResource;
use MODX\Revolution\modX;
use voku\helper\HtmlDomParser;

trait Resource
{
    protected modX $modx;
    protected modResource $resource;

    public function processLinks()
    {
        $this->modx->switchContext($this->resource->context_key);
        $content = $this->resource->getContent();
        $this->findLinks($content);

        // Check for links that may be hidden by element tags
        $maxIterations = 10;
        $this->modx->resource = $this->resource;
        $this->modx->resourceIdentifier = $this->resource->id;
        $this->modx->elementCache = [];
        $this->modx->parser->processElementTags('', $content, false, false, '[[', ']]', [], $maxIterations);
        $this->modx->parser->processElementTags('', $content, true, false, '[[', ']]', [], $maxIterations);
        $this->modx->parser->processElementTags('', $content, true, true, '[[', ']]', [], $maxIterations);
        $this->findLinks($content);
    }

    protected function findLinks($content)
    {
        $dom = HtmlDomParser::str_get_html($content);
        $anchors = $dom->findMulti('a');
        foreach ($anchors as $anchor) {
            $href = $anchor->getAttribute('href');
            $this->addLink($href);
        }
    }

    protected function addLink($href): void
    {
        $basePath = rtrim($this->modx->getOption('base_path'), '/');

        if (empty($href)) {
            return;
        }

        // ignore files
        $path = trim($href, "'");
        $path = ltrim($path, $this->modx->getOption('base_url'));
        $path = ltrim($path, '/');
        $path = '/' . $path;
        if (is_file($basePath . $path)) {
            return;
        }

        // ignore tags
        $matches = [];
        $tagsFound = $this->modx->getParser()->collectElementTags($href, $matches);
        if ($tagsFound > 0) {
            return;
        }

        $link = [
            'context_key' => '',
            'internal' => false,
            'resource' => 0
        ];

        $scheme = parse_url($href, PHP_URL_SCHEME);
        $host = parse_url($href, PHP_URL_HOST);
        $path = parse_url($href, PHP_URL_PATH);
        $httpHost = $this->modx->getOption('http_host');
        // @TODO expand for multi-context sites
        if (!$host || $host === $httpHost) {
            $link['internal'] = true;
        } else {
            $href = $scheme . '://' . $host . $path;
            $link['url'] = $href;
        }
        if ($link['internal']) {
            $path = ltrim($path, '/');
            $resourceQuery = ($path) ? ['uri' => $path] : $this->modx->getOption('site_start');
            $resource = $this->modx->getObject(modResource::class, $resourceQuery);
            if ($resource) {
                $link['context_key'] = $resource->context_key;
                $link['resource'] = $resource->id;
            }
            $link['uri'] = $path;
        } else {
            $link['uri'] = $path;
        }

        $ls = $this->modx->getObject(Links::class, $link);
        if (empty($ls)) {
            $ls = $this->modx->newObject(Links::class);
            $ls->fromArray($link);
        }
        $ls->set('url', str_replace($httpHost, '{http_host}', $href));
        $ls->save();
        $links = $this->modx->newObject(ResourceLinks::class);
        $links->set('resource', $this->resource->id);
        $links->set('link', $ls->id);
        $links->save();
    }
}
