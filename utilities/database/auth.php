<?php
    namespace Utilities\Database;

    require __DIR__.'/./query-builder.php';
    require __DIR__.'/../tools/crypt.php';
    require_once __DIR__.'/../../service-provider/general/session.php';

    use Exception;
    use Utilities\Database\QueryBuilder;
    use Utilities\Tools\Crypt;

    class Auth{
        public function Attempt(array $array, string $table = 'users') : bool {
            try {
                /**
                 * open database connection set up queyr and execute it
                 */
                $qb = new QueryBuilder();
                $qb->Connect();
                $columns = array_keys($array);
                $result = $qb->Select('*')
                             ->From($table)
                             ->Where($columns[0],'=',$array[$columns[0]], True)
                             ->GetRow();
                /**
                 * if there's no result throw Exception
                 */
                if(empty($result)){
                    throw new Exception('Invalid username');
                }

                /**
                 * verify password, if wrong throw an exception
                 */

                if(!password_verify($array[$columns[1]], $result['password'])){
                    throw new Exception('Wrong Password!');
                }

                /**
                 * Manage sesion variables
                 */
                PutSesssionArray([
                    'HasLog' => 1,
                    'uid' => $array[$columns[0]],
                ]);

                return true;
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        public function Logout() : bool {
            try {
                SessionDestruct();
                return true;
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    }