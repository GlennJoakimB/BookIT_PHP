<?php

namespace app\models
{
	use app\core\Model;
    use app\models\User;
    use app\core\Application;
	/**
	 * LoginForm short summary.
	 *
	 * LoginForm description.
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
            return [
                'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
                'password' => [self::RULE_REQUIRED]
            ];
        }

        public function labels(): array
        {
            return [
                'email' => 'Your email',
                'password' => 'Password'
            ];
        }

        public function login()
        {
            //TODO: Add more anonomous login attempts errormessages to prevent bruteforce attacks
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

            return Application::$app->login($user);
        }
	}
}