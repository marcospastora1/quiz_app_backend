<?php

namespace App\Http\Controllers;

use App\Classes\Retorno;
use App\Models\QuizStatus;
use Illuminate\Http\Request;
use Throwable;

class QuizController extends Controller
{
    private $quizStatus;

    public function __construct()
    {
        $this->quizStatus = new QuizStatus();
    }


    /**
     * @OA\Get(
     * path="/api/quiz/status/listar",
     * summary="contextos - api.quiz.status.listar",
     * description ="Listagem status do quiz",
     * tags={"quiz"},
     * security={ {"bearerAuth": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Successful")
     * )
     *
     *  @return JsonResponse
     *
     */
    public function listarStatus()
    {
        try {
            return Retorno::webResult(true, $this->quizStatus->retornaStatus(), null);
        } catch (Throwable $th) {
            return Retorno::webResult(false, null, 'Falha ao pegar status do quiz');
        }
    }
}