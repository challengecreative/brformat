<?php
/**
 * Created by PhpStorm.
 * User: Chall
 * Date: 22/01/14
 * Time: 11:38
 */

//namespace

class BrFormat {

    public static  function maskCpf_Cnpj($value) {
        // pega o tamanho da string menos os digitos verificadores
        $tamanho = (strlen($value) -2);
        //verifica se o tamanho do código informado é válido
        if ($tamanho != 9 && $tamanho != 12){
            return false;
        }

        // seleciona a máscara para cpf ou cnpj
        $mascara = ($tamanho == 9) ? '###.###.###-##' : '##.###.###/####-##';

        $indice = -1;
        for ($i=0; $i < strlen($mascara); $i++) {
            if ($mascara[$i]=='#') $mascara[$i] = $value[++$indice];
        }

        return $mascara;
    }

    public static function maskCpf($value) {
        return self::maskCpf_Cnpj($value);
    }

    public static function cleanCpf($value) {
        return self::getOnlyNum($value);
    }

    public static function maskCnpj($value) {
        return self::maskCpf_Cnpj($value);
    }

    public static function cleanCnpj($value) {
        return preg_replace('#[^0-9]#', '', $value);
    }

    public static function getOnlyNum($value) {
        return preg_replace('#[^0-9]#', '', $value);
    }

    public static function maskDateHour($value, $mask = 'd/m/Y') {
        $date = new DateTime($value);
        return $date->format($mask);
    }

    public static function maskPhone($value) {
        $formatted = '';
        if($value != null ) {
            $ddd = substr($value, 0, 2);
            if(strlen($value) == 11) {
                //prefix with 9....
                $prefix = substr($value, 2, 5);
                $number = substr($value, 7);
            } else {
                $prefix = substr($value, 2, 4);
                $number = substr($value, 6);
            }


            $formatted = '(' . $ddd . ') ' . $prefix . '-' . $number;
        }
        return $formatted;
    }

    public static function getMaritalOptions() {
        return $opt = array(
            'casado' => 'Casado(a)',
            'separado' => 'Separado(a)',
            'solteiro' => 'Solteiro(a)',
            'viuvo' => 'Viúvo(a)',
            'outro' => 'Outro'
        );
    }

    public static function getStateOptions() {
        return array(
            'AC' => 'AC',
            'AL' => 'AL',
            'AM' => 'AM',
            'AP' => 'AP',
            'BA' => 'BA',
            'CE' => 'CE',
            'DF' => 'DF',
            'ES' => 'ES',
            'GO' => 'GO',
            'MA' => 'MA',
            'MT' => 'MT',
            'MS' => 'MS',
            'MG' => 'MG',
            'PA' => 'PA',
            'PB' => 'PB',
            'PR' => 'PR',
            'PE' => 'PE',
            'PI' => 'PI',
            'RJ' => 'RJ',
            'RN' => 'RN',
            'RO' => 'RO',
            'RS' => 'RS',
            'RR' => 'RR',
            'SC' => 'SC',
            'SE' => 'SE',
            'SP' => 'SP',
            'TO' => 'TO'
        );
    }

    public static function getMonths() {
        return $months = array(
            '01' => 'Janeiro',
            '02' => 'Fevereiro',
            '03' => 'Março',
            '04' => 'Abril',
            '05' => 'Maio',
            '06' => 'Junho',
            '07' => 'Julho',
            '08' => 'Agosto',
            '09' => 'Setembro',
            '10' => 'Outubro',
            '11' => 'Novembro',
            '12' => 'Dezembro',

        );
    }

    public static function getBloodOptions() {
        return $opt = array(
            'A' => 'A',
            'B' => 'B',
            'AB' => 'AB',
            'O' => 'O'
        );
    }

    public static function getBloodSignalOptions() {
        return $opt = array(
            '+' => '+',
            '-' => '-'
        );
    }

    public static function joinName($entity, $format = 'normal') {
        if(!isset($entity)) {
            //TODO: tratar com exception
            return false;
        }

        $first = $entity['first_name'];
        $middle = $entity['middle_name'];
        $last = $entity['last_name'];
        if(!empty($middle)) {
            $first .= ' ' . $middle;
        }
        switch($format) {
            case 'normal':
                $name = $first . ' ' . $last;
                break;
            case 'last':
                $name = $last . ', ' . $first;
                break;
        }
        return $name;
    }

    public static function formatName($name, $encoding = 'utf-8') {
        $arrayName = explode(' ', $name); //Retorna uma matriz de strings da variavel nome, separando pelos espacos
        $sizeArray = count($arrayName);  //Conta a quantidade de elementos do array
        $arrayConnectors = array('', 'da', 'de', 'di', 'do', 'du', 'das', 'dos', 'e');
        $formattedName = '';

        for ($cont = 0; $cont < $sizeArray; $cont++) {
            $temp = $arrayName[$cont];
            $temp = mb_strtolower($temp, $encoding);

            if (array_search($temp, $arrayConnectors) == null)
                $formattedName .= ucfirst($temp) . " ";
            else
                $formattedName .= $temp . " ";
        }
        return(trim($formattedName));
    }

}
