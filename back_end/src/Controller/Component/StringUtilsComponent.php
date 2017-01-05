<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;


/**
 * StringUtils component
 */
class StringUtilsComponent extends Component
{


    /**
     * Función que retorna las iniciales de cada palabra de una cadena en mayuscula ex: AMD
     * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
     * @date     2016-09-10
     * @datetime 2016-09-10T09:19:07-0500
     * @param    [type]                   $str [description]
     * @return   [type]                        [description]
     */
    public function getInitials($str){

        $parts = explode(" ", $str);

        $str = "";

        foreach ($parts as $part) {
            
           $str .= strtoupper(substr($part, 0, 1));

        }

        return $str;

    }



}
