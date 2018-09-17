<?php

namespace App\Http\Controllers;

class AuditController extends Controller
{

private $respotas = [];

private $perguntas = [
        "1"=> [
            "enunciado" => "Com que frequencia voce consome bebidas alcoolicas (cerveja, vinho, cachaça, etc.)?",
            "respostas" => [
                "0" => "Nunca",
                "1" => "Uma vez por mes ou menos",
                "2" => "2 a 4 vezes por mes",
                "3" => "2 a 3 vezes por semana",
                "4" => "4 ou mais vezes por semana",
            ]
        ],
        "2"=> [
            "enunciado" => "Quantas doses, contendo alcool, voce consome num dia em que normalmente bebe.*",
            "respostas" => [
                "1" => "1 a 2",
                "2" => "3 a 4",
                "3" => "5 a 6",
                "4" => "7 a 9",
                "5" => "10 ou mais",
            ]
        ],
        "3"=> [
            "enunciado" => "Com que freqüência que você consome 6 ou mais doses de bebida alcoólica em uma única ocasião?",
            "respostas" => [
                "0" => "Nunca",            
                "1" => "Menos que mensalmente",
                "2" => "Mensalmente",
                "3" => "Semanalmente",
                "4" => "Diariamente ou quase diariamente",
            ]
        ],
        "4"=> [
            "enunciado" => "Com que freqüência, durante os últimos doze meses, você percebeu que não conseguia parar de beber uma vez que havia começado?",
            "respostas" => [
                "0" => "Nunca",            
                "1" => "Menos que mensalmente",
                "2" => "Mensalmente",
                "3" => "Semanalmente",
                "4" => "Diariamente ou quase diariamente",
            ]
        ],
        "5"=> [
            "enunciado" => "Com que freqüência, durante os últimos doze meses, você deixou de fazer algo ou atender a um compromisso devido ao uso de bebidas alcoólicas?",
            "respostas" => [
                "0" => "Nunca",            
                "1" => "Menos que mensalmente",
                "2" => "Mensalmente",
                "3" => "Semanalmente",
                "4" => "Diariamente ou quase diariamente",
            ]
        ],
        "6"=> [
            "enunciado" => "Com que freqüência, durante os últimos doze meses, você precisou de uma primeira dose pela manhã para sentir-se melhor depois de uma bebedeira?",
            "respostas" => [
                "0" => "Nunca",            
                "1" => "Menos que mensalmente",
                "2" => "Mensalmente",
                "3" => "Semanalmente",
                "4" => "Diariamente ou quase diariamente",
            ]
        ],
        "7"=> [
            "enunciado" => "Com que freqüência você sentiu-se culpado ou com remorso depois de beber?",
            "respostas" => [
                "0" => "Nunca",            
                "1" => "Menos que mensalmente",
                "2" => "Mensalmente",
                "3" => "Semanalmente",
                "4" => "Diariamente ou quase diariamente",
            ]
        ],
        "8"=> [
            "enunciado" => "Com que freqüência, durante os últimos doze meses, você não conseguiu lembrar-se do que aconteceu na noite anterior porque havia bebido?",
            "respostas" => [
                "0" => "Nunca",            
                "1" => "Menos que mensalmente",
                "2" => "Mensalmente",
                "3" => "Semanalmente",
                "4" => "Diariamente ou quase diariamente",
            ]
        ],
        "9"=> [
            "enunciado" => "Você ou outra pessoa já se machucou devido a alguma bebedeira sua?",
            "respostas" => [
                "0" => "Nunca",            
                "2" => "Sim, mas não nos últimos 12 meses",
                "4" => "Sim, nos últimos 12 meses",
            ]
        ],
        "10"=> [
            "enunciado" => "Algum parente, amigo, médico ou outro profissional de saúde mostrou-se preocupado com seu modo de beber ou sugeriu que você diminuísse a quantidade?",
            "respostas" => [
                "0" => "Nunca",            
                "2" => "Sim, mas não nos últimos 12 meses",
                "4" => "Sim, nos últimos 12 meses",
            ]
        ],
    ];

    public function listarPorId($id)
    {
        return $this-> perguntas[$id]["respostas"];
    }

    public function listarTodasPerguntas()
    {
        $apenasPerguntas = [];
        $cont = 1;
        foreach ($this-> perguntas as $pergunta) {
            $apenasPerguntas[$cont] = $pergunta["enunciado"];
            $cont++;
        }
        return $apenasPerguntas;
    }

    public function responder($idPergunta, $idResposta)
    {
        $this->respostas[$idPergunta] = $idResposta;
        return $this->respostas;
    }

    public function responderTodas($arrayPerguntas, $arrayRespostas)
    {
        $perguntas = explode("," , $arrayPerguntas);
        $respostasLocais = explode("," , $arrayRespostas);
        $cont = 0;
        foreach($perguntas as $a) {
            $this->responder($perguntas[$cont], $respostasLocais[$cont]);
            $cont++;
        }
        return $this->respostas;
    }

    public function calcular($arrayPerguntas, $arrayRespostas)
    {
        $perguntas = explode("," , $arrayPerguntas);
        $respostas = explode("," , $arrayRespostas);
        
        if (count($respostas) != count($perguntas)) {
            return response()->json(
                [
                'Erro' => 'O numero de respostas nao equivale ao numero de perguntas!'
                ]
            );
        }

        $respostas = $this -> responderTodas ($arrayPerguntas, $arrayRespostas);
        $resultado = 0;

        foreach ($perguntas as $pergunta){
            $resultado = $resultado + $respostas[$pergunta];
        }
        if ($resultado >= 0 && $resultado <=7) {
            return response()->json(
                [
                'Resultado' => $resultado,
                'Descricao' => 'Seu resultado indica consumo de bebida alcoolica de baixo risco ou abstemio.'
                ]
            );
        } elseif ($resultado >= 8 && $resultado <=15) {
            return response()->json(
                [
                'Resultado' => $resultado,
                'Descricao' => 'Seu resultado indica consumo de bebida alcoolica de risco.'
                ]
            );
        } elseif ($resultado >= 16 && $resultado <=15) {
            return response()->json(
                [
                'Resultado' => $resultado,
                'Descricao' => 'Seu resultado indica consumo de bebida alcoolica de uso nocivo ou de alto risco.'
                ]
            );
        } elseif ($resultado >= 17 && $resultado <=40) {
            return response()->json(
                [
                'Resultado' => $resultado,
                'Descricao' => 'Seu resultado indica consumo de bebida alcoolica de provavel dependencia.'
                ]
            );
        }
    }
}

//audit/listar - Lista as perguntas e o codigo
//audit/listar/{id} - Lita as possiveis respostas
//audit/responder/{idPergunta}/{idResposta}
    //$this->respostas = 