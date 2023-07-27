<?php

namespace User\Form;

use Zend\Form\Form;
use Zend\Form\Element\Text;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Email;
use  Zend\Db\Adapter\Adapter;
use Zend\Form\Element\Password;
use User\Form\Filter\UserFilter;

class UserForm extends Form
{
    public function __construct(Adapter $adapter)
    {
        parent::__construct('user', []);

        $this->setInputFilter(new UserFilter($adapter));

        $this->setAttributes(['method' => 'POST']);

        $name = new Text('name');
        $name->setAttributes([
            'placeholder' => 'Full name',
            'class' => 'form-control',
            'maxlength' => 120
        ]);

        $this->add($name);

        $email = new Email('email');
        $email->setAttributes([
            'placeholder' => 'E-mail',
            'class' => 'form-control',
            'maxlength' => 255
        ]);

        $this->add($email);

        $password = new Password('password');
        $password->setAttributes([
            'placeholder' => 'Password',
            'class' => 'form-control',
            'maxlength' => 48
        ]);

        $this->add($password);

        $verifyPassword = new Password('verifyPassword');
        $verifyPassword->setAttributes([
            'placeholder' => 'Retype password',
            'class' => 'form-control',
            'maxlength' => 48
        ]);

        $this->add($verifyPassword);

        $csrf = new Csrf('csrf');
        $csrf->setOptions([
            'csrf_options' => [
                'timeout' => 600,
            ],
        ]);

        $this->add($csrf);
    }
}
