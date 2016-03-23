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
    protected $image;
    protected $trim = true;
    protected $refresh = false;
    protected $alternate = false;
    protected $disableEmoji = false;

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
     * @return $this
     */
    public function setImage($image) {
        $this->image = $image;
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
     *
     */
    public function format() {
        $string = $this->text;

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

        if($this->disableEmoji) {
            if (!$this->usedPipe) {
                $string .= '|';
                $this->usedPipe = true;
            }

            $string .= ' emojize=false';
        }

        if($this->image) {
            if (!$this->usedPipe) {
                $string .= '|';
                $this->usedPipe = true;
            }

            if(is_file($this->image)) {
                $this->image = base64_encode(file_get_contents($this->image));

                $string .= ' image='.$this->image;
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

        if($withDivide) {
            echo "\n---\n";
        } else {
            echo "\n";
        }
    }
}