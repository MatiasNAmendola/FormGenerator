<?php

include 'FormGenerator.php';

$form = array(
    'field' => array(
        1 => array(
            'label' => 'Name',
            'type' => 'text',
            'name' => 'name',
            'value' => ''
        ),
        2 => array(
            'label' => 'E-mail',
            'type' => 'email',
            'name' => 'email',
            'value' => ''
        ),
        3 => array(
            'label' => 'Informazioni',
            'type' => 'textarea',
            'name' => 'info',
            'value' => ''
        ),
        4 => array(
            'label' => 'Sesso',
            'type' => 'select',
            'name' => 'sesso',
            'value' => array(
                1 => 'M',
                2 => 'F'
            ),
            'selected' => 2
        ),
        5 => array(
            'label' => '',
            'type' => 'submit',
            'name' => 'Salva'
        ),
        6 => array(
            'label' => 'Stato',
            'type' => 'checkbox',
            'name' => 'pippo',
            'value' => array(
                1 => 'Attiva account'
            ),
            'checked' => ''
        ),
        7 => array(
            'label' => 'Newsletter',
            'type' => 'radio',
            'name' => 'news',
            'value' => array(
                1 => 'ON',
                2 => 'OFF'
            ),
            'checked' => 2
        )
    )
);

$obj = new FormGenerator();
echo $obj->createForm($form);