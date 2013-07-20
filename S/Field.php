<?php
namespace S;
class Field
{
    use \S\ScopesSupport;

    public $meta;
    protected $data = null;

    public function setData($data)
    {
        $this->data = $data;
        $this->setDataChanged();
    }

    public function getData()
    {
        return $this->data;
    }

    /**
     *
     */
    public function validate()
    {
        $errors = [];
        /** @var \S\Meta\Validator $validator */
        foreach ($this->meta->getValidatorInstances as $validator) {
            $errors[] = $validator->validate($this->value);
        }
        $this->validationErrors = $errors;
        $this->validationResult = (count($errors) === 0);
        return $errors;
    }

    private $validationResult = null;
    private $validationErrors = null;

    public function isValid()
    {
        if ($this->validationResult === null) {
            $this->validate();
        }
        return $this->validationResult;
    }

    protected function setDataChanged()
    {
        $this->validationResult = null;
    }

}
