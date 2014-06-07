<?php
$elements = array(

    'redirect' => array(
        'type' => 'hidden'
    ),

    'acronym' => array(
        'type' => 'text',
        'label' => 'Nickname:',
        'required' => true,
        'validation' => array('not_empty')
    ),
    'password' => array(
        'type' => 'password',
        'label' => 'password',
        'required' => true,
        'validation' => array('not_empty')
    ),

    'login' => array(
        'type' => 'submit',
        'value' => 'Login',
        'callback' => function($form) {
                return true;
            }
    ),

);


$form = new \Mos\HTMLForm\CForm(array(), $elements);