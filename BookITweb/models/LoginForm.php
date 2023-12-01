<?php

namespace app\models
{
	use app\core\Model;
    use app\models\User;
    use app\core\Application;
	/**
	 * LoginForm is the model for the login form.
	 *
	 * @version 1.0
	 * @author Trivinyx <tom.a.s.myre@gmail.com>
     * @package app\models
	 */
	class LoginForm extends Model
	{
        public string $email = '';
        public string $password = '';

        public function rules(): array
        {
            //rules come from the model
            return [
                'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
                'password' => [self::RULE_REQUIRED]
            ];
        }

        //override the labels function to provide custom labels
        public function labels(): array
        {
            //custom labels
            return [
                'email' => 'Your email',
                'password' => 'Password'
            ];
        }

        //login the user
        public function login()
        {
            //TODO: Add more anonomous login attempts errormessages to prevent bruteforce attacks
            //validate the model
            $user = User::findOne(['email' => $this->email]);
            if(!$user)
            {
                $this->addError('email', 'User does not exist with this email address');
                return false;
            }

            if(!password_verify($this->password, $user->password))
            {
                $this->addError('password', 'Password is incorrect');
                return false;
            }

            //send the user to the login function in the application, and return the result
            return Application::$app->login($user);
        }
	}
}