<?php

namespace Svea\Checkout\Model;

class Gui
{
    /**
     * @var string $layout
     */
    private $layout;

    /**
     * @var string $snippet
     */
    private $snippet;

    /**
     * @return string
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * @param string $layout
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    /**
     * @return string
     */
    public function getSnippet()
    {
        return $this->snippet;
    }

    /**
     * @param string $snippet
     */
    public function setSnippet($snippet)
    {
        $this->snippet = $snippet;
    }
}
