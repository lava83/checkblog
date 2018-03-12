<?php
/**
 * Created by PhpStorm.
 * User: stefanriedel
 * Date: 12.03.18
 * Time: 09:53
 */

namespace Core;


use Exceptions\ViewException;

class View
{

    protected $templateName = null;

    protected $data = [];

    protected static $globalData = [];

    /**
     * View constructor.
     * @param null $templateName
     * @param array $data
     */
    public function __construct($templateName = null, $data = [])
    {
        if (!empty($templateName)) {
            $this->setTemplateName($templateName);
        }
        if (!empty($data)) {
            $this->setData($data);
        }
    }

    /**
     * @return string
     */
    public function getTemplateName(): string
    {
        return $this->templateName;
    }

    /**
     * @param string $templateName
     */
    public function setTemplateName(string $templateName): void
    {
        $this->templateName = $templateName;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function assign($variable, $value)
    {
        $this->data[$variable] = $value;
    }

    public function assignGlobal($variable, $value)
    {
        static::$globalData[$variable] = $value;
    }

    /**
     * @throws ViewException
     */
    public function render(): void
    {
        if (empty($this->templateName)) {
            throw new ViewException('The template name is empty.');
        }
        foreach (Config::get('view.paths') as $viewPath) {
            $templatePath = $viewPath . DIRECTORY_SEPARATOR . $this->templateName;
            if (is_file($templatePath)) {
                extract(static::$globalData);
                extract($this->data);
                require_once $templatePath;
                break;
            }
        }
    }
}