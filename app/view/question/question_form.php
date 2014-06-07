<?php



$elements = array(
    'title' => array(
        'type' => 'text',
        'label' => 'title (max 20 characters):',
        'required' => true,
        'validation' => array('not_empty')
    ),
    'content' => array(
        'type' => 'textarea',
        'label' => 'content',
        'required' => true,
        'validation' => array('not_empty')
    ),
    'acronym' => array(
        'type' => 'text',
        'required' => true,
        'value' => count($this->session->get('user_info') > 0) ? $this->session->get('user_info')['acronym'] : 'name',
        'validation' => array('not_empty')
    ),


);


$form = new \Mos\HTMLForm\CForm(array(), $elements);