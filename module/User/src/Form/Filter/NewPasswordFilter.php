<?php

namespace User\Form\Filter;

use Zend\InputFilter\Input;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;
use Zend\InputFilter\InputFilter;

class NewPasswordFilter extends InputFilter
{
    public function __construct()
    {
        $email = new Input('email');
        $email->setRequired(true)
            ->getFilterChain()
            ->attachByName('stringtrim')
            ->attachByName('StripTags');

        $email->getValidatorChain()
            ->attach(new NotEmpty())
            ->attach(new StringLength(['max' => 255]));

        $this->add($email);
    }
}
