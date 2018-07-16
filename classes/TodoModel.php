<?php
class TodoModel
{
    protected $id;
    protected $text;
    protected $crossed_out = 0;

    public function __construct(array $data)
    {
        if (isset($data['id'])) {
            $this->id = $data['id'];
        }
        $this->text = $data['text']; // required
        if (isset($data['id'])) {
            $this->crossed_out = $data['crossed_out'];
        }
    }
    public function getId()
    {
        return $this->id;
    }
    public function getText()
    {
        return $this->text;
    }
    public function setText($text)
    {
        $this->text = $text;
    }
    public function getCrossedOut()
    {
        return $this->crossed_out;
    }
    public function setCrossedOut($crossed_out)
    {
        $this->crossed_out = $crossed_out;
    }
}
