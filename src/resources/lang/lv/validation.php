<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    
    'after' => ':attribute ir jābūt datumam pēc :date.',
    'before' => ':attribute ir jābūt datumam pirms :date.',
    'confirmed' => ':attribute un :attribute apstiptinājuma lauki nesakrīt.',
    'date' => ':attribute ir jābūt derīgam datumam.',
    'email' => ':attribute ir jābūt derīgai e-pasta adresei.',
    'integer' => ':attribute lauka vērtībai jābūt veselam skaitlim.',
    'max' => [
        'numeric' => ':attribute ir jābūt mazākam par :max.',
        'string' => ':attribute laukam ir jāsatur mazāk nekā :max simboli.',
    ],
    'min' => [
        'numeric' => ':attribute ir jābūt lielākam par :min.',
        'string' => ':attribute laukam ir jāsatur vismaz :min simboli.',
    ],
    'numeric' => ':attribute ir jābūt skaitlim.',
    'password' => 'The password is incorrect.',
    'required' => ':attribute ir obligāts lauks.',
    'unique' => ':attribute ir jau aizņemts.',
    'date_format' => ':attribute jābūt formatā :format.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    
    
  
   
    
    // 'city'=> 'required|numeric'

    'custom' => [
        'dob' => [
            'before' => 'Jūs neesat pietiekami vecs, lai izmantotu šo lietotni (Minimālais vecums ir 13 gadi).',
            'required' => 'Dzimšanas datums ir obligāts lauks.',
            'date-format'=> '',
        ],
        'name' => [
            'required' => 'Vārds ir obligāts lauks.',
            'max' => 'Vārdam ir jābūt īsākam par 60 simboliem.',
        ],
        'surname' => [
            'required' => 'Uzvārds ir obligāts lauks.',
            'max' => 'Uzvārdam ir jābūt īsākam par 90 simboliem.',
        ],
        'email' => [
            'email' => 'E-pasta adresei ir jābūt derīgai.',
            'required' => 'E-pasta adrese ir obligāts lauks.',
            'max' => 'E-pasta adresei ir jābūt īsākai par 255 simboliem.',
            'unique' => 'Šī e-pasta adrese jau ir aizņemta.',
        ],
        'password' => [
            'required' => 'Parole ir obligāts lauks.',
            'confirmed' => 'Parolei un paroles apstiprinājuma laukam ir jāsakrīt.',
            'max' => 'Parolei ir jābūt vismaz 8 simbolu garai (ietecams izmantot arī lielos burtus un speciālos simbolus !#$ u.tml.',
        ],
      
        'height' => [
            'required' => 'Augums ir obligāts lauks.',
            'numeric' => 'Augumam ir jābūt skaitlim.',
            'min' => 'Augums nevar būt mazāks par :min cm.',
            'max' => 'Augums nevar būt lielāks par :max cm.',
        ],
        'city' => [
            'required' => 'Pilsēta ir obligāts lauks.',
            'numeric' => '',
        ],
        'rtype' => [
            'required' => 'Ieraksta tips ir obligāts lauks.',
         
        ],
        'date' => [
            'before' => 'Datums nevar būt nākotnē.',
            'required' => 'Datums ir obligāts lauks.',
         
        ],
        'startDate' => [
            'after' => 'Sākuma datums nevar būt pagātnē.',
            'required' => 'Sākuma datums ir obligāts lauks.',
         
        ],

        'value' => [
            'required' => 'Vērtība ir obligāts lauks.',
            'numeric' => '',
            'min' => 'Vērtībai ir jābūt lielākai par :min.',
            'max' => 'Vērtībai ir jābūt mazākai par :max.',
            'gt' => 'Vērtībai nevar būt mazāka par :gt.',
            'integer' => 'Vērtībai ir jābūt veselam skaitlim.',
         
        ],

        

        'goal' => [
            'required' => 'Mērķis ir obligāts lauks.',
            'min' => 'Mērķa soļu skaitam ir jābūt lielākam par :min.',
            'max' => 'Mērķa soļu skaitam ir jābūt mazākam par :max.',
            'numeric' => '',
            'integer' => 'Mērķa soļu skaitam ir jābūt veselam skaitlim.',
         
        ],
        'goalType' => [
            'required' => 'Mērķa tips ir obligāts lauks.',
         
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
