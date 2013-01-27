<?php

/**
 * FormGenerator class
 * Classe per generare in modo dinamico tutti
 * gli input in formato HTML.
 * 
 * @filesource FormGenerator.php
 * @author Vecchio Concetto
 * @copyright 2013
 * @version 2.0
 */
class FormGenerator {

    /**
     * Controllo che esiste l'array
     * @param type $data
     * @return boolean 
     */
    private function checkArray($data) {
        if (empty($data)) return false;
    }

    /**
     * Appendo gli attributi ad ogni input
     * 
     * @param type $fields
     * @param type $values
     * @return type 
     */
    private function appendAttribute($fields, $values) {
        $i = 1;
        while ($fields[$i]) {
            $string .= sprintf('%s="%s" ', $fields[$i], $values[$i]);
            $i++;
        }
        return $string;
    }

    /**
     * Imposto il label prima di ogni input
     * 
     * @param type $label
     * @return type 
     */
    private function setLabel($label) {
        return sprintf("<label>%s</label>\n", $label);
    }

    /**
     * E' possibile assegnare un valore di default
     * per gli input "radio" oppure i "checkbox"
     * 
     * @param type $checked
     * @param type $key
     * @return type 
     */
    private function checkedInput($checked, $key) {
        if ($checked == $key) {
            return sprintf('checked="checked"');
        }
    }

    /**
     * Con l'attributo "selected" si pu˜ indicare una scelta predefinita
     * 
     * @param type $selected
     * @param type $key
     * @return type 
     */
    private function selectedOption($selected, $key) {
        if ($selected == $key) {
            return sprintf(' selected="selected"');
        }
    }

    /**
     * Genero gli input in HTML
     * 
     * @param type $data
     * @return boolean 
     */
    public function createInput($data = array()) {
    	
        // controllo che esiste l'array
        $this->checkArray($data);

        /**
         * elimino dell'array gli attributi
         * non ammessi per l'input
         */
        unset($data['radio']);
        unset($data['checked']);

        // recupero il nome / valore degli attributi
        $fields = array_keys($data);
        $values = array_values($data);

        // aggiungo il tag label
        $string = $this->setLabel($data['label']);
        $string .= sprintf("<p><input ");
        $string .= $this->appendAttribute($fields, $values);
        $string .= sprintf("/></p>\n");
        return $string;
    }

    /**
     * Genero gli input in HTML
     * Consentire delle scelte (checkbox, radio)
     * 
     * @param type $data
     * @return boolean 
     */
    public function createRadioChecked($data = array()) {
    	
        // controllo che esiste l'array
        $this->checkArray($data);

        /**
         * @var $value
         * recupero il "value" come array
         * da passare ad ogni input radio/checkbox
         */
        $value = $data['value'];

        /**
         * @var $checked
         * recuperare il valore selezionato dell'input
         */
        $checked = $data['checked'];

        /**
         * elimino dell'array gli attributi
         * non ammessi per l'input
         */
        unset($data['value']);
        unset($data['checked']);

        // recupero il nome / valore degli attributi
        $fields = array_keys($data);
        $values = array_values($data);

        // aggiungo il tag label
        $string = $this->setLabel($data['label']);

        $string .= sprintf("<p>");
        foreach ($value as $key => $val) {
            $string .= sprintf("<input ");
            $string .= $this->appendAttribute($fields, $values);
            $string .= $this->checkedInput($checked, $key);
            $string .= sprintf("/> %s<br />\n", $val);
        }
        $string .= sprintf("</p>\n");
        return $string;
    }

    /**
     * Genero le textarea HTML
     * 
     * @param type $data
     * @return boolean 
     */
    public function createTextarea($data = array()) {
    	
        // controllo che esiste l'array
        $this->checkArray($data);

        // recupero il "value" per la Textarea
        $value = $data['value'];

        /**
         * elimino dell'array gli attributi
         * non ammessi per la Textarea
         */
        unset($data['type']);
        unset($data['value']);

        // recupero il nome / valore degli attributi
        $fields = array_keys($data);
        $values = array_values($data);

        // aggiungo il tag label
        $string = $this->setLabel($data['label']);
        $string .= sprintf("<p><textarea ");
        $string .= $this->appendAttribute($fields, $values);
        $string .= sprintf(">%s</textarea></p>\n", $value);
        return $string;
    }

    /**
     * Genero le select HTML
     * 
     * @param type $data
     * @return boolean 
     */
    public function createSelect($data = array()) {
    	
        // controllo che esiste l'array
        $this->checkArray($data);

        /**
         * @var $value
         * recupero il "value" come array
         * da passare ad ogni option della select
         */
        $value = $data['value'];

        /**
         * @var $selected
         * recuperare il valore selezionato della select
         */
        $selected = $data['selected'];

        /**
         * elimino dell'array gli attributi
         * non ammessi per la Select
         */
        unset($data['type']);
        unset($data['value']);
        unset($data['selected']);

        // recupero il nome / valore degli attributi
        $fields = array_keys($data);
        $values = array_values($data);

        // aggiungo il tag label
        $string = $this->setLabel($data['label']);
        $string .= sprintf("<p><select ");
        $string .= $this->appendAttribute($fields, $values);
        $string .= sprintf(">\n");
        $string .= sprintf('<option value="%s">%s</option>%s', '', '-', "\n");
        foreach ($value as $key => $val) {
            $sel = $this->selectedOption($selected, $key);
            $string .= sprintf('<option value="%s"%s>%s</option>%s', $key, $sel, $val, "\n");
        }
        $string .= sprintf("</select></p>\n");
        return $string;
    }

    /**
     * Genero il form HTML
     * con i rispettivi input / select
     * 
     * @param type $data
     * @return boolean 
     */
    public function createForm($data = array()) {
    	
        // controllo che esiste l'array
        $this->checkArray($data);

        /**
         * @var $string
         * creo la stringa HTML del form
         */
        $string = "";

        /**
         * @var $filed
         * recuperare i campi dell'array
         * per iniziare a creare i vari Input
         */
        $filed = $data['field'];

        foreach ($filed as $input) {

            /**
             * switch in base al type
             * per ogni input
             */
            switch ($input['type']) {

                /**
                 * input
                 */
                case 'text':
                case 'file':
                case 'hidden':
                case 'button':
                case 'submit':
                case 'email':
                case 'password':
                    $string .= $this->createInput($input);
                    break;

                /**
                 * checkbox
                 * radio
                 */
                case 'checkbox':
                case 'radio':
                    $string .= $this->createRadioChecked($input);
                    break;

                /**
                 * textarea
                 */
                case 'textarea':
                    $string .= $this->createTextarea($input);
                    break;

                /**
                 * select
                 */
                case 'select':
                    $string .= $this->createSelect($input);
                    break;
            }
        }
        
        if (!empty($string)) {
            return $string;
        }
    }

}
