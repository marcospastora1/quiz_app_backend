<?php

namespace App\Http\Controllers;

use App\Classes\Retorno;
use App\Events\CadastroProfessor;
use App\Http\Traits\AuthTrait;
use App\Http\Traits\Helpers\FunctionsTrait;
use App\Models\Disciplina;
use App\Models\QuizStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class QuizController extends Controller
{
    use FunctionsTrait;
    use AuthTrait;

    private $quizStatus;
    private $disciplinas;

    public function __construct()
    {
        $this->quizStatus = new QuizStatus();
        $this->disciplinas = new Disciplina();
    }


    /**
     * @OA\Get(
     * path="/api/app/quiz/status/listar",
     * summary="quiz - api.app.quiz.status.listar",
     * description ="Listagem status do quiz",
     * tags={"Quiz"},
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
            return Retorno::mobileResult(status: true, data: $this->quizStatus->retornaStatus(), codigo: null);
        } catch (Throwable $th) {
            dd($th);
            return Retorno::mobileResult(false, null, 0, 400);
        }
    }

    /**
     * @OA\Get(
     * path="/api/app/quiz/disciplinas/listar",
     * summary="quiz - api.app.quiz.disciplinas.listar",
     * description ="Listagem de disciplinas",
     * tags={"Quiz"},
     * security={ {"bearerAuth": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Successful")
     * )
     *
     *  @return JsonResponse
     *
     */

    public function listarDisciplina()
    {
        try {
            return Retorno::mobileResult(status: true, data: $this->disciplinas->retornaDisciplinas(), codigo: null);
        } catch (Throwable $th) {
            return Retorno::mobileResult(false, null, 0, 404);
        }
    }


    /**
     * @OA\Post(
     * path="/api/app/quiz/cadastrar",
     * summary="quiz - api.app.quiz.cadastrar",
     * description ="Rota para cadastr do quiz",
     * tags={"Quiz"},
     * security={ {"bearerAuth": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(
     *       required={"titulo", "disciplina_id", "numero_questoes", "tempo_horas", "questions" },
     *       @OA\Property(property="titulo", type="string", format="text", example="Quiz Matemática"),
     *       @OA\Property(property="disciplina_id", type="integer", format="numeric", example="2"),
     *       @OA\Property(property="numero_questoes", type="integer", format="numeric", example="5"),
     *       @OA\Property(property="tempo_horas", type="float", format="numeric", example="2"),
     *
     *       @OA\Property(property="questions", type="array",
     *          @OA\Items(type="object",
     *          @OA\Property(property="question", type="string", format="text", example="São três exemplos de sólidos geométricos:"),
     *          @OA\Property(
     *              property="answers",
     *              type="array",
     *              example={
     *                 {
     *                     "resposta": "cubo, paralelepípedo, pirâmide",
     *                     "verdadeira": true
     *                 },
     *                 {
     *                     "resposta": "cubo, pirâmide e quadrado",
     *                     "verdadeira": false
     *                 },
     *                 {
     *                     "resposta": "prisma, círculo e cone",
     *                     "verdadeira": false
     *                 },
     *                 {
     *                     "resposta": "retângulo, trapézio e losango",
     *                     "verdadeira": false
     *                 }
     *              },
     *                  @OA\Items(type="object",
     *                      required={"resposta", "verdadeira"},
     *              ),
     *           ),
     *        ),
     *      ),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Successful")
     * )
     *
     *  @return JsonResponse
     *
     */
    public function cadastrarQuiz(Request $request)
    {

        $i = 0;
        $id = $this->retornaUserId();
        $professor_user_id = DB::table('professor_users')->select('id')->where('user_id', '=', $id)->get();
        $professor_user_id = $professor_user_id[0]->id;

        if (!isset($request['titulo'])) {
            return Retorno::mobileResult( false, null, 15, 404);
        }
        if (!isset($request['disciplina_id'])) {
            return Retorno::mobileResult( false, null, 16, 404);
        }
        if (!isset($request['tempo_horas'])) {
            return Retorno::mobileResult( false, null, 19, 404);
        }
        if ($request['numero_questoes'] != count($request['questions'])) {
            return Retorno::mobileResult( false, null, 17, 404);
        }
        if ($request['numero_questoes'] != count($request['questions'])) {
            return Retorno::mobileResult( false, null, 17, 404);
        }
        foreach ($request['questions'] as $question) {
            if (count($question['answers']) != 4) {
                return Retorno::mobileResult( false, null, 18, 404);
            }
            foreach ($question['answers'] as $answer) {
                if ($answer['verdadeira'] == true) {
                    $i++;
                }
            }
        }
        if ($i > $request['numero_questoes']) {
            return Retorno::mobileResult( false, null, 20, 404);
        }
        if ($i < $request['numero_questoes']) {
            return Retorno::mobileResult( false, null, 21, 404);
        }

        try {

            DB::beginTransaction();
            DB::table('quiz')->insert([
                "descricao" => $request['titulo'],
                "disciplina_id" => $request['disciplina_id'],
                "professor_user_id" => $professor_user_id,
                "quiz_status_id" => true,
                "chave" => $this->geraChave(5),
                "numero_questoes" => $request['numero_questoes'],
                "tempo_horas" => $request['tempo_horas'],
                'created_at' => $this->getDateBr(),
                'updated_at' => $this->getDateBr()
            ]);

            $quiz_id = DB::table('quiz')->select('id')->orderBy('id', 'desc')->first();
            $quiz_id = $quiz_id->id;

            foreach ($request['questions'] as $question) {
                DB::table('questions')->insert([
                    "quiz_id" => $quiz_id,
                    "descricao" => $question['question'],
                    'created_at' => $this->getDateBr(),
                    'updated_at' => $this->getDateBr()
                ]);
                $question_id = DB::table('questions')->select('id')->orderBy('id', 'desc')->first();
                $question_id = $question_id->id;
                foreach ($question['answers'] as $answer) {
                    DB::table('answers')->insert([
                        "question_id" => $question_id,
                        "descricao" => $answer['resposta'],
                        "correta" => $answer['verdadeira'],
                        'created_at' => $this->getDateBr(),
                        'updated_at' => $this->getDateBr()
                    ]);
                }
            }
            DB::commit();
            return Retorno::mobileResult(status: true, data: 'Quiz Cadastrado com sucesso', codigo: null);
        } catch (Throwable $th) {
            DB::rollback();
            return Retorno::mobileResult( false, null, 22, 404);
        }
    }
}
