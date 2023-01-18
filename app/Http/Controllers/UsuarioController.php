<?php

namespace App\Http\Controllers;

use App\Classes\Retorno;
use App\Events\CadastroProfessor;
use App\Http\Traits\Helpers\FunctionsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class UsuarioController extends Controller
{
    use FunctionsTrait;

    /**
     * @OA\Post(
     * path="/api/app/usuarios/cadastro-professor",
     * summary="Cadastro - api.app.usuarios.cadastro.professor",
     * description ="Cadastro de usuário do tipo professor",
     * tags={"Usuários"},
     * security={ {"bearerAuth": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(
     *       required={"email","password", "nome", "registro_professor", "data_nascimento", "whatsapp"},
     *       @OA\Property(
     *          property="email",
     *          type="string",
     *          format="email",
     *          example="professor@gmail.com"
     *       ),
     *       @OA\Property(
     *          property="password",
     *          type="string",
     *          format="password",
     *          example="abc123"
     *       ),
     *       @OA\Property(
     *          property="nome",
     *          type="string",
     *          format="text",
     *          example="Professor Girafales"
     *       ),
     *       @OA\Property(
     *          property="registro_professor",
     *          type="string",
     *          format="number",
     *          example="558741"
     *       ),
     *       @OA\Property(
     *          property="data_nascimento",
     *          type="date",
     *          format="date",
     *          example="1996-09-28"
     *       ),
     *       @OA\Property(
     *          property="whatsapp",
     *          type="string",
     *          format="text",
     *          example="27996123123"
     *       ),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Successful"
     *  )
     * )
     *
     *  @return JsonResponse
     *
     */

    /**
     * @OA\Post(
     * path="/api/app/usuarios/cadastro-aluno",
     * summary="Cadastro - api.app.usuarios.cadastro.aluno",
     * description ="Cadastro de usuário do tipo aluno",
     * tags={"Usuários"},
     * security={ {"bearerAuth": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(
     *       required={"email","password", "nome", "matricula", "data_nascimento", "whatsapp"},
     *       @OA\Property(
     *          property="email",
     *          type="string",
     *          format="email",
     *          example="aluno@gmail.com"
     *       ),
     *       @OA\Property(
     *          property="password",
     *          type="string",
     *          format="password",
     *          example="abc123"
     *       ),
     *       @OA\Property(
     *          property="nome",
     *          type="string",
     *          format="text",
     *          example="Chaves Del Oitcho"
     *       ),
     *       @OA\Property(
     *          property="matricula",
     *          type="string",
     *          format="number",
     *          example="558741"
     *       ),
     *       @OA\Property(
     *          property="data_nascimento",
     *          type="date",
     *          format="date",
     *          example="1996-09-28"
     *       ),
     *       @OA\Property(
     *          property="whatsapp",
     *          type="string",
     *          format="text",
     *          example="27996123123"
     *       ),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Successful"
     *  )
     * )
     *
     *  @return JsonResponse
     *
     */

    public function cadastroUsuario(Request $request)
    {
        $tipo_rota = $request->route()->getName();
        $tipo_rota = explode('.', $tipo_rota);

        if (!isset($request['email'])) {
            return Retorno::mobileResult(false, null, 2);
        }
        if (isset($request['password'])) {
            $request['password'] = bcrypt($request['password']);
        } else {
            return Retorno::mobileResult(false, null, 3);
        }
        if (!isset($request['nome'])) {
            return Retorno::mobileResult(false, null, 4);
        }
        if (DB::table('users')->where('email', '=', $request['email'])->exists()) {
            return Retorno::mobileResult(false, null, 13);
        }
        if (last($tipo_rota) == 'professor') {
            if (!isset($request['registro_professor'])) {
                return Retorno::mobileResult(false, null, 5);
            }
            if (DB::table('professor_users')->where('whatsapp', '=', $request['whatsapp'])->exists()) {
                return Retorno::mobileResult(false, null, 10);
            }
            if (DB::table('professor_users')->where('registro_professor', '=', $request['registro_professor'])->exists()) {
                return Retorno::mobileResult(false, null, 11);
            }
        } else {
            if (!isset($request['matricula'])) {
                return Retorno::mobileResult(false, null, 5);
            }
            if (DB::table('aluno_users')->where('whatsapp', '=', $request['whatsapp'])->exists()) {
                return Retorno::mobileResult(false, null, 10);
            }
            if (DB::table('aluno_users')->where('matricula', '=', $request['matricula'])->exists()) {
                return Retorno::mobileResult(false, null, 11);
            }
        }
        if (!isset($request['data_nascimento'])) {
            return Retorno::mobileResult(false, null, 6);
        }
        if (!isset($request['whatsapp'])) {
            return Retorno::mobileResult(false, null, 7);
        }
        if (DB::table('users')->where('email', '=', $request['email'])->exists()) {
            return Retorno::mobileResult(false, null, 9);
        }

        try {
            DB::beginTransaction();
            $this->cadastroUser($request);

            $id = DB::table('users')->select('id')->where('email', '=', $request['email'])->get();
            $id = $id[0]->id;
            $tipo_id = DB::table('tipo_users')->select('id')->where('descricao', '=', 'Professor')->get();
            $tipo_id = $tipo_id[0]->id;

            if (last($tipo_rota) == 'professor') {
                DB::table('professor_users')->insert([
                    'user_id' => $id,
                    'nome' => $request['nome'],
                    'tipo_user_id' => $tipo_id,
                    'registro_professor' => $request['registro_professor'],
                    'data_nascimento' => $request['data_nascimento'],
                    'whatsapp' => $request['whatsapp'],
                    'created_at' => $this->getDateBr(),
                    'updated_at' => $this->getDateBr()
                ]);
                DB::commit();
                event(new CadastroProfessor(nomeProfessor: $request['nome'], emailProfessor: $request['email']));
            } else {
                DB::table('aluno_users')->insert([
                    'user_id' => $id,
                    'nome' => $request['nome'],
                    'tipo_user_id' => $tipo_id,
                    'matricula' => $request['matricula'],
                    'data_nascimento' => $request['data_nascimento'],
                    'whatsapp' => $request['whatsapp'],
                    'created_at' => $this->getDateBr(),
                    'updated_at' => $this->getDateBr()
                ]);
                DB::commit();
                event(new CadastroProfessor(nomeProfessor: $request['nome'], emailProfessor: $request['email']));
            }

            return Retorno::mobileResult(true, 'Cadastro realizado com sucesso', null);
        } catch (Throwable $th) {
            DB::rollback();
            return Retorno::mobileResult(false, null, 8);
        }
    }
}
