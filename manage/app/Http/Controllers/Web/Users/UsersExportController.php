<?php

namespace Vanguard\Http\Controllers\Web\Users;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Vanguard\Events\User\UpdatedByAdmin;
use Vanguard\Http\Controllers\Api\ApiController;
use Vanguard\Repositories\User\UserRepository;
use Vanguard\Services\Upload\UserAvatarManager;
use Vanguard\User;
use DB;

/**
 * Class StarController
 */
class UsersExportController extends ApiController
{
    /**
     * @var UserRepository
     */
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function export(User $user, Request $request, $options)
    {
        $email = null;
        $username = null;
        $password = null;
        $phone = null;
        $birthday = null;
        $first_name = null;
        $last_name = null;
        $avatar = null;
        $gender = null;
        $country_id = null;
        $address = null;
        $star = null;
        $note = null;

        $email_sql = null;
        $username_sql = null;
        $password_sql = null;
        $phone_sql = null;
        $birthday_sql = null;
        $first_name_sql = null;
        $last_name_sql = null;
        $avatar_sql = null;
        $gender_sql = null;
        $country_id_sql = null;
        $address_sql = null;
        $star_sql = null;
        $note_sql = null;

        $tables_sql = "id ,";

        $table_head = array(
            'id'
        );

        if (isset($_GET['email']) && $_GET['email'] == 1) {
            $email = "email";
            $tables_sql = $tables_sql . " email ,";
            array_push($table_head, "email");
        }
        if (isset($_GET['username']) && $_GET['username'] == 1) {
            $username = "username";
            $tables_sql = $tables_sql . " username ,";
            array_push($table_head, "username");
        }
        if (isset($_GET['password']) && $_GET['password'] == 1) {
            $password = "password_decrypted";
            $tables_sql = $tables_sql . " password_decrypted ,";
            array_push($table_head, "password_decrypted");
        }
        if (isset($_GET['phone']) && $_GET['phone'] == 1) {
            $phone = "phone";
            $tables_sql = $tables_sql . " phone ,";
            array_push($table_head, "phone");
        }
        if (isset($_GET['birthday']) && $_GET['birthday'] == 1) {
            $birthday = "birthday";
            $tables_sql = $tables_sql . " birthday ,";
            array_push($table_head, "birthday");
        }
        if (isset($_GET['first_name']) && $_GET['first_name'] == 1) {
            $first_name = "first_name";
            $tables_sql = $tables_sql . " first_name ,";
            array_push($table_head, "first_name");
        }
        if (isset($_GET['last_name']) && $_GET['last_name'] == 1) {
            $last_name = "last_name";
            $tables_sql = $tables_sql . " last_name ,";
            array_push($table_head, "last_name");
        }
        if (isset($_GET['avatar']) && $_GET['avatar'] == 1) {
            $avatar = "avatar";
            $tables_sql = $tables_sql . " avatar ,";
            array_push($table_head, "avatar");
        }
        if (isset($_GET['gender']) && $_GET['gender'] == 1) {
            $gender = "gender";
            $tables_sql = $tables_sql . " gender ,";
            array_push($table_head, "gender");
        }
        if (isset($_GET['country_id']) && $_GET['country_id'] == 1) {
            $country_id = "country_id";
            $tables_sql = $tables_sql . " country_id ,";
            array_push($table_head, "country_id");
        }
        if (isset($_GET['address']) && $_GET['address'] == 1) {
            $address = "address";
            $tables_sql = $tables_sql . " address ,";
            array_push($table_head, "address");
        }
        if (isset($_GET['star']) && $_GET['star'] == 1) {
            $star = "star";
            $tables_sql = $tables_sql . " star ,";
            array_push($table_head, "star");
        }
        if (isset($_GET['note']) && $_GET['note'] == 1) {
            $note = "note";
            $tables_sql = $tables_sql . " note ,";
            array_push($table_head, "note");
        }

        $tables_sql = rtrim($tables_sql, " ,");

        // echo $tables_sql . "<br>";

        function getdb()
        {
            $servername = env('DB_HOST');
            $un = env('DB_USERNAME');
            $pw = env('DB_PASSWORD');
            $db = env('DB_DATABASE');
            try {
                $conn = mysqli_connect($servername, $un, $pw, $db);
            } catch (exception $e) {
                echo 'Connection failed: ' . $e->getMessage();
            }
            return $conn;
        }

        $con = getdb();
        $Sql = 'SELECT * FROM users';
        $result = mysqli_query($con, $Sql);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=data.csv');
        $output = fopen('php://output', 'w');

        // echo json_encode($table_head);

        $table_head = array(
            'id',
            'email',
            'first_name', 
            'last_name',
            'password',
            'phone',
            'gender',
            'birthday',
            'note',
            'emails',
            'passwords'
        );

        fputcsv($output, $table_head);

        if (isset($_GET['star']) && $_GET['star'] == 1) {
            $query = "SELECT id, email, first_name, last_name, password_decrypted, phone, gender, birthday, note from users WHERE star = 1";
        } else {
            $query = "SELECT id, email, first_name, last_name, password_decrypted, phone, gender, birthday, note from users";
        }
        $result = mysqli_query($con, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            $emails = $this->multipleEmails($row['id']);
            $passwords = $this->multiplePasswords($row['id']);
            $email_array = array();
            $password_array = array();
            foreach ($emails as $email) {
                array_push($email_array, $email->email);
            }
            foreach ($passwords as $password) {
                array_push($password_array, $password->password);
            }
            array_push($row, implode(', ', $email_array));
            array_push($row, implode(', ', $password_array));
            fputcsv($output, $row);
        }
        fclose($output);
    }

    public function show(Type $var = null)
    {
        return view('user/export', [
            'socialProviders' => config('users.export')
        ]);
    }

    public function multipleEmails($user_id) {
        return DB::table('emails')
            ->where('user_id', $user_id)
            ->get('email');
    }

    public function multiplePasswords($user_id) {
        return DB::table('passwords')
            ->where('user_id', $user_id)
            ->get('password');
    }
}
// https://www.cloudways.com/blog/import-export-csv-using-php-and-mysql/