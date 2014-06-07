<?php
$elements = array(
    'acronym' => array(
        'type' => 'text',
        'label' => 'Nickname:',
        'required' => true,
        'validation' => array('not_empty')
    ),
    'name' => array(
        'type' => 'text',
        'label' => 'Your name:',
        'required' => true,
        'validation' => array('not_empty')
    ),
    'password' => array(
        'type' => 'password',
        'required' => true,
        'validation' => array('not_empty')
    ),
    'email' => array(
        'type' => 'email',
        'required' => true,
        'validation' => array('not_empty')
    ),

    'birthday' => array(
        'type' => 'text',
        'required' => true,
        'validation' => array('not_empty')
    ),
    'add' => array(
        'type' => 'submit',
        'value' => 'Signup',
        'callback' => function($form) {
                return true;
            }
    ),

);


$form = new \Mos\HTMLForm\CForm(array(), $elements);