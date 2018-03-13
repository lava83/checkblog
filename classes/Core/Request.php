<?php

namespace Core;


class Request
{

    protected $data = [];

    protected $url;

    protected $uri;

    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        $this->initUriAndUrl();
        $this->initData();
    }

    public function isPost()
    {
        return getenv('REQUEST_METHOD') === 'POST';
    }

    public function getAll()
    {
        return $this->data;
    }

    public function get($key, $default = null)
    {
        if (isset($this->data[$key])) {
            return $this->data[$key];
        }
        return $default;
    }

    protected function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function __isset($name)
    {
        return isset($this->data[$name]);
    }

    public function __get($name)
    {
        return $this->get($name);
    }

    protected function initData(): void
    {
        foreach ($_GET as $key => $value) {
            $this->set($key, $value);
        }
        foreach ($_POST as $key => $value) {
            $this->set($key, $value);
        }
    }

    protected function initUriAndUrl(): void
    {
        $parsedUri = parse_url(getenv('REQUEST_URI'));
        if (isset($parsedUri['path'])) {
            $this->uri = $parsedUri['path'];
        } else {
            $this->uri = $parsedUri;
        }
        $https = getenv('HTTPS');
        $this->url = ($https ? 'https' : 'http') . '://' . getenv('HTTP_HOST') . $this->uri;
    }


}