<?php

namespace LinkStrategy\Traits;

use voku\helper\HtmlDomParser;

trait Resource
{
    /**
     * A reference to the modX object.
     * @var \modX $modx
     */
    public $modx = null;

    /**
     * The modResource Class.
     * @var object $resource
     */
    protected $resource;

    public function processLinks()
    {
        require_once( MODX_CORE_PATH. '/model/modx/modrequest.class.php');
        $this->modx->switchContext($this->resource->context_key);
        $this->modx->resource = $this->resource;
        $this->modx->resourceIdentifier = $this->resource->id;
        $this->modx->elementCache = [];
        $this->modx->request = new \modRequest($this->modx, [], [], [], []);
        $this->modx->resource->prepare();
        $this->findLinks($this->modx->resource->_output);
    }

    protected function findLinks($content)
    {
        $dom = HtmlDomParser::str_get_html($content);
        $anchors = $dom->findMulti('a');
        $linkTexts = [];
        foreach ($anchors as $anchor) {
            $href = $anchor->getAttribute('href');
            $text = $anchor->innertext;
            $text = strip_tags($text);
            if (empty($text)) {
                $text = $anchor->title;
            }
            $text = substr(trim($text), 0, 255);
            $linkTextId = $this->addLink($href, $text);
            if ($linkTextId) {
                $linkTexts[] = $linkTextId;
            }
        }
        $this->modx->removeCollection('ResourceLinksText', [
            'resource' => $this->resource->id,
            'id:NOT IN' => $linkTexts
        ]);
    }

    protected function addLink($href, $text)
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
            $resource = $this->modx->getObject('modResource', $resourceQuery);
            if ($resource) {
                $link['context_key'] = $resource->context_key;
                $link['resource'] = $resource->id;
            }
            $link['uri'] = $path;
        } else {
            $link['uri'] = $path;
        }

        $ls = $this->modx->getObject('Links', $link);
        if (empty($ls)) {
            $ls = $this->modx->newObject('Links');
            $ls->fromArray($link);
        }
        $ls->set('url', str_replace($httpHost, '{http_host}', $href));
        $ls->save();
        $links = $this->modx->getObject('ResourceLinks', ['resource' => $this->resource->id, 'link' => $ls->id]);
        if (empty($links)) {
            $links = $this->modx->newObject('ResourceLinks');
            $links->set('resource', $this->resource->id);
            $links->set('link', $ls->id);
            $links->save();
        }
        $linksText = $this->modx->getObject('ResourceLinksText', [
            'resource' => $this->resource->id,
            'link' => $ls->id,
            'text' => $text
        ]);
        if (empty($linksText)) {
            $linksText = $this->modx->newObject('ResourceLinksText');
            $linksText->set('resource', $this->resource->id);
            $linksText->set('link', $ls->id);
            $linksText->set('text', $text);
            if ($linksText->save()) {
                $this->modx->log(\modX::LOG_LEVEL_INFO, 'Added link text: ' . $text);
            }
        }
        return $linksText->id;
    }

    public function clearResourceLinks(): void
    {
        $this->modx->removeCollection('ResourceLinks', [
            'resource' => $this->resource->id
        ]);
    }
}
