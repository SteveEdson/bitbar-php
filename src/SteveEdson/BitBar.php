<?php

namespace SteveEdson;

class BitBar {

    public function newLine() {
        return new BitbarLine();
    }
}

class BitBarLine {
    protected $usedPipe = false;
    protected $text;
    protected $colour;
    protected $url;
    protected $fontSize;
    protected $fontFace;
    protected $length;
    protected $terminal;
    protected $bash;
    protected $dropdown;
    protected $trim = true;
    protected $refresh = false;
    protected $alternate = false;

    /**
     * @param mixed $text
     * @return $this
     */
    public function setText($text) {
        $this->text = $text;
        return $this;
    }

    /**
     * @param $color
     * @return BitBarLine
     */
    public function setColor($color) {
        return $this->setColour($color);
    }

    /**
     * @param mixed $colour
     * @return $this
     */
    public function setColour($colour) {
        $this->colour = $colour;
        return $this;
    }

    /**
     * @param mixed $url
     * @return $this
     */
    public function setUrl($url) {
        $this->url = $url;
        return $this;
    }

    /**
     * @param $length
     * @return $this
     */
    public function setLength($length) {
        $this->length = $length;
        return $this;
    }

    /**
     * @param mixed $fontSize
     * @return $this
     */
    public function setFontSize($fontSize) {
        $this->fontSize = $fontSize;
        return $this;
    }

    /**
     * @param mixed $fontFace
     * @return $this
     */
    public function setFontFace($fontFace) {
        $this->fontFace = $fontFace;
        return $this;
    }

    /**
     * Trim leading/trailing whitespace from the title.
     * @return $this
     */
    public function disableTrim() {
        $this->trim = false;
        return $this;
    }

    /**
     * @param $boolean
     * @return $this
     */
    public function setTerminal($boolean) {
        $this->terminal = (boolean) $boolean;
        return $this;
    }
    
    /**
     * @param mixed text
     * @return $this
     */
    public function setBash($text) {
        $this->bash = $text;
        return $this;
    }

    /**
     * @param $boolean
     * @return $this
     */
    public function setDropdown($boolean) {
        $this->dropdown = (boolean) $boolean;
        return $this;
    }

    /**
     * @param $boolean
     * @return $this
     */
    public function setRefresh($boolean) {
        $this->refresh = (boolean) $boolean;
        return $this;
    }
    
    
    /**
     * @param $boolean
     * @return $this
     */
    public function setAlternate($boolean) {
        $this->alternate = (boolean) $boolean;
        return $this;
    }

    /**
     * @return BitBarLine
     */
    public function enableRefresh() {
        return $this->setRefresh(true);
    }

    /**
     *
     */
    public function format() {
        $string = $this->text;

        $string = EmojiParser::parseText($string);

        $this->usedPipe = false;

        if ($this->fontFace && $this->fontSize) {
            if (!$this->usedPipe) {
                $string .= '|';
                $this->usedPipe = true;
            }

            $string .= ' ( \'size=' . $this->fontSize . '\' \'font=' . $this->fontFace . '\' )';
        }

        if ($this->colour) {
            if (!$this->usedPipe) {
                $string .= '|';
                $this->usedPipe = true;
            }

            $string .= ' color=' . $this->colour;
        }

        if ($this->url) {
            if (!$this->usedPipe) {
                $string .= '|';
                $this->usedPipe = true;
            }

            $string .= ' href=' . $this->url;
        }

        if ($this->trim === false) {
            if (!$this->usedPipe) {
                $string .= '|';
                $this->usedPipe = true;
            }

            $string .= ' trim=false';
        }
        
        if ($this->alternate === true) {
            if (!$this->usedPipe) {
                $string .= '|';
                $this->usedPipe = true;
            }

            $string .= ' alternate=true';
        }

        if ($this->bash) {
            if (!$this->usedPipe) {
                $string .= '|';
                $this->usedPipe = true;
            }

            $string .= ' bash=' . $this->bash;
        }

        if ($this->refresh) {
            if (!$this->usedPipe) {
                $string .= '|';
                $this->usedPipe = true;
            }

            $string .= ' refresh=true';
        }

        if($this->terminal !== null) {
            if (!$this->usedPipe) {
                $string .= '|';
                $this->usedPipe = true;
            }

            $string .= ' terminal='.json_encode($this->terminal);
        }

        if($this->dropdown !== null) {
            if (!$this->usedPipe) {
                $string .= '|';
                $this->usedPipe = true;
            }

            $string .= ' dropdown='.json_encode($this->dropdown);
        }

        if ($this->length) {
            if (!$this->usedPipe) {
                $string .= '|';
                $this->usedPipe = true;
            }

            $string .= ' length=' . $this->length;
        }

        return $string;
    }

    public function show($withDivide = true) {
        echo $this->format();

        if($withDivide) {
            echo "\n---\n";
        } else {
            echo "\n";
        }
    }
}

class EmojiParser {

    protected static $rawEmojiData = null;
    protected static $emoji = null;

    public static function parseText($text) {
        if(self::$rawEmojiData == null) {
            self::$emoji = self::loadEmoji();
        }

        return str_replace(array_keys(self::$emoji), array_values(self::$emoji), $text);
    }

    protected static function loadEmoji() {
        self::$rawEmojiData = json_decode(file_get_contents(__DIR__ . "/../../emoji.json"), true);

        $emojis = array();

        foreach(self::$rawEmojiData as $emoji) {
            $emojis[$emoji['shortname']] = $emoji['unicode'];
        }

        return $emojis;
    }
}
