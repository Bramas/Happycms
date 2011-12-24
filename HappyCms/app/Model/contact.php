<?php



class Contact extends AppModel

{

    var $name = "contact";

    var $useTable = false;

    var $_schema = array(

        'nom'=> array(

            'type' => 'string',

            'length' => 50

        ),

        'email'=> array(

            'type' => 'string',

            'length' => 150

        ),

        'message'=> array(

            'type' => 'text'

        )

    );

    

    var $validate = array(

        

        'email' => array(

            'rule'=> 'email',

            'required' => true,

            'allowEmpty' => false,

            'message' => "Votre email n'est pas valide"

        )

        ,'message' => array(

            'rule'=> '/\S+/',

            'required' => true,

            'allowEmpty' => false,

            'message' => "Vous devez entrer un message"

        )

        ,'nom' => array(

            'rule'=> '/\S+/',

            'required' => true,

            'allowEmpty' => false,

            'message' => "Vous devez entrer un nom"

        )

        ,'objet' => array(

            'rule'=> '/\S+/',

            'required' => false,

            'allowEmpty' => true,

            'message' => "Vous devez entrer un objet"

        )       

    );

}



?>