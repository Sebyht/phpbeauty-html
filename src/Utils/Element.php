<?php

namespace Beauty\Utils;

abstract class Element implements ElementInterface
{
    protected array $attributes = [
        "bool" => [],
        "normal" => [] 
    ];

    protected array $contents = [];

    private array $attributesIgnored = [];

    protected string $tag;

    protected $autoCloseTag = false;

    protected $secure = true;

    public function canEdit(string $dataType = "text"): ElementInterface
    {
        $this->Addattribute("contenteditable", "true");

        return $this->Addattribute("inputmode", $dataType);
    }

    public function withAccessibility(string $name, string $value): ElementInterface
    {
        if (strpos($name, "aria-") !== 0) {
            $name = "data-" . $name;
        }

        return $this->Addattribute($name, $value);
    }

    public function withBoolAttribute(string $attribute): ElementInterface
    {
        return $this->Addattribute($attribute);
    }

    public function withClass(string ...$class): ElementInterface
    {
        return $this->Addattribute("class", implode(" ", $class));
    }

    public function withData(string $name, string $value): ElementInterface
    {
        if (strpos($name, "data-") !== 0) {
            $name = "data-" . $name;
        }

        return $this->Addattribute($name, $value);
    }

    public function withEvent(string $name, string $value): ElementInterface
    {
        return $this->Addattribute($name, $value);
    }

    public function withID(string $id): ElementInterface
    {
        return $this->Addattribute("id", $id);
    }

    public function withLang(string $lang): ElementInterface
    {
        return $this->Addattribute("lang", $lang);
    }

    public function unsecureContent(): ElementInterface
    {
        $this->secure = false;

        return $this;
    }

    public function __toString()
    {
        $html = "<" . $this->tag . " " . $this->getAttributes();

        if ($this->autoCloseTag) {
            return $html . "/>";
        }

        $html = rtrim($html) . ">";

        $contents = implode("", $this->contents);

        $html .= $this->secure ? htmlspecialchars($contents) : $contents;

        return $html . "</" . $this->tag . ">";
    }

    protected function Addattribute (string $name, ?string $value = null)
    {
        if ($value !== null) {
            if (!$this->attributeExists($name, $value)) {
                $this->attributes["normal"][$name] = $value;
            } else {
                $this->attributes["normal"][$name] .= " $value";
            }
        } elseif (!$this->attributeExists($name)) {
            $this->attributes['bool'][] = $name;
        }

        return $this;
    }

    protected function attributeExists (string $name, ?string $value = null) : bool
    {
        if (in_array($name, $this->attributesIgnored, true)) {
            return $this;
        }

        if ($value === null) {
            return in_array($name, $this->attributes['bool']);
        }elseif(array_key_exists($name, $this->attributes['normal'])) {
            return strpos($this->attributes['normal'][$name], $value) !== false;
        }

        return false;
    }

    protected function withContent (string $content, bool $reset = false)
    {
        if ($reset) {
            $this->contents = [];
        }

        $this->contents[] = $content;
    }

    protected function ignoreClientAttribute (string $attribute)
    {
        if (!in_array($attribute, $this->attributesIgnored, true)) {
            $this->attributesIgnored[] = $attribute;
        }
    }

    protected function forceAttribute (string $name, ?string $value = null)
    {
        $this->Addattribute($name, $value);

        $this->ignoreClientAttribute($name);
    }

    private function getAttributes ()
    {
        $attributes = "";

        foreach ($this->attributes['normal'] as $name => $value) {
            $value = htmlspecialchars($value, ENT_QUOTES, "UTF-8");
            
            $attributes .= "$name='$value' ";
        }

        foreach ($this->attributes['bool'] as $attribute) {
            $attributes .= $attribute . " ";
        }

        return rtrim($attributes, " ");
    }
}