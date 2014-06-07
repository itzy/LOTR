<?php
$elements = array(
    'acronym' => array(
        'type' => 'text',
        'label' => 'Nickname:',
        'value' =>  $thisUser['acronym'],
        'required' => true,
        'validation' => array('not_empty')
    ),
    'name' => array(
        'type' => 'text',
        'label' => 'Your name:',
        'value' =>  $thisUser['name'],
        'required' => true,
        'validation' => array('not_empty')
    ),
    'email' => array(
        'type' => 'email',
        'value' =>  $thisUser['email'],
        'required' => true,
        'validation' => array('not_empty')
    ),

    'birthday' => array(
        'type' => 'text',
        'value' =>  $thisUser['birthday'],
        'required' => true,
        'validation' => array('not_empty')
    ),

    'content' => array(
        'type' => 'textarea',
        'value' =>  count($thisUser['content'] > 0) ? $thisUser['content'] : 'name',
    ),

    'update' => array(
        'type' => 'submit',
        'value' => 'Update',
        'callback' => function($form) {
                return true;
            }
    ),

);


$form = new \Mos\HTMLForm\CForm(array(), $elements);