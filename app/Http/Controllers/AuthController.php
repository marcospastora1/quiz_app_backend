<?php

namespace App\Http\Controllers;

use App\Classes\Retorno;
use App\Models\AlunoUser;
use App\Models\ProfessorUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 *@OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      type="http",
 *     description="realize login para obter o token",
 *     name="Token",
 *     in="header",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *  )
 */

class AuthController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = new User();
    }

    /**
     * @OA\Post(
     * path="/api/app/login/professor",
     * summary="login - api.app.login.professor",
     * description ="Login professor",
     * tags={"Auth"},
     * security={ {"bearerAuth": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="email", type="string", format="email", example="professor@gmail.com"),
     *       @OA\Property(property="password", type="string", format="password", example="abc123"),
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
    public function loginProfessor(Request $request)
    {
        $credenciais = $request->all(['email', 'password']);
        if (!$this->user
            ->join('professor_users', 'users.id', '=', 'professor_users.user_id')
            ->where('users.email', $request->email)
            ->exists()) {
            return Retorno::mobileResult(false, null, 1, 401);
        }
        $token = Auth::guard('api')->attempt($credenciais, true);
        if ($token) {
            if (Auth::guard('api')->user()->status == true) {
                $dadosUser = ProfessorUser::join('users', 'users.id', 'professor_users.user_id')->where('user_id', Auth::guard('api')->user()->id)->first();
                return Retorno::mobileResult(
                    status: true,
                    data:[
                        'id' => $dadosUser->user_id,
                        'nome' => $dadosUser->nome,
                        'email' => $dadosUser->email,
                        'token' => $token
                    ],
                    codigo : null
                );
            } else {
                return Retorno::mobileResult(false, null, 1, 401);
            }
        }
        return Retorno::mobileResult(false, null, 1, 401);
    }

    /**
     * @OA\Post(
     * path="/api/app/login/aluno",
     * summary="login - api.app.login.aluno",
     * description ="Login aluno",
     * tags={"Auth"},
     * security={ {"bearerAuth": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="email", type="string", format="email", example="aluno@gmail.com"),
     *       @OA\Property(property="password", type="string", format="password", example="abc123"),
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
    public function loginAluno(Request $request)
    {
        $credenciais = $request->all(['email', 'password']);
        if (!$this->user
            ->join('aluno_users', 'users.id', '=', 'aluno_users.user_id')
            ->where('users.email', $request->email)
            ->exists()) {
            return Retorno::mobileResult(false, null, 1, 401);
        }
        $token = Auth::guard('api')->attempt($credenciais);
        if ($token) {
            if (Auth::guard('api')->user()->status == true) {
                $dadosUser = AlunoUser::join('users', 'users.id', 'aluno_users.user_id')->where('user_id', Auth::guard('api')->user()->id)->first();
                return Retorno::mobileResult(
                    status: true,
                    data: [
                        'id' => $dadosUser->user_id,
                        'nome' => $dadosUser->nome,
                        'email' => $dadosUser->email,
                        'token' => $token
                    ],
                    codigo: null
                );
            } else {
                return Retorno::mobileResult(false, null, 1, 401);
            }
        }
        return Retorno::mobileResult(false, null, 1, 401);
    }
}
