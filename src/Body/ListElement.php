<?php

namespace Beauty\Body;

use Beauty\Utils\Element;
use Beauty\Utils\ElementInterface;

final class ListElement extends Element
{
    private array $items = [];

    public function __construct(array $items, ?string $tag = null)
    {
        if ($tag !== null) {
            $this->tag = $tag;
        } else {
            $this->tag = is_associative($items) ? "ul" : "ol";
        }

        foreach($items as $key => $item) {
            $this->items[$key] = (new Wrapper("li"))->content(ucfirst($item));
        }
    }

    public function linkfor (string $key, string $path, ?string $label = null)
    {
        if (array_key_exists($key, $this->items)) {
            /** @var \Beauty\Body\Wrapper */
            $item = $this->items[$key];

            $link = (new Wrapper("a"))->withAttribute("href", $path);

            $link->content($label ?? $item->getContent());

            $this->items[$key] = $item
            ->resetContent()
            ->withChild($link);
        }

        return $this;
    }

    public function nested (int|string $where, ElementInterface $elements)
    {
        if (array_key_exists($where, $this->items)) {
            /** @var \Beauty\Body\Wrapper */
            $item = $this->items[$where];

            var_dump(strval($elements));

            $item->withChild($elements);

            $this->items[$where] = $item;
        }

        return $this;
    }

    public function __toString()
    {
        $this->secure = false;

        $this->withContent(implode("", $this->items));

        return parent::__toString();
    }
}