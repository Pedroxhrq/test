<?php

namespace App\Http\Controllers;

class CalculoController extends Controller

{
	public function imc($peso, $altura)
	{
		return ($peso / ($altura * $altura) * 10000);
	}

	private function delta($a, $b, $c)
	{
		return (($b * $b) - ((4 * $a) * $c));
	}

	private function erro($mensagem)
	{
		return response()->json(
            [
                'status' => "erro",
                'mensagem' => $mensagem
            ]
        );
	}

	public function bhaskara($a, $b, $c)
	{
		if ($a == 0)
		{
			return $this->erro("O valor de A nao pode ser igual a zero!");
		}

		$delta = $this->delta($a, $b, $c);
		if ($delta < 0)
		{
			return $this->erro("O valor de Delta nao pode ser negativo!");
		}
		else
		{
			$x1 = (-$b + sqrt($delta)) / (2 * $a);
			$x2 = (-$b - sqrt($delta)) / (2 * $a);
			return response()->json(
                [
                    'x1' => $x1,
                    'x2' => $x2
                ]
            );
		}
	}
}