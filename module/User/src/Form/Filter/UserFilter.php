<?php

namespace User\Form\Filter;

use Zend\InputFilter\Input;
use Zend\Validator\NotEmpty;
use Zend\Db\Adapter\Adapter;
use Zend\Validator\Identical;
use Zend\Validator\StringLength;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Db\NoRecordExists;

class UserFilter extends InputFilter
{
    public function __construct(Adapter $adapter)
    {
        $name = new Input('name');
        $name->setRequired(true)
            ->getFilterChain()
            ->attachByName('stringtrim')
            ->attachByName('StripTags');

        $name->getValidatorChain()
            ->attach(new NotEmpty())
            ->attach(new StringLength(['max' => 120]));

        $this->add($name);

        $email = new Input('email');
        $email->setRequired(true)
            ->getFilterChain()
            ->attachByName('stringtrim')
            ->attachByName('StripTags');

        $email->getValidatorChain()
            ->attach(new NotEmpty())
            ->attach(new StringLength(['max' => 255]))
            ->attach(new NoRecordExists([
                'table' => 'users',
                'field' => 'email',
                'adapter' => $adapter,
                'messages' => [
                    'recordFound' => 'Este e-mail já está em uso',
                ],
            ]));

        $this->add($email);

        $password = new Input('password');
        $password->setRequired(true)
            ->getFilterChain()
            ->attachByName('stringtrim')
            ->attachByName('StripTags');

        $password->getValidatorChain()
            ->attach(new NotEmpty())
            ->attach(new StringLength(['max' => 48, 'min' => 5]))
            ->attach(new Identical([
                'token' => 'verifyPassword',
                'messages' => [
                    'notSame' => 'As senhas fornecidas devem ser iguais',
                ],
            ]));

        $this->add($password);

        $verifyPassword = new Input('verifyPassword');
        $verifyPassword->setRequired(true)
            ->getFilterChain()
            ->attachByName('stringtrim')
            ->attachByName('StripTags');

        $verifyPassword->getValidatorChain()
            ->attach(new NotEmpty())
            ->attach(new StringLength(['max' => 48, 'min' => 5]));

        $this->add($verifyPassword);
    }
}
