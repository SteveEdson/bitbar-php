<?php

namespace SteveEdson;

class BitBar {

    public function newLine() {
        return new BitbarLine();
    }

    public function divide() {
        (new BitBarLine())->show();
    }
}

class BitBarLine {
    protected $withinSubMenu = false;
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
    protected $image;
    protected $imageIsTemplate = false;
    protected $trim = true;
    protected $refresh = false;
    protected $alternate = false;
    protected $disableEmoji = false;
    protected $disableAnsi = false;

    /**
     * BitBarLine constructor.
     * @param bool $withinSubMenu
     */
    public function __construct($withinSubMenu = false) {
        $this->withinSubMenu = $withinSubMenu;
    }

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
     * Base 64 encoded image, or path to image
     * @param $image
     * @param bool $isImageTemplate
     * @return $this
     */
    public function setImage($image, $isImageTemplate = false) {
        $this->image = $image;
        $this->imageIsTemplate = $isImageTemplate;
        return $this;
    }

    /**
     * Disable converting :beer: -> Emoji
     * @param $disable
     * @return $this
     */
    public function disableEmoji($disable = true) {
        $this->disableEmoji = $disable;
        return $this;
    }

    /**
     * Create a sub menu
     *
     * @return BitBarSubMenu
     */
    public function addSubMenu() {
        $this->show(false);
        return new BitBarSubMenu();
    }

    /**
     * Disable converting :beer: -> Emoji
     * @param $disable
     * @return $this
     */
    public function disableAnsi($disable = true) {
        $this->disableAnsi = $disable;
        return $this;
    }

    /**
     *
     */
    public function format() {
        if($this->withinSubMenu) {
            $string = '-- ' . $this->text;
        } else {
            $string = $this->text;
        }

        $this->usedPipe = false;

        if ($this->fontSize) {
            if (!$this->usedPipe) {
                $string .= '|';
                $this->usedPipe = true;
            }

            $string .= ' size=' . $this->fontSize;
        }


        if ($this->fontFace) {
            if (!$this->usedPipe) {
                $string .= '|';
                $this->usedPipe = true;
            }

            $string .= ' font=' . $this->fontFace;
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

        if($this->disableEmoji) {
            if (!$this->usedPipe) {
                $string .= '|';
                $this->usedPipe = true;
            }

            $string .= ' emojize=false';
        }

        if($this->disableAnsi) {
            if (!$this->usedPipe) {
                $string .= '|';
                $this->usedPipe = true;
            }

            $string .= ' ansi=false';
        }

        if($this->image) {
            if (!$this->usedPipe) {
                $string .= '|';
                $this->usedPipe = true;
            }

            // If file exists on system, or is a url
            if(is_file($this->image) || !filter_var($this->image, FILTER_VALIDATE_URL) === false) {
                $this->image = base64_encode(file_get_contents($this->image));
            }

            if($this->imageIsTemplate) {
                $string .= ' templateImage="' . $this->image . '"';
            } else {
                $string .= ' image="' . $this->image . '"';
            }
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

        if(!$this->withinSubMenu && $withDivide) {
            echo "\n---\n";
        } else {
            echo "\n";
        }
    }
}

class BitBarSubMenu {
    public function newLine() {
        return new BitbarLine(true);
    }
}